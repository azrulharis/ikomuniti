<?php

namespace JunMy\Admin\Controllers;

use JunMy\Models\Users;
use JunMy\Models\Wallets;
use JunMy\Models\Usercounters;
use JunMy\Models\Iresellers;
use JunMy\Models\Insuran; 
use JunMy\Components\Pagination\Pagination;


class UsersController extends ControllerBase {
	
	
	public $salt_length = 9;
	
	public $paginationUrl;
	
	public $u_id;
	
	public function initialize() {
		$this->tag->setTitle('iAdmin');
		parent::initialize();
	}
	
	public function indexAction() {
	    parent::pageProtect();
		// Get session in array
	    $auth = $this->session->get('junauth');
	    
		$offset = mt_rand(0, 561000);  
		$key = 'adm_user_index_'.$offset;
		
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) {
		     
			$this->view->setVar('navigations', $this->get_user($auth['id']));
		}
		
		$this->view->cache(array("key" => $key)); 
	}
	
    public function loginAction() {
		if ($this->request->isPost()) {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            $user = Users::findFirstByUsername($username);
            if ($user != false) {
			    if($user->password == md5($password)) {
					$this->_registerSession($user);
	                $this->flash->success('Welcome ' . $user->username);
	                return $this->response->redirect('gghadmin/index');
				}
            }
            $this->flash->error('Wrong Username or Password');
        }
        
        //return $this->response->redirect('users/login');
	}
	
    public function viewAction() {
		parent::pageProtect();
		// Get session in array
	    $auth = $this->session->get('junauth');
	    $this->flashSession->output();
	    // Set view minimum year make for css class
	    $current = date('Y') - 20;
	    $this->view->current = $current;
	     
		    $this->view->setVar('navigations', $this->get_user($auth['id']));
			 
		$this->view->setVar('views', $this->view_user());
		$this->view->paginationUrl = $this->paginationUrl; 
	}
	
	public function editAction() {
		parent::pageProtect();
		$auth = $this->session->get('junauth'); 
		$this->flashSession->output();
		
		// if submit edit profile
		if($this->request->isPost()) {
			if($this->request->getPost('name') == '') {
				$this->flash->error('Please enter valid name');
			} elseif($this->request->getPost('address') == '') {
				$this->flash->error('Please enter valid address');
			} elseif(!is_numeric($this->request->getPost('postcode'))) {
				$this->flash->error('Please enter valid postcode');
			} elseif(strlen($this->request->getPost('telephone')) < 10 || strlen($this->request->getPost('telephone')) > 13) {
				$this->flash->error('Not valid phone number');
			} elseif(!is_numeric($this->request->getPost('telephone'))) {
				$this->flash->error('Phone number must be numeric format.');
			} elseif($this->request->getPost('insuran_due_date') == '') {
				$this->flash->error('Insurance due date cannot be empty.');
			} elseif($this->request->getPost('insuran_due_date') == '0000-00-00') {
				$this->flash->error('Please enter valid Insurance Due Date.');
			} elseif($this->request->getPost('reg_number') == '') {
				$this->flash->error('Please enter Reg Number.');
			} elseif(!ctype_alnum($this->request->getPost('reg_number'))) {
				$this->flash->error('Please enter valid Reg Number without space (A-Z, 0-9).');
			} elseif($this->request->getPost('owner_name') == '') {
				$this->flash->error('Vehicle owner name cannot be empty.');
			} elseif(!is_numeric($this->request->getPost('owner_nric'))) {
				$this->flash->error('Owner NRIC must be numeric format.');
			} elseif($this->request->getPost('model') == '') {
				$this->flash->error('Please enter Car Model.');
			} elseif(!is_numeric($this->request->getPost('year_make'))) {
				$this->flash->error('Please enter valid Year Make');
			} elseif(!is_numeric($this->request->getPost('capacity'))) {
				$this->flash->error('Capacity must be number format');
			} elseif($this->request->getPost('engine_number') == '') {
				$this->flash->error('Please enter Engine Number');
			} elseif($this->request->getPost('chasis_number') == '') {
				$this->flash->error('Please enter Chasis Number');
			} else {
			 
			    $due_date = $this->request->getPost('insuran_due_date');
			    
			    $id = $this->request->getPost('user_id');
			    
				$users = Users::findFirst($id); 
				$users->name = $this->request->getPost('name');  
				$users->nric_new = $this->request->getPost('nric_new'); 
				$users->kin_name = $this->request->getPost('kin_name'); 
				$users->relation = $this->request->getPost('relation'); 
				$users->kin_phone = $this->request->getPost('kin_phone');
				$users->nric_new_kin = $this->request->getPost('nric_new_kin'); 
				$users->bank_number = $this->request->getPost('bank_number'); 
				$users->bank_name = $this->request->getPost('bank_name'); 
				$users->address = $this->request->getPost('address'); 
				$users->postcode = $this->request->getPost('postcode'); 
				$users->telephone = $this->request->getPost('telephone'); 
				$users->email = $this->request->getPost('email'); 
				$users->previous_insuran_company = $this->request->getPost('previous_insuran_company'); 
				$users->cover_note = $this->request->getPost('cover_note'); 
				$users->insuran_ncb = $this->request->getPost('insuran_ncb');
				$users->insuran_due_date = $due_date; 
				$users->reg_number = $this->request->getPost('reg_number'); 
				$users->owner_name = $this->request->getPost('owner_name'); 
				$users->owner_nric = $this->request->getPost('owner_nric'); 
				$users->owner_dob = $this->request->getPost('owner_dob'); 
				$users->model = $this->request->getPost('model'); 
				$users->year_make = $this->request->getPost('year_make'); 
				$users->capacity = $this->request->getPost('capacity');  
				$users->engine_number = $this->request->getPost('engine_number'); 
				$users->chasis_number = $this->request->getPost('chasis_number'); 
				$users->grant_serial_number = $this->request->getPost('grant_serial_number'); 
				$users->road_tax = $this->request->getPost('road_tax');
				
				if($users->save()) {
					$ins = Insuran::findFirst("user_id = '$id'");
					$ins->next_renewal = $due_date;
					if($ins->save()) {
						$this->flashSession->success('User information has been saved');
					    return $this->response->redirect('gghadmin/users/edit/'.$this->dispatcher->getParam('slug'));
					} else {
						foreach ($ins->getMessages() as $message) {
			                $this->flash->error((string) $message);
			            }
					}
				} else {
					foreach ($users->getMessages() as $message) {
		                $this->flash->error((string) $message);
		            }
				}
			}
		}
		
		
		$offset = mt_rand(0, 1000);
		$key = 'user_profile_'.$this->dispatcher->getParam('slug').'_'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) {
		    $this->view->setVar('users', $this->get_user_profile($this->dispatcher->getParam('slug'))); 
		    $this->view->setVar('navigations', $this->get_user($auth['id'])); 
		} 
		$this->view->cache(array("key" => $key)); 
	}
	
	public function profileAction() {
		parent::pageProtect();
		$auth = $this->session->get('junauth'); 
		$this->flashSession->output(); 
	    $this->view->setVar('users', $this->get_user_profile($this->dispatcher->getParam('slug'))); 
	    $this->view->setVar('navigations', $this->get_user($auth['id']));
	    $this->view->epin_balance = count($this->get_user_epin($this->get_user_id($this->dispatcher->getParam('slug')))); 
	    $this->view->wallet = $this->get_user_wallet($this->get_user_id($this->dispatcher->getParam('slug')));  
		// View vip
		$this->view->event = $this->vip($this->get_user_id($this->dispatcher->getParam('slug'))); 
	}
	
	private function vip($id) {
		$vip = Usercounters::findFirst("user_id = '$id'");
		if($vip->status == 1) {
			return 'Langkawi';
		} elseif($vip->status == 5) {
			return 'VIP';
		} elseif($vip->status == 6) {
			return 'VVIP';
		} else {
			return 'NA';
		}
	}
	
	public function iresellerAction() {
		parent::pageProtect();
		$auth = $this->session->get('junauth'); 
		if($this->request->isPost()) {
		    
			if($this->request->getPost('user_id') != '') {
			    $id = $this->request->getPost('user_id');
			    $count = Iresellers::find("user_id = '$id'");
			    if(count($count) == 0) {
					$res = new Iresellers();  
					$res->user_id = $id;
					$res->name = $this->request->getPost('name');
					$res->location = $this->request->getPost('location'); 
					$res->phone = $this->request->getPost('phone'); 
					$res->username = $this->request->getPost('username'); 
					$res->created = date('Y-m-d H:i:s'); 
					$res->profile_image = $this->request->getPost('profile_image');
					if($res->save()) {
						$user = Users::findFirst($id);
						$user->role = 2;
						if($user->save()) {
							$this->flashSession->success($this->request->getPost('username'). ' has been add to iReseller.');
					        return $this->response->redirect('gghadmin/users/view');
						}
					}	
				} else {
					$this->flashSession->error($this->request->getPost('username'). ' already iReseller.');
					return $this->response->redirect('gghadmin/users/profile/'.$this->request->getPost('username'));
				} 
			}
		}
		$offset = mt_rand(0, 1000);
		$key = 'user_ireseller'.$this->dispatcher->getParam('slug').'_'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) {
		    $this->view->setVar('users', $this->get_user_profile($this->dispatcher->getParam('slug'))); 
		    $this->view->setVar('navigations', $this->get_user($auth['id']));
		    $this->view->epin_balance = count($this->get_user_epin($this->get_user_id($this->dispatcher->getParam('slug'))));
		    $this->view->wallet = $this->get_user_wallet($this->get_user_id($this->dispatcher->getParam('slug'))); 
		}
		
		$this->view->cache(array("key" => $key)); 
	}
	
	private function get_user_epin($id) {
		$phql = "SELECT id FROM JunMy\Models\Epins WHERE user_id = '$id' AND used_user_id = '0' LIMIT 200";
		$rows = $this->modelsManager->executeQuery($phql);
	    
		return $rows;
	}
	
	private function get_user_profile($username) {
	    $phql = "SELECT * FROM JunMy\Models\Users WHERE username = '$username' LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql);
	    
		return $rows;
	}
	
	private function get_user_wallet($id) {
	    $phql = "SELECT amount FROM JunMy\Models\Wallets WHERE user_id = '$id' LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql);
	    foreach($rows as $row) {
			return $row['amount'];
		}
	}
	
	// 	id	username_sponsor	username	name	password	nric_new	kin_name	relation	nric_new_kin	bank_number	bank_name	address	postcode	telephone	email	previous_insuran_company	cover_note	insuran_ncb	road_tax	insuran_due_date	reg_number	owner_name	owner_nric	owner_dob	model	year_make	capacity	engine_number	chasis_number	grant_serial_number	ip_address	created	payment	email_verification	verified	role	ckey	profile_image	sms_setting	master_key
	private function get_user($id) {
	    $phql = "SELECT u.username AS username, u.email AS email, u.insuran_due_date AS insuran_due_date, 
		u.profile_image AS profile_image, u.reg_number AS reg_number,
	      w.amount AS amount
		  FROM JunMy\Models\Users AS u
		  INNER JOIN JunMy\Models\Wallets AS w ON(u.id = w.user_id) 
		  WHERE u.id = '$id'";
		$rows = $this->modelsManager->executeQuery($phql);
		 
		return $rows;
	}	
    
    private function view_user() {
		
	    $records_per_page = 50;
	    $paginations = new Pagination();
        $paginate = (($paginations->get_page() - 1) * $records_per_page);
		$phql = "SELECT
		    id, username, username_sponsor, insuran_due_date, reg_number, model, year_make, engine_number, chasis_number, capacity
			FROM JunMy\Models\Users WHERE role != '0'
			".$this->search_user(filter_input(INPUT_GET, 'query', FILTER_SANITIZE_ENCODED))."
			ORDER BY id DESC";
		$count = $this->modelsManager->executeQuery($phql);	
        $paginations->records(count($count));
        $rows = $this->modelsManager->executeQuery($phql." LIMIT $paginate , $records_per_page");	
        // records per page
        $paginations->records_per_page($records_per_page);
		$this->paginationUrl = $paginations->render();
		 /*
		foreach($rows as $row) {
			$vip = new Usercounters();
			$vip->user_id = $row['id'];
			$vip->is_one = $this->user_counter($row['username']);
			$vip->status = 0;
			$vip->save();
		}  */

		return $rows;
	
	}
	
	/*
	*  Check vip, count downline to insert to usercounter table
	*/
	private function user_counter($username) {
		$phql = "SELECT id FROM JunMy\Models\Users WHERE username_sponsor = '$username' AND role != '0' LIMIT 50";
		$rows = $this->modelsManager->executeQuery($phql);
	    return count($rows);
	}
	
	private function search_user($param) {
		if($param) {
			return " AND username LIKE '%$param%' OR reg_number LIKE '%$param%' OR name LIKE '%$param%'";
		}
	}
    
	public function passwordHash($pwd, $salt = null) {
        if ($salt === null)     {
            $salt = substr(md5(uniqid(rand(), true)), 0, $this->salt_length);
        } else {
            $salt = substr($salt, 0, $this->salt_length);
        }
        return $salt . sha1($pwd . $salt);
    }
    
    private function get_user_id($username) {
	    $phql = "SELECT id FROM JunMy\Models\Users WHERE username = '$username' LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql);
	    foreach($rows as $row) {
			return $row['id'];
		}	
	}    
	
	/**
     * Finishes the active session redirecting to the index
     *
     * @return unknown
     */
    public function logoutAction() {   
	    $this->session->remove('junauth');
        $this->flash->success('Goodbye!');
        unset($_SESSION); 
        return $this->response->redirect('gghadmin/users/login');
    }
}