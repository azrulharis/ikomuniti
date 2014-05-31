<?php

namespace JunMy\Frontend\Controllers;

use JunMy\Models\Users; 
use JunMy\Components\Pagination\Pagination;
use JunMy\Models\Epins; 
use JunMy\Models\Usercounters;

class ActivationsController extends ControllerBase {
	
	public function initialize() {
		$this->tag->setTitle('iKomuniti activation');
		parent::initialize();
	}
	
	
	public function indexAction() {
		parent::pageProtect(); 
		$auth = $this->session->get('jun_user_auth');
	    // Role
		$this->role($auth['role'], array(1, 2, 3, 4, 5, 6, 7, 8, 9));
		$this->flashSession->output();
	    $this->view->setVar('users', $this->get_user($auth['id']));
	    if(count($this->view_user($auth['username'], 0)) > 0) {
			
		} else {
			$this->flash->error('No iKomuniti to activate');
		}
		$this->view->setVar('views', $this->view_user($auth['username'], 0));
	    $this->view->setVar('navigations', $this->get_user($auth['id']));
	 
		$this->view->paginationUrl = $this->paginationUrl;
		if(isset($_GET['ref']) && isset($_GET['activate']) && isset($_GET['ntsv'])) {
		    $downline_id = $_GET['ntsv'];
		    if(is_numeric($downline_id)) {
				if($_GET['action'] == 'activate') {
					$this->check_epin($auth['id'], $downline_id);
				} elseif($_GET['action'] == 'problem') {
					$this->problem($downline_id);
				}
			} else {
				$this->flash->error('Not valid user.');
			}	
		} 
		 
	}
	
	public function problemsAction() {
		parent::pageProtect(); 
		$auth = $this->session->get('jun_user_auth');
	    // Role
		$this->role($auth['role'], array(1, 2, 3, 4, 5, 6, 7, 8, 9));
		$this->flashSession->output();
	    $this->view->setVar('users', $this->get_user($auth['id']));
	     
		$this->view->setVar('views', $this->view_user_problem(44));
		
	    $this->view->setVar('navigations', $this->get_user($auth['id']));
	 
		$this->view->paginationUrl = $this->paginationUrl;
		if(isset($_GET['ref']) && isset($_GET['activate']) && isset($_GET['ntsv'])) {
		    $downline_id = $_GET['ntsv'];
		    if(is_numeric($downline_id)) {
		        if($_GET['action'] == 'activate') {
					$this->check_epin($auth['id'], $downline_id);
				} elseif($_GET['action'] == 'problem') {
					$this->problem($downline_id);
				}
				
			} else {
				$this->flash->error('Not valid user.');
			}	
		} 
		 
	}
	
	public function allAction() {
		parent::pageProtect(); 
		$auth = $this->session->get('jun_user_auth');
		// Role
		$this->role($auth['role'], array(1, 2, 3, 4, 5, 6, 7, 8, 9));
		
	    $this->view->setVar('users', $this->get_user($auth['id']));
	    if($auth['role'] <= 1) {
			$this->flash->error('No iKomuniti to activate');
		} else {
			
			if(isset($_GET['ref']) && isset($_GET['activate']) && isset($_GET['ntsv'])) {
			    $downline_id = $_GET['ntsv'];
			    if(is_numeric($downline_id)) {
					if($_GET['action'] == 'activate') {
						$this->check_epin($auth['id'], $downline_id);
					} elseif($_GET['action'] == 'problem') {
						$this->problem($downline_id);
					}
				} 	
			} 
			
		}
		$this->view->setVar('views', $this->view_user_all($auth['username']));
	    $this->view->setVar('navigations', $this->get_user($auth['id']));
		$this->view->paginationUrl = $this->paginationUrl;	 
		 
	}
	
	public function profileAction() {
		parent::pageProtect(); 
		$auth = $this->session->get('jun_user_auth');
		// Role
		$this->role($auth['role'], array(1, 2, 3, 4, 5, 6, 7, 8, 9));
		$this->view->setVar('navigations', $this->get_user($auth['id']));
		$username = $this->dispatcher->getParam('slug');
		
		// Set view profile
		$this->view->setVar('users', $this->view_user_profile($username));
	}
	
	private function problem($id) {
		$user = Users::findFirst($id);
		$user->verified = 44;
		if($user->save()) {
			$this->flashSession->success('User has been add to problems area'); 
			return $this->response->redirect('activations/problems');
		}
	}
	
	/*
	*  Activate member used epin
	*/	
	private function check_epin($user_id, $used_user_id) {
		$phql = "SELECT id FROM JunMy\Models\Epins WHERE user_id = '$user_id' AND used_user_id = '0' LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql);
		if(count($rows) > 0) {
			$update = "UPDATE JunMy\Models\Epins SET 
		               used_user_id = '$used_user_id' WHERE user_id = '$user_id' AND used_user_id = '0' LIMIT 1";
		    $return = $this->modelsManager->executeQuery($update);
		    if($return) {
		        if($this->activate_user($used_user_id)) {
		            // Update user counter
		            // Send sms
		            $user = Users::findFirst($used_user_id);
		            if($this->update_counter($user->username_sponsor, $used_user_id)) {
						$this->send_sms($user->master_key, $user->username, $user->telephone, $user->ckey);
						$this->flashSession->success('Activation has been success.'); 
						return $this->response->redirect('activations/index');
					} 
				} else {
				    
					$this->flash->error('Error E067 - Sila hubungi bahagian teknikal');
				}
			} else {
				$this->flash->error('Error E068 - Sila hubungi bahagian teknikal');
			}
		} else {
			$this->flashSession->error('You have no iPin to activate iKomuniti');
			return $this->response->redirect('activations/index');
		}
	}
	
	private function update_counter($username, $new_id) {
		$phql = "SELECT id FROM JunMy\Models\Users WHERE username = '$username' LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql); 
		foreach($rows as $row) {
			$user = Usercounters::findFirst($row['id']);
			$user->is_one += 1;
			if($user->save()) {
				$new = new Usercounters();
				$new->user_id = $new_id;
				$new->is_one = 0;
				$new->status = 0;
				if($new->save()) {
					return true;
				}
			}
		}
	}
	
	private function send_sms($trans, $username, $telephone, $password) {
		$sms_username = "ishare.com.my";
        $sms_password = "rahsiajun.228";
		$sms_dstno = $telephone;
        $sms_msg ='Congratulation! You are now officially one of iShare Community. Registration success with Username Login: '.$username.' Login Password: '.$password.' & Transaction Password: '.$trans.'. Please record this sms for future reference.
Thank you very much for your priceless support. Please visit www.ishare.com.my and Like! www.facebook.com/ishare.com.my for more info.';

        $sms_type = 1;
        $sms_senderid = 1;
        $sms_sendlink = "http://www.isms.com.my/isms_send.php?un=".urlencode($sms_username)."&pwd=".urlencode($sms_password)."&dstno=".$sms_dstno."&msg=".urlencode($sms_msg)."&type=".$sms_type."&sendid=".$sms_senderid; 
        fopen($sms_sendlink, "r");
	}
	
	/*
	*  Update users column 'verified' from 0 to 1
	*  Return Update (iKomuniti = 4, iReseller = 5)
	*/	
	private function activate_user($id) {
	    $date = date('Y-m-d H:i:s');	
	    $phql = "UPDATE JunMy\Models\Users SET 
		role = '4', verified = '1', created = '$date' WHERE id = '$id'";
		$update = $this->modelsManager->executeQuery($phql);
		return $update;
	}

	/*
	*  View MY PROFILE
	*  Return BOOLEAN
	*/	
	private function get_user($id) {
	    $phql = "SELECT * FROM JunMy\Models\Users WHERE id = '$id' LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql); 
		return $rows;
	}
	
	/*
	*  View all downline
	*  Return BOOLEAN
	*/
	private function view_user($username, $status) {
		
	    $records_per_page = 30;
	    $paginations = new Pagination();
        $paginate = (($paginations->get_page() - 1) * $records_per_page);
		$phql = "SELECT 
						id, 
						username_sponsor,
						username,
						name,
					    SUBSTRING(password, 1, 24) AS xmtlvc,
						telephone,
						email, 
						insuran_due_date,
						reg_number, 
						model,
						year_make,
						capacity,
						engine_number,
						chasis_number,
						created, 
						verified,
						role 
			FROM JunMy\Models\Users 
			WHERE username_sponsor='$username' AND verified = '$status' AND role = '0'
			ORDER BY id DESC";
		$count = $this->modelsManager->executeQuery($phql);	
        $paginations->records(count($count));
        $rows = $this->modelsManager->executeQuery($phql." LIMIT $paginate , $records_per_page");	
        // records per page
        $paginations->records_per_page($records_per_page);
		$this->paginationUrl = $paginations->render();

		return $rows;
	
	}
	
	/*
	*  View all downline
	*  Return BOOLEAN
	*/
	private function view_user_problem($status) {
		
	    $records_per_page = 30;
	    $paginations = new Pagination();
        $paginate = (($paginations->get_page() - 1) * $records_per_page);
		$phql = "SELECT 
						id, 
						username_sponsor,
						username,
						name,
					    SUBSTRING(password, 1, 24) AS xmtlvc,
						telephone,
						email, 
						insuran_due_date,
						reg_number, 
						model,
						year_make,
						capacity,
						engine_number,
						chasis_number,
						created, 
						verified,
						role 
			FROM JunMy\Models\Users 
			WHERE verified = '$status' AND role = '0'
			ORDER BY id DESC";
		$count = $this->modelsManager->executeQuery($phql);	
        $paginations->records(count($count));
        $rows = $this->modelsManager->executeQuery($phql." LIMIT $paginate , $records_per_page");	
        // records per page
        $paginations->records_per_page($records_per_page);
		$this->paginationUrl = $paginations->render();

		return $rows;
	
	}
	
	/*
	*  View all downline
	*  Return BOOLEAN
	*/
	private function view_user_all($username) {
		
	    $records_per_page = 30;
	    $paginations = new Pagination();
        $paginate = (($paginations->get_page() - 1) * $records_per_page);
		$phql = "SELECT
		    *
			FROM JunMy\Models\Users 
			WHERE username_sponsor != '$username' AND verified = '0' AND role = '0'
			ORDER BY id DESC";
		$count = $this->modelsManager->executeQuery($phql);	
        $paginations->records(count($count));
        $rows = $this->modelsManager->executeQuery($phql." LIMIT $paginate , $records_per_page");	
        // records per page
        $paginations->records_per_page($records_per_page);
		$this->paginationUrl = $paginations->render();

		return $rows;
	
	}
	
	private function view_user_profile($username) {
		$phql = "SELECT *
						FROM JunMy\Models\Users WHERE username = '$username' AND role = '0' LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql); 
		return $rows;
	}
}