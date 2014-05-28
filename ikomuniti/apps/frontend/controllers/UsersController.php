<?php

namespace JunMy\Frontend\Controllers;

use JunMy\Models\Users; 
use JunMy\Models\Wallets;
use JunMy\Models\Insuran; 
use JunMy\Models\Passwordrequests; 

class UsersController extends ControllerBase {
	
	public $form;
	
	public $jun_error = array();
	
	public $due;
	
	public $salt_length = 9;
	
	public function initialize() { 
		$this->tag->setTitle('User register/login');
		parent::initialize();
	}
	
	public function indexAction() {
	    parent::pageProtect();
		$auth = $this->session->get('jun_user_auth');
		$offset = mt_rand(0, 958695);
		$key = 'userlogin'.$offset;
		
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) {
		    
			$this->view->setVar('users', $this->get_user($auth['id']));
			$this->view->blink = $this->blink_notification($this->due);
		}
		
		$this->view->cache(array("key" => $key));
		
	}
	
	public function forgotpasswordAction() {
	    
	    if($this->request->isPost()) {
			// Check token to prevent CSRF
		    if($this->request->getPost($this->session->get('TKNFGPSNAME')) != $this->session->get('TKNFGPSVALUE')) {
				$this->flash->error('Not valid request');
			} else {
				$username = $this->request->getPost('username'); 
	            
	            if(!ctype_alnum($username)) {
					$this->flash->error('Not valid username');
				} elseif(strlen($username) < 4 || strlen($username) > 18) {
					$this->flash->error('Not valid username');
				} else {
					$user = Users::findFirst("username='$username' AND role != '0'");
		            if ($user != false) {
		                // Check valid email address, then send email send_sms($code, $telephone)
					    if(is_numeric($user->telephone)) { 
					        // Check if valid telephone
					        if(strlen($user->telephone) > 9 || strlen($user->telephone) < 13) {
					            $req = Passwordrequests::find("user_id = '$user->id' LIMIT 5");
					            // Count if forgot password limit 5
					            if(count($req) < 5) {
								    $code = $this->generate($length = 8);
								    $hash = $this->passwordHash(date('YmdHis'));
					                // Insert new password request
									if($this->password_request($user->id, $code, $hash, $this->get_ip())) {
										// Send sms code and redirect to confirmation page
										$this->send_sms($code, $user->telephone);
										unset($_SESSION['TKNFGPSNAME']);
						                unset($_SESSION['TKNFGPSVALUE']);
						                // Set new session fot matching to hash value
						                $_SESSION['XMPLTVHDJF'] = $hash;
						                $this->flashSession->success('Your request has been proceed, Don\'t refresh this page and enter RPID code.'); 
						                return $this->response->redirect('users/tacrequest/'.$hash);	
									}
								} else {
									$this->flash->error('You\'re exceed forgotten password request. Maximum 5 time per user');
								}
					            
							} else {
								$this->flash->error('Your phone number is invalid. We can\' process this request');	
							}
			                
						} else {
							$this->flash->error('Your phone number is not numeric format. We can\' process this request');	
						}
		            }
		            $this->flash->error('Wrong username or iSahabat account.');	
				}	
			}
		}
		$_SESSION['TKNFGPSNAME'] = $this->passwordHash(date('YmdHis'));
        $_SESSION['TKNFGPSVALUE'] = $this->passwordHash('54745'.date('YmdHis'));
        
        // Set view for login token
        $this->view->token_name = $_SESSION['TKNFGPSNAME'];
        $this->view->token_value = $_SESSION['TKNFGPSVALUE'];
	}
	
	public function tacrequestAction() {
	    $this->flashSession->output();
		
		if($this->dispatcher->getParam('slug') == '') {
			$this->flashSession->error('Error, Not valid request.'); 
			return $this->response->redirect('users/login');	
		} elseif($this->dispatcher->getParam('slug') != $_SESSION['XMPLTVHDJF']) {
			$this->flashSession->error('Error, Not valid request.'); 
			return $this->response->redirect('users/login');
		} 
		$_SESSION['counter'] = isset($_SESSION['counter']) ? $_SESSION['counter'] : 0;
		if($this->request->isPost()) {
		    $_SESSION['counter']++;
		     echo $_SESSION['counter'];
			if($this->request->getPost($_SESSION['TKNFGPSNAME']) != $_SESSION['TKNFGPSVALUE']) {
				$this->flashSession->error('Error, Not valid request.'); 
			    return $this->response->redirect('users/login');
			} elseif($this->request->getPost('tac') == '') {
				$this->flash->error('Error, Not valid RPID.');  
			} elseif(strlen($this->request->getPost('tac')) != 8) {
				$this->flash->error('Error, Not valid RPID.');  
			} elseif(strlen($this->request->getPost('password')) < 5 || strlen($this->request->getPost('password')) > 18) {
				$this->flash->error('Password must between 5 to 18 character long'); 
			} elseif($this->request->getPost('password') != $this->request->getPost('retype_password')) {
				$this->flash->error('Error, Password combination not match.'); 
			} else {
			    $tac = $this->request->getPost('tac');
			    $hash = $_SESSION['XMPLTVHDJF'];
			    $password = $this->request->getPost('password'); 
				$phql = "SELECT user_id FROM JunMy\Models\Passwordrequests WHERE confirmation = '$hash' AND tac = '$tac' ORDER BY id DESC LIMIT 1";
		        $rows = $this->modelsManager->executeQuery($phql); 
		 
				if(count($rows) == 1) {
				    foreach($rows as $row) {
				        $user_id = $row['user_id'];
						$user = Users::findFirst("id = '$user_id' AND role != 0");
						$user->password = md5($password);
						if($user->save()) {
							$this->flashSession->success('Your new password has been saved. Please login to iKomuniti area.'); 
				    		return $this->response->redirect('users/login');
						}	
					}
					
				} else {
					$this->flash->error('Error, RPID not match.'); 
				}
			}
		} 
		
		$_SESSION['TKNFGPSNAME'] = $this->passwordHash(date('YmdHis'));
        $_SESSION['TKNFGPSVALUE'] = $this->passwordHash('54745'.date('YmdHis'));
        
        // Set view for login token
        $this->view->token_name = $_SESSION['TKNFGPSNAME'];
        $this->view->token_value = $_SESSION['TKNFGPSVALUE'];
	}
	
	private function get_user($id) {
	    $phql = "SELECT * FROM JunMy\Models\Users WHERE id = '$id' LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql); 
		return $rows;
	} 

    public function loginAction() { 
        //echo $_SERVER['SERVER_NAME'];
        $this->flashSession->output();
		if ($this->request->isPost()) { 
		    // Check token to prevent CSRF
		    if($this->request->getPost($this->session->get('TKNLOGINNAME')) != $this->session->get('TKNLOGINVALUE')) {
				$this->flash->error('Not valid request');
			} else {
				$username = $this->request->getPost('username');
	            $password = $this->request->getPost('password');
	            
	            if(!ctype_alnum($username)) {
					$this->flash->error('Not valid username');
				} elseif(strlen($username) < 4 || strlen($username) > 18) {
					$this->flash->error('Not valid username');
				} elseif(strlen($password) < 5 || strlen($password) > 18) {
					$this->flash->error('Not valid password');
				} else {
					$user = Users::findFirst("username='$username' AND role != '0'");
		            if ($user != false) {
					    if($user->password == md5($password)) {
					        $agent = sha1($this->request->getUserAgent());
							$this->_registerSession($user, $agent);
			                unset($_SESSION['TKNLOGINNAME']);
			                unset($_SESSION['TKNLOGINVALUE']);
			                return $this->response->redirect('index/index');
						}
		            }
		            $this->flash->error('Wrong username/password');	
				}	
			}
             
        } 
		$_SESSION['TKNLOGINNAME'] = $this->passwordHash(date('YmdHis'));
        $_SESSION['TKNLOGINVALUE'] = $this->passwordHash('1353'.date('YmdHis'));
        
        // Set view for login token
        $this->view->token_name = $_SESSION['TKNLOGINNAME'];
        $this->view->token_value = $_SESSION['TKNLOGINVALUE'];
	}
	
	private function password_request($user_id, $code, $hash, $ip) {
		$req = new Passwordrequests();
		$req->user_id = $user_id;
		$req->ip_address = $ip;
		$req->confirmation = $hash;
		$req->created = date('Y-m-d H:i:s');
		$req->status = 0;
		$req->tac = $code;
		return $req->save();
	}
	
	private function generate($length = 8) {
		$password = "";
		$possible = "N1CD4GHEQRST5FK2Z3JAW4XB7Y8LMP6U9VAFGY52RJEU73856U87T3YD64ET49RH65U79Y5W9U656UH5T65W";  
		$i = 0; 
		while ($i < $length) { 
			$char = substr($possible, mt_rand(0, strlen($possible)-1), 1); 
			if (!strstr($password, $char)) { 
			  $password .= $char;
			  $i++;
			} 
		} 
		return $password; 
	}
	
	private function send_sms($code, $telephone) {
		$sms_username = "ishare.com.my";
        $sms_password = "rahsiajun.228";
		$sms_dstno = $telephone;
        $sms_msg ='iShare forgot password request. RPID: '.$code.'. Call 0389222277 for assist. TQ From iShare';

        $sms_type = 1;
        $sms_senderid = 1;
        $sms_sendlink = "http://www.isms.com.my/isms_send.php?un=".urlencode($sms_username)."&pwd=".urlencode($sms_password)."&dstno=".$sms_dstno."&msg=".urlencode($sms_msg)."&type=".$sms_type."&sendid=".$sms_senderid; 
        fopen($sms_sendlink, "r");
	}
	
	public function _registerSession($user, $agent)
    {
        $this->session->set('jun_user_auth', array(
            'id' => $user->id,
            'username' => $user->username,
            'role' => $user->role,
            'xcmt' => $agent
        ));
    }
	
	public function display($value) {
        if(isset($_POST['submit'])) {
		    if(isset($this->jun_error[$value])) {
			    echo '<span class="alert-dismissable alert-danger">'.$this->jun_error[$value].'</span>'; 
		    }			
		}
    }
	

    
     
	
	private function generateRandomString($length = 6) {
	    $characters = '123456789ABCDEFGHJKLMNPQRSTUVWXYZ';
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, strlen($characters) - 1)];
	    }
	    return $randomString;
	}
	
	private function insert_wallet($id) {
		$wallet = new Wallets();
		$wallet->user_id = $id;
		$wallet->amount = 0.00;
		$wallet->created = date('Y-m-d H:i:s');
		return $wallet->save();
	}
 
	private function insert_insuran($id, $roadtax, $sec_driver, $windscreen, $due_date) {

		$ins = new Insuran();
		$ins->user_id = $id; 
		$ins->insurance = 0.00; 
		$ins->wind_screen = $windscreen; 
		$ins->second_driver = $sec_driver; 
		$ins->road_tax = $roadtax; 
		$ins->cover = 0.00;
		$ins->service_charge = 0.00; 
		$ins->total = 0.00;
		$ins->next_renewal = $due_date; 
		$ins->created = date('Y-m-d H:i:s'); 
		$ins->pic = 0; 
		$ins->type = 0; 
		$ins->tracking_code = 0; 
		$ins->delivery_method = 0; 
		$ins->crp = 0; 
		$ins->pa = 0;	 
		return $ins->save();
	}
	
	public function passwordHash($pwd, $salt = null) {
        if ($salt === null)     {
            $salt = substr(md5(uniqid(rand(), true)), 0, $this->salt_length);
        } else {
            $salt = substr($salt, 0, $this->salt_length);
        }
        return $salt . sha1($pwd . $salt);
    }
    
 
	
	public function check_upline($field, $value) {
		$user = Users::findFirst("$field = '$value' AND role > 0");
        if ($user != false) {
            return 1;
        } else {
			return 0;
		}
	}
	
	public function doCount($field, $value) {
		$user = Users::findFirst("$field = '$value'");
        if ($user != false) {
            return 1;
        } else {
			return 0;
		}
	}
	
	private function validEmail($email) {
		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}
	
	private function check_vip($username) {
		$phql = "SELECT username FROM JunMy\Models\Users WHERE username_sponsor = '$username' LIMIT 50";
		$rows = $this->modelsManager->executeQuery($phql); 
		return $rows;
	} 
	
	/**
     * Finishes the active session redirecting to the index
     *
     * @return unknown
     */
    public function logoutAction()
    {
        $this->session->remove('jun_user_auth');
        unset($_SESSION);
        $this->flash->success('Goodbye!');
        return $this->response->redirect('users/login');
    }
}