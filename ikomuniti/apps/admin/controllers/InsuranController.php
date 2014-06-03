<?php

namespace JunMy\Admin\Controllers;

use JunMy\Components\Pagination\Pagination;
use JunMy\Models\Notifications;
use JunMy\Models\Transactions;
use JunMy\Models\Insuran;
use JunMy\Models\Users;
use JunMy\Models\Wallets;
use JunMy\Models\Renewalhistories;
	
class InsuranController extends ControllerBase {
 
    public $paginationUrl;
    
    public $amount_to_pay;
    
    public $pagination_updated;
     
    
    public function initialize() {
        //Set the document title
        $this->tag->setTitle('iTakaful');
        parent::initialize();
    }

	public function manageAction() { 
		parent::pageProtect();
		$this->flashSession->output();
		$auth = $this->session->get('junauth'); 
		$this->role($auth['role'], array(3, 4, 5, 6, 7));
		$this->view->setVar('navigations', $this->get_user($auth['id']));
		$this->view->setVar('views', $this->view_user()); 
		$this->view->count_imanagement = count($this->count_view_user());
		$this->view->paginationUrl = $this->paginationUrl;
	}
	
	/*
    *    View user on pagination where quotation done
    *
    */
	public function quotationAction() {
		parent::pageProtect();
		 
		$auth = $this->session->get('junauth');
		$this->role($auth['role'], array(3, 4, 5, 6, 7));
		$this->view->setVar('navigations', $this->get_user($auth['id']));
	    $this->view->setVar('views', $this->view_user_updated());
	    $this->view->paginationUrl = $this->paginationUrl;
	    $this->view->count_updated = count($this->count_updated());
	}
	
	public function updateAction() {
		parent::pageProtect();
		//Jika post update 
		$auth = $this->session->get('junauth');
		$this->role($auth['role'], array(3, 4, 5, 6, 7));
		$this->view->setVar('navigations', $this->get_user($auth['id']));
		// View user request for additional insurance
		$id = $this->dispatcher->getParam('slug');
		//print_r($_POST);
		 
		if($this->request->isPost()) {
			$created = date('Y-m-d H:i:s'); 
			$insuran_amount = str_replace(',', '', $this->request->getPost('insuran_amount'));  
			$road_tax = $this->request->getPost('road_tax');
		    $cover = $this->request->getPost('cover');
		    $service_charge = $this->request->getPost('service_charge');
		    $user_id = $this->request->getPost('user_id');
		    $due_date = $this->request->getPost('due_date');
		    $wind_screen = $this->request->getPost('wind_screen');
		    $second_driver = $this->request->getPost('second_driver');
		    $sms = $this->request->getPost('sms');
		    $pa = $this->request->getPost('pa');
		    $crp = $this->request->getPost('crp');
		    $ncd = $this->request->getPost('insuran_ncb');
		    $total = $service_charge + $insuran_amount + $road_tax + $crp; 
		    
			if(is_numeric($insuran_amount) < 250) {
				$this->flash->error('Please enter Insurance Amount (Min RM250)');
			} elseif ($cover == '0.00') { 
				$this->flash->error('Please enter Cover Amount');
			} elseif($sms == 0) {
				$this->flash->error('Please choose SMS delivery status');
			} elseif($insuran_amount < 500 && $crp == 78) {
				$this->flash->error('Not valid CRP amount. Choose RM120 if premium less than RM500.');
			} else {
			    $quot = Insuran::findFirst("user_id = '$user_id'");
			    $quot->insurance = $insuran_amount;
			    $quot->road_tax = $road_tax;
			    $quot->cover = $cover;
			    $quot->service_charge = $service_charge;
			    $quot->wind_screen = $wind_screen;
			    $quot->second_driver = $second_driver;
			    $quot->total = $total;
			    $quot->created = $created;
			    $quot->pa = $pa;
			    $quot->crp = $crp;
			    
			    // Update insurance amount
				/*$phql = "UPDATE JunMy\Models\Insuran SET 
				insurance = '$insuran_amount', road_tax = '$road_tax', 
				cover = '$cover', service_charge = '$service_charge', wind_screen = '$wind_screen',
				second_driver = '$second_driver',
				total = '$total', created = '$created', pa = '$pa', crp = '$crp' WHERE user_id = '$user_id'";
				$update = $this->modelsManager->executeQuery($phql);*/
				if($quot->save()) {
				    if($this->update_notification($user_id, $due_date, $insuran_amount, $road_tax, $cover, $total)) {
						// Send SMS
						if($sms == 1) {
						    $smsuser = Users::findFirst($user_id);
						    $ipoint = Wallets::findFirst($user_id);
						    if($ipoint->amount < $total) {
								$amount_to_pay = $total - $ipoint->amount;
							} elseif($ipoint->amount >= $total) {
								$amount_to_pay = 0.00;
							}
							// Send SMS here
							$this->sms_update($cover, $smsuser->telephone, $smsuser->reg_number, $due_date, $insuran_amount, 
							$road_tax, $service_charge, $total, $ipoint->amount, $amount_to_pay, $wind_screen, $crp, $ncd, $pa);
						}
						$this->flashSession->success('Insurance amount has been updated');
						return $this->response->redirect('gghadmin/insuran/manage');
					}
				} else {
					foreach ($quot->getMessages() as $message) {
		                $this->flash->error((string) $message);
		            }
				}
			}
		}   
		// Request new quotation
		$this->view->setVar('reqs', $this->view_request($id));
	    $this->view->setVar('updates', $this->view_user_update($id));
	    $this->view->setVar('profiles', $this->get_user_profile($id)); 
	}
	
	private function view_request($id) {
		$phql = "SELECT windscreen, crp, additional_driver, DATE_FORMAT(created,'%d %b %h:%i %p') AS created, status 
		FROM JunMy\Models\Insurancerequests WHERE user_id = '$id' ORDER BY id DESC LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql);
	 
		return $rows;
	}
	
	/*
    *    View all user
    *
    */
	public function allAction() {
		parent::pageProtect();
		$auth = $this->session->get('junauth');
		$this->role($auth['role'], array(3, 4, 5, 6, 7)); 
	    $this->view->setVar('navigations', $this->get_user($auth['id']));
	    $this->view->setVar('views', $this->view_all_user());
	    $this->view->paginationUrl = $this->paginationUrl; 
	}
	
	/*
    *    View user on pagination where type = 1
    *
    */
	public function problemsAction() {
		parent::pageProtect();
		$this->flashSession->output();
		$auth = $this->session->get('junauth');
		$this->role($auth['role'], array(5, 6, 7)); 
		$this->view->setVar('navigations', $this->get_user($auth['id'])); 
		
		$this->view->count_user_kiv = count($this->count_user_problem(1)); // count_user_kiv
		// Restore user from kiv lists
		if($this->request->isGet() && isset($_GET['user_id']) && isset($_GET['ref'])) {
		    $user_id = $_GET['user_id'];
		    $ref = $_GET['ref'];
			if(is_numeric($user_id)) {
				// Proceed restore
				if($this->restore($user_id)) { 
					$this->flashSession->success('User has been restore to iTakaful');
					return $this->response->redirect('gghadmin/insuran/problems');
				} 
			} else {
				$this->flash->error('Error! Not valid User Id');
			}
		}
		$this->view->setVar('views', $this->view_user_problem(1)); // view_user_kiv
		    
		$this->view->paginationUrl = $this->paginationUrl;
	}
	
	/*
    *    View user on pagination where type = 2
    *
    */
	public function kivAction() {
		parent::pageProtect();
		$this->flashSession->output();
		$auth = $this->session->get('junauth');
		$this->role($auth['role'], array(5, 6, 7)); 
		$this->view->setVar('navigations', $this->get_user($auth['id'])); 
		
		$this->view->count_user_kiv = count($this->count_user_problem(2)); // count_user_kiv
		// Restore user from kiv lists
		if($this->request->isGet() && isset($_GET['user_id']) && isset($_GET['ref'])) {
		    $user_id = $_GET['user_id'];
		    $ref = $_GET['ref'];
			if(is_numeric($user_id)) {
				// Proceed restore
				if($this->restore($user_id)) { 
					$this->flashSession->success('User has been restore to iTakaful');
					return $this->response->redirect('gghadmin/insuran/kiv');
				} 
			} else {
				$this->flash->error('Error! Not valid User Id');
			}
		}
		$this->view->setVar('views', $this->view_user_problem(2)); // view_user_kiv
		    
		$this->view->paginationUrl = $this->paginationUrl;
	}
	
	/*
    *    Restore user from kiv
    *    Return BOOLEAN
    */
	private function restore($user_id) {  
	    $user = Insuran::findFirst("user_id = '$user_id'");
	    $user->type = 0;
	    if($user->save()) {
			return true;
		}
	}
	
	/*
    *    Add user to kiv
    *
    */
	public function addtokivAction() {
	    parent::pageProtect();
	    $auth = $this->session->get('junauth');
	    $this->role($auth['role'], array(5, 6, 7));
		$this->view->setVar('navigations', $this->get_user($auth['id']));
		
		if(isset($_GET['action'])) {
			if($_GET['action'] == 'problem') {
				$type = 1;
				$action = 'Problem Lists';
			} elseif($_GET['action'] == 'kiv') {
				$type = 2;
				$action = 'Kiv Lists';
			}
			
			$user_id = $_GET['user_id']; 
			$user = Users::findFirst($user_id);
			    
			$telephone = $user->telephone;
			$reg_number = $user->reg_number;
			$username = $user->username;
			
			$insuran = Insuran::findFirst("user_id = '$user_id'");
			$due_date = $insuran->next_renewal;
			
		    $phql = "UPDATE JunMy\Models\Insuran SET 
			type = '$type' WHERE user_id = '$user_id'";
			$update = $this->modelsManager->executeQuery($phql);
			if($update) { 
			    //$this->send_sms_problem($username, $reg_number, $telephone, $due_date);
			    $this->flashSession->success($username.' has been store to '.$action);
				return $this->response->redirect('gghadmin/insuran/manage');
			    
			} else {
				$this->flash->error('Cant save');
			}	
			
		}
		
	
	}
	
	/*
    *    View user on pagination where done renew with ishare
    *
    */
	public function doneAction() {
		parent::pageProtect();
		$auth = $this->session->get('junauth');
		$this->role($auth['role'], array(3, 4, 5, 6, 7)); 
	    $this->view->setVar('navigations', $this->get_user($auth['id']));
	    $this->view->setVar('views', $this->view_user_done());
	    
	    $this->view->count_user_done = count($this->count_user_done());
	    
		$this->view->paginationUrl = $this->paginationUrl; 
	}
	
	private function send_sms_problem($username, $reg_number, $telephone, $due_date) {
		$sms_username = "ishare.com.my";
        $sms_password = "rahsiajun.228";
		$sms_dstno = $telephone;
        $sms_msg ='Soft Reminder from iShare. Harap maklum bahawa maklumat profil '.$username.' ('.$reg_number.' Due Date: '.$due_date.') di dalam sistem iShare tidak lengkap atau terdapat masalah teknikal. Pihak Takaful iShare tidak dapat meneruskan proses urusan memperbaharui Takaful dan Cukai Jalan kenderaan anda sehingga masalah ini selesai. Sila hubungi iShare dengan SEGERA. Hotline: 03 8922 2277 / 03 8927 5228 / 012 684 3369 / 012 658 8135 / 012 298 0228 (Call / SMS / Whatsapp - Hari Bekerja 9.00 pagi - 6.00 petang)';

        $sms_type = 1;
        $sms_senderid = 1;
        $sms_sendlink = "http://www.isms.com.my/isms_send.php?un=".urlencode($sms_username)."&pwd=".urlencode($sms_password)."&dstno=".$sms_dstno."&msg=".urlencode($sms_msg)."&type=".$sms_type."&sendid=".$sms_senderid; 
        fopen($sms_sendlink, "r");
	}
	
	/*
    *    View user on pagination order by due date
    *    Used on manageAction
    */
    private function view_user() {
	    $type = 0;
		$time = strtotime(date('Y-m-d'));
        $due_date = date("Y-m-d", strtotime("+1 month", $time));
        $created = date("Y-m-d", strtotime("-6 month", $time));
			
	    $records_per_page = 30;
	    $paginations = new Pagination();
        $paginate = (($paginations->get_page() - 1) * $records_per_page);
		$phql = "SELECT
		    u.id AS id, 
			u.username AS username, 
			u.telephone AS tel, 
			u.reg_number AS reg_no, 
			u.owner_name AS owner,  
			u.model AS model, 
			u.year_make AS year,
			u.role AS role,
			w.amount AS amount,
		    
		    i.insurance AS ins_amount, 
			i.road_tax AS r_amount, 
			i.total AS total, 
			i.next_renewal AS due, i.tracking_code AS tracking_code, i.delivery_method AS delivery_method, i.crp AS crp, i.pa AS pa
		    
			FROM JunMy\Models\Users AS u
			LEFT JOIN JunMy\Models\Wallets AS w ON(w.id = u.id)
			LEFT JOIN JunMy\Models\Insuran AS i ON(i.user_id = u.id)
			WHERE i.type = '$type' AND i.created <= '$created' AND i.next_renewal <= '$due_date'".$this->search_parameter().$this->search_date()." AND u.role >= '3' ORDER BY DATE(i.next_renewal) ASC";
		 
		$count = $this->modelsManager->executeQuery($phql);	
		 
		
        $paginations->records(count($count));
        $rows = $this->modelsManager->executeQuery($phql." LIMIT $paginate , $records_per_page");	
        // records per page
        $paginations->records_per_page($records_per_page);
		$this->paginationUrl = $paginations->render();

		return $rows;
	
	}
	
	/*
    *    View user on pagination order by due date
    *    Used on manageAction
    */
    private function count_view_user() {
	    $type = 0;
		$time = strtotime(date('Y-m-d'));
        $due_date = date("Y-m-d", strtotime("+1 month", $time));
        $created = date("Y-m-d", strtotime("-6 month", $time)); 
		$phql = "SELECT
		    u.id AS id,  
			w.amount AS amount, 
		    i.insurance AS ins_amount 
			FROM JunMy\Models\Users AS u
			 LEFT JOIN JunMy\Models\Wallets AS w ON(w.id = u.id)
			LEFT JOIN JunMy\Models\Insuran AS i ON(i.user_id = u.id)
			WHERE (i.type = '$type' AND i.created <= '$created' AND i.next_renewal <= '$due_date'".$this->search_parameter().$this->search_date()." 
			AND u.role >= '3')";
		 
		$rows = $this->modelsManager->executeQuery($phql);	 
		return $rows; 
	}
 	
	/*
    *    View user on pagination order by due date
    *
    */
    private function view_all_user() {
	 
	    $records_per_page = 30;
	    $paginations = new Pagination();
        $paginate = (($paginations->get_page() - 1) * $records_per_page);
		$phql = "SELECT
		    u.id AS id, 
			u.username AS username, 
			u.telephone AS tel, 
			u.reg_number AS reg_no, 
			u.owner_name AS owner,  
			u.model AS model, 
			u.year_make AS year,
			
			w.amount AS amount,
		    
		    i.insurance AS ins_amount, 
			i.road_tax AS r_amount, 
			i.total AS total, 
			i.next_renewal AS due, i.tracking_code AS tracking_code, i.delivery_method AS delivery_method, i.crp AS crp, i.pa AS pa
			FROM JunMy\Models\Users AS u
			 LEFT JOIN JunMy\Models\Wallets AS w ON(w.id = u.id)
			LEFT JOIN JunMy\Models\Insuran AS i ON(i.user_id = u.id)
			WHERE i.created <= '$created' AND i.type = '0' AND u.role != '0'
			ORDER BY i.next_renewal ASC";
		$count = $this->modelsManager->executeQuery($phql);	
        $paginations->records(count($count));
        $rows = $this->modelsManager->executeQuery($phql." LIMIT $paginate , $records_per_page");	
        // records per page
        $paginations->records_per_page($records_per_page);
		$this->paginationUrl = $paginations->render();

		return $rows;
	
	}
	
	/*
    *  View user on pagination order by due date
    *
    */
    private function view_user_problem($type) {
		
	    $records_per_page = 30;
	    $paginations = new Pagination();
        $paginate = (($paginations->get_page() - 1) * $records_per_page);
		$phql = "SELECT
		    u.id AS id, 
			u.username AS username, 
			u.telephone AS tel, 
			u.reg_number AS reg_no, 
			u.owner_name AS owner,  
			u.model AS model, 
			u.year_make AS year,
			u.role AS role,
			w.amount AS amount,
		    
		    i.insurance AS ins_amount, 
			i.road_tax AS r_amount, 
			i.total AS total, 
			i.next_renewal AS due, i.tracking_code AS tracking_code, i.delivery_method AS delivery_method, i.crp AS crp, i.pa AS pa
			FROM JunMy\Models\Users AS u
			 LEFT JOIN JunMy\Models\Wallets AS w ON(w.id = u.id)
			LEFT JOIN JunMy\Models\Insuran AS i ON(i.user_id = u.id)
			WHERE u.role >= '3' AND i.type = '$type' ".$this->search_parameter().$this->search_date()." 
			ORDER BY i.next_renewal ASC";
		$count = $this->modelsManager->executeQuery($phql);	
        $paginations->records(count($count));
        $rows = $this->modelsManager->executeQuery($phql." LIMIT $paginate , $records_per_page");	
        // records per page
        $paginations->records_per_page($records_per_page);
		$this->paginationUrl = $paginations->render();

		return $rows;
	
	}
	
	/*
    *  View user on pagination order by due date
    *
    */
    private function count_user_problem($type) { 
		$phql = "SELECT
		    u.id AS id,  
			w.amount AS amount, 
		    i.insurance AS ins_amount 
			FROM JunMy\Models\Users AS u
			 LEFT JOIN JunMy\Models\Wallets AS w ON(w.id = u.id)
			LEFT JOIN JunMy\Models\Insuran AS i ON(i.user_id = u.id)
			WHERE u.role >= '3' AND i.type = '$type' ".$this->search_parameter().$this->search_date()."";
		$rows = $this->modelsManager->executeQuery($phql);	 
		return $rows;
	
	}
	
	

	/*
    *    Select user where done updating
    *    Used private on quotationAction
    *    Return OBJECT
    */
    private function view_user_updated() {
     
		$time = strtotime(date('Y-m-d'));
        $created = date("Y-m-d", strtotime("-11 month", $time));
        $due_date = date("Y-m-d", strtotime("+1 month", $time));
        
	    $records_per_page = 30;
	    $paginations = new Pagination();
        $paginate = (($paginations->get_page() - 1) * $records_per_page);
		$phql = "SELECT
		    u.id AS id, 
			u.username AS username, 
			u.telephone AS tel, 
			u.reg_number AS reg_no, 
			u.owner_name AS owner,  
			u.model AS model, 
			u.year_make AS year, 
			u.role AS role,
			w.amount AS amount, 
		    i.insurance AS ins_amount, 
			i.road_tax AS r_amount, 
			i.total AS total, 
			i.next_renewal AS due, i.tracking_code AS tracking_code, i.delivery_method AS delivery_method, i.crp AS crp, i.pa AS pa
			FROM JunMy\Models\Users AS u
			 LEFT JOIN JunMy\Models\Wallets AS w ON(w.id = u.id)
			LEFT JOIN JunMy\Models\Insuran AS i ON(i.user_id = u.id)
			WHERE (i.next_renewal <= '$due_date' AND i.created >= '$created' AND u.role >= '3' AND i.type = '0'".$this->search_parameter().$this->search_date().") ORDER BY i.next_renewal ASC";
			
		$count = $this->modelsManager->executeQuery($phql);	
        $paginations->records(count($count));
        $rows = $this->modelsManager->executeQuery($phql." LIMIT $paginate , $records_per_page");	
        // records per page
        $paginations->records_per_page($records_per_page);
		$this->paginationUrl = $paginations->render();

		return $rows;
	
	}
	
		/*
    *    Select user where done updating
    *    Used private on quotationAction
    *    Return OBJECT
    */
    private function count_updated() {
     
		$time = strtotime(date('Y-m-d'));
        $created = date("Y-m-d", strtotime("-11 month", $time)); 
        $due_date = date("Y-m-d", strtotime("+1 month", $time));
		$phql = "SELECT
		    u.id AS id,   
			w.amount AS amount, 
		    i.insurance AS ins_amount 
			FROM JunMy\Models\Users AS u
			LEFT JOIN JunMy\Models\Wallets AS w ON(w.id = u.id)
			LEFT JOIN JunMy\Models\Insuran AS i ON(i.user_id = u.id)
		WHERE (i.next_renewal <= '$due_date' AND i.created >= '$created' AND u.role >= '3' AND i.type = '0'".$this->search_parameter().$this->search_date().")";
		$rows = $this->modelsManager->executeQuery($phql); 
		return $rows; 
	}
	
	private function pagination() {
		return $this->pagination_updated;
	}

	/*
    *    Select user where done updating
    *    Used private on quotationAction
    *    Return OBJECT
    */
    private function view_user_done() {
     
		$time = strtotime(date('Y-m-d'));
        $created = date("Y-m-d", strtotime("+1 month", $time));
        
	    $records_per_page = 30;
	    $paginations = new Pagination();
        $paginate = (($paginations->get_page() - 1) * $records_per_page);
		$phql = "SELECT
		    u.id AS id, 
			u.username AS username, 
			u.telephone AS tel, 
			u.reg_number AS reg_no, 
			u.owner_name AS owner,  
			u.model AS model, 
			u.year_make AS year, 
			u.role AS role,
			w.amount AS amount, 
		    i.insurance AS ins_amount, 
			i.road_tax AS r_amount, 
			i.total AS total, 
			i.next_renewal AS due, i.tracking_code AS tracking_code, i.delivery_method AS delivery_method, i.crp AS crp, i.pa AS pa
			FROM JunMy\Models\Users AS u
			LEFT JOIN JunMy\Models\Wallets AS w ON(w.id = u.id)
			LEFT JOIN JunMy\Models\Insuran AS i ON(i.user_id = u.id)
			WHERE i.next_renewal > '$created' AND u.role >= '3' AND i.type = '0'".$this->search_parameter().$this->search_date()." ORDER BY i.next_renewal ASC";
		$count = $this->modelsManager->executeQuery($phql);	
        $paginations->records(count($count));
        $rows = $this->modelsManager->executeQuery($phql." LIMIT $paginate , $records_per_page");	
        // records per page
        $paginations->records_per_page($records_per_page);
		$this->paginationUrl = $paginations->render();

		return $rows;
	
	}
	
	/*
    *    Select user where done updating
    *    Used private on quotationAction
    *    Return OBJECT
    */
    private function count_user_done() {
     
		$time = strtotime(date('Y-m-d'));
        $created = date("Y-m-d", strtotime("+1 month", $time));
         
		$phql = "SELECT
		    u.id AS id,  
			w.amount AS amount, 
		    i.insurance AS ins_amount 
			FROM JunMy\Models\Users AS u
			 LEFT JOIN JunMy\Models\Wallets AS w ON(w.id = u.id)
			LEFT JOIN JunMy\Models\Insuran AS i ON(i.user_id = u.id)
			WHERE i.next_renewal > '$created' AND u.role >= '3' AND i.type = '0'".$this->search_parameter().$this->search_date()." ORDER BY i.next_renewal ASC";
		$rows = $this->modelsManager->executeQuery($phql);	
         
		return $rows;
	
	}

	
	
	private function get_user_profile($id) {
	    $phql = "SELECT * FROM JunMy\Models\Users WHERE id = :param: LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql, array('param' => $id));
		 
		return $rows;
	}
	
	public function renewAction() {
		parent::pageProtect();
		$auth = $this->session->get('junauth');
		$this->role($auth['role'], array(6, 7, 8, 9));
		// Set date picker year + 3 year
		$this->view->date_picker_from = date('Y');
		$this->view->date_picker_to = date('Y', strtotime('+3 years'));
		
		$id = $this->dispatcher->getParam('slug');
		
		 
		
		if($this->request->isPost()) { 
		 
		    $oneYearOn = date('Y-m-d',strtotime(date("Y-m-d", time()) . " + 345 day"));
		    
		     
			if($this->request->getPost('insuran_amount') == 0.00) {
				$this->flash->error('Please enter insurance amount');
			} elseif($this->request->getPost('cover') == 0.00) {
				$this->flash->error('Please enter sum insured');
			} elseif($this->request->getPost('next_renewal') == '0000-00-00') {
				$this->flash->error('Please select next due date.');
			} elseif($this->request->getPost('next_renewal') == date('Y-m-d')) {
				$this->flash->error('Please select next due date.');
			} elseif($this->request->getPost('next_renewal') < $oneYearOn) {
				$this->flash->error('Next due date seem not valid. It must be + 1 year');
			} else {
			    $total = $this->request->getPost('total');
			    $insuran_amount = $this->request->getPost('insuran_amount');
				$road_tax = $this->request->getPost('road_tax');
			    $cover = $this->request->getPost('cover');
			    $service_charge = $this->request->getPost('service_charge');
			    $user_id = $this->request->getPost('user_id');
				$add_wallet = $this->request->getPost('add_iwallet');
				$tracking_code = $this->request->getPost('tracking_code');
				$next_renewal = $this->request->getPost('next_renewal');
				$reg_no = $this->request->getPost('reg_no');
				$telephone = $this->request->getPost('telephone');
				 // If not empty add_iwallet
				if(!empty($add_wallet)) { 
					// Check amount is number format
					if(is_numeric($add_wallet)) {
						// Add iWallet & transaction history
						$this->add_wallet($user_id, $add_wallet);
						$this->transaction_history('ACR', 'Admin Credited', $user_id, $add_wallet, 7, $auth['id']);
					}
					
				}   
			    //echo $next_renewal;
			    
				//Check baki ewallet > = total
				if($this->check_wallet($user_id) >= $total) {
				    // Tolak baki ewallet
				    if($this->deduct_wallet($user_id, $total)) {
				        // Update tarikh next renewal + 1 tahun
					    $update_ins = Insuran::findFirst("user_id = '$user_id'");
					    if($update_ins->second_driver == '') {
							$sec_driver = 'NA';
						} else {
							$sec_driver = $update_ins->second_driver;
						}
					    $update_ins->next_renewal = $next_renewal;
					    $update_ins->pic = $auth['id'];
					    $update_ins->second_driver = $sec_driver;
					    $update_ins->tracking_code = $tracking_code;
						$update_ins->cover = $cover;
						if($update_ins->save()) {
						    // Simpan transaksi history
						    if($this->transaction_history('IR', 'Insurance Renewal', $user_id, $total, 1, $auth['id'])) {
								//Send Notification 
						        if($this->renew_notification($user_id, $next_renewal, $insuran_amount, $road_tax, $cover, $service_charge, $total)) {
						            // Insert renew history
									if($this->renew_history($user_id)) {
									    // Change due date on users table
									    $user_due = Users::findFirst($user_id);
									    $user_due->insuran_due_date = $next_renewal;
									    if($user_due->save()) {
											// HEADER LOCATION payout/user_id FOR PAYOUT AND SMS
											$this->sms_renew($reg_no, $total, $telephone, $tracking_code, $next_renewal);
											$_SESSION['COMMISSION_TOKEN'] = date('YmdHis').$auth['id'];
											$this->response->redirect('gghadmin/commissions/payout?user_id='.$user_id.'&ins_amount='.$insuran_amount.'&role='.$user_due->role.'&token='.$_SESSION['COMMISSION_TOKEN']);	
										} else {
											$this->flash->error('Error on insert payout renewal. Please contact Azrul Haris (Ref: InsuranceController 690)');
										}
											
									} else {
										$this->flash->error('Error on insert history, EIH98798. Please contact Azrul Haris');
									}
									
								}
							}  
						} else {
							foreach ($update_ins->getMessages() as $message) {
				                $this->flash->error((string) $message);
				            }
						}
					} else {
						$this->flash->error('Fail to deduct wallet, Please contact Azrul Haris (Ref: InsuranceController 719)');
					}
				} else {
				    // Error jika ewallet kurang dari total
					$this->flash->error('This user not enough iWallet balance to renew');
				}	 
			}
		}
		
		$offset = mt_rand(0, 1000);
		$key = 'insuran_renew'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) {
		    $this->view->setVar('updates', $this->view_user_update($id));
		    $this->view->setVar('profiles', $this->get_user_profile($id)); 
		    $this->view->amount_to_pay = $this->amount_to_pay;
		    $this->view->setVar('navigations', $this->get_user($auth['id']));
		}
		
		$this->view->cache(array("key" => $key));
	}
	
	/*
	*  Add to renewal_histories for cashflow, used on renewAction
	*/
	private function renew_history($user_id) {
	    $renew = Insuran::findFirst("user_id = $user_id");
	    
		$his = new Renewalhistories();
		$his->user_id = $renew->user_id;
		$his->insurance = $renew->insurance;
		$his->wind_screen = $renew->wind_screen;
		$his->second_driver = $renew->second_driver;
		$his->road_tax = $renew->road_tax;
		$his->cover = $renew->cover;
		$his->service_charge = $renew->service_charge;
		$his->total = $renew->total;
		$his->next_renewal = $renew->next_renewal;
		$his->created = date('Y-m-d H:i:s');
		$his->pic = $renew->pic;
		$his->type = $renew->type;
		$his->tracking_code = $renew->tracking_code;
		$his->delivery_method = $renew->delivery_method;
		$his->crp = $renew->crp;
		$his->pa = $renew->pa;
		
		return $his->save();
	}
	
	private function sms_update($cover, $telephone, $reg_no, $due_date, $ins_amount, $roadtax, $charge, $total, $iwallet, $amount_to_pay, $wind_screen, $crp, $ncd, $pa) {
	 
	    $windscreen_amount = $wind_screen * 0.15;
	    
		$sms_username = "ishare.com.my";
        $sms_password = "rahsiajun.228";
		$sms_dstno = $telephone;
        $sms_msg = 'iShare '.$reg_no.' akan tamat pada '.$due_date.'. Sum Insured: RM'.number_format($cover,2).'. NCD: '.$ncd.'%. Windscreen Cover: RM'.$wind_screen.' (Premium: RM'.number_format($windscreen_amount, 2).'). CRP: RM'.$crp.'. PA: RM'.$pa.'. Premium Takaful: RM'.$ins_amount.'. Road Tax: RM'.$roadtax.'. Caj Myeg: RM20.00. Jumlah Renew: RM'.$total.'. Baki iPoint: RM'.$iwallet.'. Jumlah perlu dibayar: RM'.$amount_to_pay.' ke Maybank Acc: 5628 3450 3818 (Global Group Holdings Sdn Bhd). Maklumkan bukti pembayaran ke Hotline: 03 8922 2277 / 03 8927 5228 / 012 6588 135 / 012 2980 228 (SMS/Whatsapp/Call - Hari Bekerja 9.00 pagi - 6.00 ptg)';

        $sms_type = 1;
        $sms_senderid = 1;
        $sms_sendlink = "http://www.isms.com.my/isms_send.php?un=".urlencode($sms_username)."&pwd=".urlencode($sms_password)."&dstno=".$sms_dstno."&msg=".urlencode($sms_msg)."&type=".$sms_type."&sendid=".$sms_senderid; 
        fopen($sms_sendlink, "r");
	}
	
	private function sms_renew($reg_no, $total, $telephone, $tracking_code, $next_due_date) {
		$sms_username = "ishare.com.my";
        $sms_password = "rahsiajun.228";
		$sms_dstno = $telephone;
        $sms_msg ='Insuran dan Cukai Jalan '.$reg_no.' telah diperbaharui pada '.date('d/m/Y').' oleh iShare sebanyak RM'.$total.'. Tarikh tamat pada: '.$next_due_date.'. Poslaju tracking: '.$tracking_code.'. Jangan Panik! Jika berlaku insiden / breakdown, sila hubungi iResQ iShare. Hotline: 017 266 9636 / 012 573 3699. Ikhlas Care: 1-800-88-1186 / 03 2723 9999. Thank you very much for your priceless support! Please visit www.ishare.com.my and Like! www.facebook.com/ishare.com.my for more info.';

        $sms_type = 1;
        $sms_senderid = 1;
        $sms_sendlink = "http://www.isms.com.my/isms_send.php?un=".urlencode($sms_username)."&pwd=".urlencode($sms_password)."&dstno=".$sms_dstno."&msg=".urlencode($sms_msg)."&type=".$sms_type."&sendid=".$sms_senderid; 
        fopen($sms_sendlink, "r");
	}
	
	/*
	*  Add transaction history used on update and renew action
	*/
	private function transaction_history($ref, $title, $user_id, $amount, $type, $pic) {
		$hist = new Transactions();
		$hist->user_id = $user_id;
		$hist->title = $title; 
		$hist->amount = $amount;
		$hist->created = date('Y-m-d H:i:s'); 
		$hist->reference = $ref.date('YmdHis').$user_id;
		$hist->type = $type; 
		$hist->pic = $pic;
		// 1 RENEW, 2 BUY IMALL, 3 TRANSFER TO OTHER USER, 4 DONATE, 5 WITHDRAW, 6 COMMISSION, 7 ADD FUND, 8 DEDUCT SMS 0.20, 9 SELL ON IMALL, 10 RECEIVE FROM OTHER USER, 11 BUY COMPANY ITEMS, 12 BUY E PINS,
		return $hist->save();
	}
	
	/*
	*  Check ewallet balance, Used on renewAction. 
	*  Return BOOLEAN
	*/
	private function check_wallet($id) {
		$phql = "SELECT amount FROM JunMy\Models\Wallets 
		         WHERE user_id = '$id'";
		$rows = $this->modelsManager->executeQuery($phql);
		foreach($rows as $row) {
			return $row['amount'];
		}
	}
	
	/*
	*  Add iWallet, used on renewAction
	*/
	private function add_wallet($id, $amount) {
		$phql = "UPDATE JunMy\Models\Wallets SET 
				amount = amount + '$amount' WHERE user_id = '$id'";
		$update = $this->modelsManager->executeQuery($phql);
		if($update) {
			return true;
		}
	}
	
	/*
	*  Deduct after success renewal, used on renewAction
	*/
	private function deduct_wallet($id, $amount) {
		$phql = "UPDATE JunMy\Models\Wallets SET 
				amount = amount - '$amount' WHERE user_id = '$id'";
		$update = $this->modelsManager->executeQuery($phql);
		return $update;
	}
    
    /*
	*  Send notification after success renew, used on renewAction
	*/
    private function renew_notification($user_id, $next_renewal, $insuran_amount, $road_tax, $cover, $service_charge, $total) {
		$note = new Notifications();
	    $note->user_id = $user_id;
	    $note->body = "Your insurance has been renew by iShare. Insurance amount: RM$insuran_amount. Road tax: RM$road_tax. Cover RM$cover. Service charge RM$service_charge. Total: $total. Next renewal on: $next_renewal.";
	    $note->created = date('Y-m-d H:i:s');
	    $note->read = 0;
	    $note->type = 2;
	    return $note->save();
	}
	
	/*
	*  Send notification after UPDATEw, used on updateAction
	*/
	private function update_notification($user_id, $due_date, $insuran_amount, $road_tax, $cover, $total) {
		//Send SMS	& notification
	    $note = new Notifications();
	    $note->user_id = $user_id;
	    $note->body = "Your insurance has been update, Due date: $due_date. Insurance amount: RM$insuran_amount. Road tax: RM$road_tax. Cover RM$cover. Total: $total";
	    $note->created = date('Y-m-d H:i:s');
	    $note->read = 0;
	    $note->type = 1;
	    return $note->save();
	}
	
	private function view_user_update($user_id) { 
		$phql = "SELECT
		    u.id AS u_id, u.username AS username, u.name AS name, u.telephone AS tel, u.road_tax AS r_tax, u.insuran_due_date AS due, 
			u.reg_number AS reg_no, u.owner_name AS owner, u.owner_nric AS owner_ic, u.owner_dob AS owner_dob, u.model AS model, 
			u.year_make AS year, u.capacity AS cc, u.engine_number AS eng_no, u.chasis_number AS chasis, u.grant_serial_number AS grant, 
			
			w.id AS w_id, w.user_id AS u_id, w.amount AS amount,
		    
		    i.second_driver AS second_driver, i.wind_screen AS wind_screen, i.insurance AS ins_amount, i.road_tax AS r_amount, i.cover AS cover, i.service_charge AS charge, i.total AS total, i.next_renewal AS due_date, i.tracking_code AS tracking_code, i.delivery_method AS delivery_method, i.crp AS crp, i.pa AS pa,
		    i.ncd AS ncd
			FROM JunMy\Models\Users AS u
			INNER JOIN JunMy\Models\Wallets AS w ON(w.id = u.id)
			LEFT JOIN JunMy\Models\Insuran AS i ON(i.user_id = u.id)
			WHERE u.id = :param: LIMIT 1";
			$rows = $this->modelsManager->executeQuery($phql, array('param' => $user_id));	
			foreach($rows as $row) {
			    // IF wallet balance > = total to pay that mean amount to pay = 0
			    if($row['amount'] >= $row['total']) {
					$amount_to_pay = 0.00;
				} else {
					$amount_to_pay = $row['total'] - $row['amount'];
				}
				$this->amount_to_pay = $amount_to_pay;
			}
        return $rows;
	}
	
	/*
    *  Add parameters on search
    *
    */
    private function search_parameter() {
		if(isset($_GET['submit'])) {
			$query = filter_input(INPUT_GET, 'query', FILTER_SANITIZE_ENCODED);
			return " AND u.username LIKE '%$query%' OR u.reg_number LIKE '%$query%'";
		}
	}
	
	/*
    *  Add parameters on search
    *
    */
    private function search_date() {
		if(isset($_GET['submit_date'])) {
		    $from = $_GET['from'];
		    $to = $_GET['to'];
		    
			return " AND i.next_renewal >= '$from' AND i.next_renewal <= '$to'";
		}
	}

    private function get_user($id) {
	    $phql = "SELECT * FROM JunMy\Models\Users WHERE id = '$id' LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql);
		 
		return $rows;
	}

}

