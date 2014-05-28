<?php

namespace JunMy\Admin\Controllers;

use JunMy\Models\Users;
	
class SettingsController extends ControllerBase {
    
    public $salt_length = 9;
    
    public function initialize() { 
        $this->tag->setTitle('iSetting');
        parent::initialize();
    }
    
    public function indexAction() {
		parent::pageProtect();
		$auth = $this->session->get('junauth');
		
		// Set view for navigation
		$this->view->setVar('navigations', $this->get_user($auth['id']));
		
		// Set view for ajax url
		$this->view->ajaxurl = $this->url->get('gghadmin/ajax/ajaxusername');
	}   
	
	public function passwordAction() {
		parent::pageProtect();
		$auth = $this->session->get('junauth');
		$this->flashSession->output();
		// Set view for navigation
		$this->view->setVar('navigations', $this->get_user($auth['id']));
		
		// Set view for ajax url
		$this->view->ajaxurl = $this->url->get('gghadmin/ajax/ajaxusername');
		
		//  If post, makesure post is top of session token to prevent undefine var token
		if($this->request->isPost()) {
		    // Check token
		    if($this->request->getPost('token') == $_SESSION['XMKLDJDV']) {
				// if change password
				if($this->request->getPost('change_password')) {
					if(count($this->check_user($this->request->getPost('username'))) == 0) {
						$this->flash->error('iKomuniti username not found in database.');
					} elseif(strlen($this->request->getPost('username')) < 5 || strlen($this->request->getPost('username')) > 18) {
						$this->flash->error('Please enter valid username.');
					} elseif(strlen($this->request->getPost('password')) < 5 || strlen($this->request->getPost('password')) > 18) {
						$this->flash->error('Please enter valid password, Min 5 to 18 character long.');
					} elseif($this->request->getPost('password') != $this->request->getPost('retype_password')) {
						$this->flash->error('Password not match, please try again.');
					} else {
						$username = $this->request->getPost('username');
						$smspass = $this->request->getPost('password');
						$password = md5($this->request->getPost('password'));
						$sms = $this->request->getPost('send_sms');
						
						$user = Users::findFirst("username = '$username'");
						$user->password = $password;
						if($user->save()) {
							if($sms == 1) {
								// Send SMS here
								$this->send_sms($username, $smspass, $user->telephone);
							}
							
							// Success message
							$this->flashSession->success($username.' password has been change.');
							return $this->response->redirect('gghadmin/settings/password');
						}
					}
				}
				
				// Change trans password
				if($this->request->getPost('trans_password')) {
					if(count($this->check_user($this->request->getPost('username'))) == 0) {
						$this->flash->error('iKomuniti username not found in database.');
					} elseif(strlen($this->request->getPost('username')) < 5 || strlen($this->request->getPost('username')) > 18) {
						$this->flash->error('Please enter valid username.');
					} elseif(strlen($this->request->getPost('password')) < 5 || strlen($this->request->getPost('password')) > 18) {
						$this->flash->error('Please enter valid password, Min 5 to 18 character long.');
					} elseif($this->request->getPost('password') != $this->request->getPost('retype_password')) {
						$this->flash->error('Password not match, please try again.');
					} else {
						$username = $this->request->getPost('username');
						$password = $this->request->getPost('password');  
						
						$user = Users::findFirst("username = '$username'");
						$user->master_key = $password;
						if($user->save()) { 
							// Success message
							$this->flashSession->success($username.' transaction password has been change.');
							return $this->response->redirect('gghadmin/settings/password');
						}
					}
				}	
			} else {
				$this->flash->error('Error, invalid token.');
			}
			
		}
		
		// Set token to prevent CSRF attack
		$_SESSION['XMKLDJDV'] = $this->passwordHash(date('YmdHis'));
		
		// Set view for token
		$this->view->token = $_SESSION['XMKLDJDV'];
		
	}
	
	/*
	*  View MY PROFILE
	*  Return BOOLEAN
	*/	
	private function get_user($id) {
	    $phql = "SELECT id, username, role FROM JunMy\Models\Users WHERE id = '$id' LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql); 
		return $rows;
	}
	
	/*
	*  Check user exist
	*  Return ARRAY
	*/	
	private function check_user($username) {
	    $phql = "SELECT id FROM JunMy\Models\Users WHERE username = :username: LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql, array('username' => $username)); 
		return $rows;
	}
	
	public function passwordHash($pwd, $salt = null) {
        if ($salt === null)     {
            $salt = substr(md5(uniqid(rand(), true)), 0, $this->salt_length);
        } else {
            $salt = substr($salt, 0, $this->salt_length);
        }
        return $salt . sha1($pwd . $salt);
    }
    
    private function send_sms($username, $password, $phone) {
		$sms_username = "ishare.com.my";
        $sms_password = "rahsiajun.228";
		$sms_dstno = $phone;
        $sms_msg = $username . ' new password for iShare account: '.$password.'. TQ From iShare Team';

        $sms_type = 1;
        $sms_senderid = 1;
        $sms_sendlink = "http://www.isms.com.my/isms_send.php?un=".urlencode($sms_username)."&pwd=".urlencode($sms_password)."&dstno=".$sms_dstno."&msg=".urlencode($sms_msg)."&type=".$sms_type."&sendid=".$sms_senderid; 
        fopen($sms_sendlink, "r");
	}
}