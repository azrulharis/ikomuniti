<?php

namespace JunMy\Frontend\Controllers;
use JunMy\Models\Users; 
use JunMy\Models\Profiles; 

class SettingsController extends ControllerBase {
 
    public $salt_length = 9;
	
	public function initialize() { 
		$this->tag->setTitle('iSettings');
		parent::initialize(); 
	}
	
	public function personalAction() {
		parent::pageProtect(); 
		$this->flashSession->output();
	    $auth = $this->session->get('jun_user_auth');
	    $this->view->role = $auth['role'];
	    $this->view->setVar('navigations', $this->get_user($auth['id'])); 
	    $this->view->setVar('users', $this->get_user($auth['id'])); 
	    if($this->request->isPost()) {
			if(strlen($this->request->getPost('name')) < 5) {
				$this->flash->error('Please fill your full name');
			} elseif(!is_numeric($this->request->getPost('nric'))) {
				$this->flash->error('Not valid NRIC, please enter number only');
			} elseif(strlen($this->request->getPost('nric')) != 12) {
				$this->flash->error('Not valid NRIC, it must be 12 character long');
			} elseif(strlen($this->request->getPost('kin_nric')) != 12) { 
				$this->flash->error('Not valid Kin NRIC, it must be 12 character long');
			} elseif(!is_numeric($this->request->getPost('account_no'))) {
				$this->flash->error('Not valid Account Number, please enter number only');
			} elseif(!is_numeric($this->request->getPost('postcode'))) {
				$this->flash->error('Not valid Postcode, please enter number only');
			} elseif(!is_numeric($this->request->getPost('telephone'))) {
				$this->flash->error('Not valid Phone Number, please enter number only');
			} elseif(strlen($this->request->getPost('telephone')) < 10 || strlen($this->request->getPost('telephone')) > 11) {
				$this->flash->error('Name must be 10 or 11 character long');
			} elseif(!filter_var($this->request->getPost('email'), FILTER_VALIDATE_EMAIL)) {
				$this->flash->error('Not valid email address');
			} else {
			    $id = $auth['id'];
				$user = Users::findFirst($id); 
				
				$user->name = $this->request->getPost('name');  
				$user->nric_new = $this->request->getPost('nric'); 
				$user->kin_name = $this->request->getPost('next_of_kin'); 
				$user->relation = $this->request->getPost('relation'); 
				$user->nric_new_kin = $this->request->getPost('kin_nric'); 
				$user->bank_number = $this->request->getPost('account_no'); 
				$user->bank_name = $this->request->getPost('bank_name'); 
				$user->address = $this->request->getPost('address'); 
				$user->postcode = $this->request->getPost('postcode'); 
				$user->telephone = $this->request->getPost('telephone'); 
				$user->email = $this->request->getPost('email'); 
				if($user->save()) { 
					$this->flashSession->success('Your personal information has been save');
				    return $this->response->redirect('settings/personal');
				}
			}
		}
	}
	
	public function profileAction() {
		parent::pageProtect(); 
	    $this->flashSession->output();
	    $auth = $this->session->get('jun_user_auth');
	    $this->view->setVar('navigations', $this->get_user($auth['id']));	
	    
	    $this->view->setVar('profiles', $this->my_profile($auth['id'])); 
	    
	    if($this->request->isPost()) {
			//$user_id, $display_name, $about, $website, $location, $from, $job, $company, $college, $high_school, $dob, $created;
			//print_r($_POST);
			if($this->request->getPost($_SESSION['JSBDKBN']) != $_SESSION['JSBDKBV']) {
				$this->flash->error('Error, not valid secure token. Please try again later.');
			} elseif(strlen($this->request->getPost('display_name')) < 5 || strlen($this->request->getPost('display_name')) > 32) {
				$this->flash->error('Display name must between 5 to 32 character long.');
			} elseif(strlen($this->request->getPost('location')) < 5 || strlen($this->request->getPost('location')) > 32) {
				$this->flash->error('Location must between 5 to 32 character long.');
			} elseif(strlen($this->request->getPost('from')) < 5 || strlen($this->request->getPost('from')) > 32) {
				$this->flash->error('Hometown must between 5 to 32 character long.');
			} elseif(strlen($this->request->getPost('job')) < 5 || strlen($this->request->getPost('job')) > 32) {
				$this->flash->error('Work position must between 5 to 32 character long.');
			} elseif(strlen($this->request->getPost('company')) < 3 || strlen($this->request->getPost('company')) > 32) {
				$this->flash->error('Company / department must between 3 to 32 character long.');
			} elseif(!$this->isValidDate($this->request->getPost('dob'))) {
				$this->flash->error('Please enter valid date format IE: 1985-12-30.');
			} elseif(strlen($this->request->getPost('about')) < 5) {
				$this->flash->error('Please enter your favorite quote.');
			} else {
				if($this->request->getPost('website') != '' && filter_var($this->request->getPost('website'), FILTER_VALIDATE_URL) === false) {
					$this->flash->error('Please enter valid web address.');
				} 
				// Check if profile is exist, then update instead insert
				if($this->request->getPost('submit') == 'Save') {
					// Return insert
					$profile = new Profiles();
					$profile->user_id = $auth['id'];
					$profile->display_name = $this->request->getPost('display_name'); 
					$profile->about = $this->request->getPost('about'); 
					$profile->website = str_replace("http://", "", $this->request->getPost('website')); 
					$profile->location = $this->request->getPost('location'); 
					$profile->hometown = $this->request->getPost('from'); 
					$profile->job = $this->request->getPost('job'); 
					$profile->company = $this->request->getPost('company'); 
					$profile->college = $this->request->getPost('college'); 
					$profile->high_school = $this->request->getPost('high_school'); 
					$profile->dob = $this->request->getPost('dob'); 
					$profile->created = date('Y-m-d H:i:s');
					if($profile->save()) {
						$this->flashSession->success('Your profile has been saved.');
						return $this->response->redirect('settings/profile');
					} else {
						$this->flash->error('Error code UP119, please contact administrator.');
					}
				} elseif($this->request->getPost('submit') == 'Update') {
					// Update
					$id = $auth['id'];
					$profile = Profiles::findFirst("user_id = '$id'");
					$profile->display_name = $this->request->getPost('display_name'); 
					$profile->about = $this->request->getPost('about'); 
					$profile->website = str_replace("http://", "", $this->request->getPost('website'));
					$profile->location = $this->request->getPost('location'); 
					$profile->hometown = $this->request->getPost('from'); 
					$profile->job = $this->request->getPost('job'); 
					$profile->company = $this->request->getPost('company'); 
					$profile->college = $this->request->getPost('college'); 
					$profile->high_school = $this->request->getPost('high_school'); 
					$profile->dob = $this->request->getPost('dob'); 
					$profile->created = date('Y-m-d H:i:s');
					if($profile->save()) {
						$this->flashSession->success('Your profile has been update.');
						return $this->response->redirect('settings/profile');
					} else {
						$this->flash->error('Error code UP119, please contact administrator.');
					}
				}
				
			}
		} else {
			// Session token to prevent CSRF attack
		    $_SESSION['JSBDKBN'] = $this->passwordHash($auth['id'].date('mdHis'));
		    $_SESSION['JSBDKBV'] = $this->passwordHash($auth['id'].date('mdHis'));
		    
				
		}
		
		$_SESSION['upload_token_name'] = $this->passwordHash(date('YmdHis'));
		$_SESSION['upload_token'] = $this->passwordHash(date('YmdHis'));
		$this->view->upload_token_name = $_SESSION['upload_token_name'];
		$this->view->upload_token = $_SESSION['upload_token'];  
			
		$this->view->username = $auth['username'];
		
		$this->view->urlajax = $this->url->get('ajax/ajaxuploadprofile'); 
		 // Inject token to form field
		$this->view->token_name = $_SESSION['JSBDKBN'];
		$this->view->token_value = $_SESSION['JSBDKBV'];
	}
	
	public function vehicleAction() {
	    parent::pageProtect(); 
	    $this->flashSession->output();
	    $auth = $this->session->get('jun_user_auth');
	    $this->view->role = $auth['role'];
		$this->view->setVar('navigations', $this->get_user($auth['id']));	
		$this->view->setVar('users', $this->get_user($auth['id']));
		if($this->request->isPost()) {
			
			if($this->request->getPost('due_date') == '') {
				$this->flash->error('Please enter valid insurance due date');
			} elseif(!ctype_alnum($this->request->getPost('reg_no'))) {
				$this->flash->error('Please enter valid vehicle registration number');
			} elseif($this->request->getPost('owner_name') == '') {
				$this->flash->error('Please enter valid vehicle owner name');
			} elseif(!is_numeric($this->request->getPost('owner_nric'))) {
				$this->flash->error('Please enter valid vehicle owner NRIC');
			} elseif(strlen($this->request->getPost('owner_nric')) != 12) {
				$this->flash->error('Owner NRIC must be 12 character long');
			} elseif($this->request->getPost('owner_dob') == '') {
				$this->flash->error('Please enter valid vehicle owner Date Of Birth');
			} elseif($this->request->getPost('model') == '') {
				$this->flash->error('Please enter Vehicle Model (i.e: Perodua Myvi Auto)');
			} elseif(!is_numeric($this->request->getPost('year_make'))) {
				$this->flash->error('Please enter valid Year Make');
			} elseif(!is_numeric($this->request->getPost('cubic_capacity'))) {
				$this->flash->error('Please enter valid Vehicle CC');
			} elseif($this->request->getPost('engine_no') == '') {
				$this->flash->error('Please enter valid Engine Number');
			} elseif($this->request->getPost('chasis_no') == '') {
				$this->flash->error('Please enter valid Chasis Number');
			} elseif($this->request->getPost('grant_serial') == '') {
				$this->flash->error('Please enter valid Grant Serial Number');
			} else {
			    //print_r($_POST);
			    $id = $auth['id'];
				$user = Users::findFirst($id);
				 
				$user->previous_insuran_company = $this->request->getPost('previous_insurance'); 
				$user->cover_note = $this->request->getPost('cover_note'); 
				$user->insuran_ncb = $this->request->getPost('ncd');
				$user->road_tax = $this->request->getPost('road_tax_amount'); 
				$user->insuran_due_date = $this->request->getPost('due_date'); 
				$user->reg_number = $this->request->getPost('reg_no'); 
				$user->owner_name = $this->request->getPost('owner_name'); 
				$user->owner_nric = $this->request->getPost('owner_nric'); 
				$user->owner_dob = $this->request->getPost('owner_dob'); 
				$user->model = $this->request->getPost('model'); 
				$user->year_make = $this->request->getPost('year_make'); 
				$user->capacity = $this->request->getPost('cubic_capacity');  
				$user->engine_number = $this->request->getPost('engine_no'); 
				$user->chasis_number = $this->request->getPost('chasis_no'); 
				$user->grant_serial_number = $this->request->getPost('grant_serial'); 
				 //var_dump($user->save());
				if($user->save()) {
					$this->flashSession->success('Your vehicle information has been save');
				    return $this->response->redirect('settings/vehicle');
				} else {
					$this->flash->error('Error on update vehicle informations E8934VI');
				}
			}
		}
	}
	
	public function accountAction() {
	    parent::pageProtect(); 
	    $this->flashSession->output();
	    $auth = $this->session->get('jun_user_auth');
	    $this->view->role = $auth['role'];	
	    $this->view->setVar('navigations', $this->get_user($auth['id']));
	    $this->view->setVar('users', $this->get_user($auth['id']));
	    if($this->request->isPost()) {
			if($this->request->getPost('sms')) {
			    $id = $auth['id'];
				$user = Users::findFirst($id);
				$user->sms_setting = $this->request->getPost('sms_setting');
				echo $this->request->getPost('sms_setting');
				if($user->save()) {
					$this->flashSession->success('Your SMS setting has been save');
				    return $this->response->redirect('settings/account');
				}
			} elseif($this->request->getPost('change_password')) {
				if(strlen($this->request->getPost('password')) < 5 || strlen($this->request->getPost('password')) > 18) {
					$this->flash->error('Password must between 5 to 18 character long');
				} elseif($this->request->getPost('password') != $this->request->getPost('retype_password')) {
					$this->flash->error('Password miss match');
				} elseif(strlen($this->request->getPost('old_password')) < 5 || strlen($this->request->getPost('old_password')) > 18) {
					$this->flash->error('Not valid old password, please try again');
				} else {
				    $id = $auth['id'];
				    $password = $this->request->getPost('old_password');
					$user = Users::findFirst($id);
					if($user->password == md5($password)) {
					    $user->password = md5($this->request->getPost('password'));
						if($user->save()) {
							$this->flashSession->success('Your new password has been save');
						    return $this->response->redirect('settings/account');
						}	
					} else {
						$this->flash->error('Old password not match, please try again');
					}
				}
			} elseif($this->request->getPost('trans_password')) {
				if(strlen($this->request->getPost('transaction_password')) < 5 || strlen($this->request->getPost('transaction_password')) > 18) {
					$this->flash->error('Transaction password must between 5 to 18 character long');
				} elseif($this->request->getPost('transaction_password') != $this->request->getPost('retype_transaction_password')) {
					$this->flash->error('Transaction password miss match');
				} elseif(strlen($this->request->getPost('old_transaction_password')) < 5 || strlen($this->request->getPost('old_transaction_password')) > 18) {
					$this->flash->error('Not valid old transaction password, please try again');
				} else {
				    $id = $auth['id'];
				    $password = $this->request->getPost('old_transaction_password');
					$user = Users::findFirst($id);
					if($user->master_key == $password) {
					    $user->master_key = $this->request->getPost('transaction_password');
						if($user->save()) {
							$this->flashSession->success('Your new transaction password has been save');
						    return $this->response->redirect('settings/account');
						}	
					} else {
						$this->flash->error('Old transaction password not match, please try again');
					}
				}
			}
		}
	}
	
	/**
	* Check profile is completed
	*/
	private function my_profile($id) {
		$phql = "SELECT user_id, display_name, about, website, location, hometown, job, company, college, high_school, dob, created
		FROM JunMy\Models\Profiles WHERE user_id = :user_id: LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql, array('user_id' => $id));
		return $rows;
	}
	
	private function isValidDate($date) {
		if(preg_match("/^(\d{4})-(\d{2})-(\d{2})$/", $date, $matches)) {
			if(checkdate($matches[2], $matches[3], $matches[1])) {
				return true;
			}
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
	
	private function get_user($id) {
	    $phql = "SELECT * FROM JunMy\Models\Users WHERE id = '$id' LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql);
		return $rows; 
	}
}

