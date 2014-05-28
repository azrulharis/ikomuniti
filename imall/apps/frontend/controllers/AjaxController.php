<?php

namespace JunMy\Frontend\Controllers;

use JunMy\Models\Users;
use JunMy\Models\Postmessages; 
use JunMy\Models\Notifications; 

class AjaxController extends ControllerBase {
	
 
	
	/*
	*  Ajax image thumbnail on imall
	*/
	public function ajaximallAction() {
		$this->view->disable();
		$request = new \Phalcon\Http\Request();
		if($request->isAjax() == true) {
			if($request->isPost() == true) {
			    $image = $_POST['id'];
				echo '<div class="loadimage"><img src="'.$this->imall_image_dir().$image.'" alt="" title="" /></div>';
			}
		}
	}
	
	/*
	*  Ajax user id auto suggest
	*  Return user id
	*/
	public function ajaxcategoryAction() {
		$this->view->disable();
		$request = new \Phalcon\Http\Request();
		if($request->isAjax() == true) {
		    
			
			$id = $_REQUEST['category'];
			if($id == 1) {
			 
				require_once('../apps/frontend/ajaxs/post_option/carOption.php');
				
			} elseif($id == 2) {
			 
				require_once('../apps/frontend/ajaxs/post_option/priceOptionMotorcycle.php');
				
			} elseif($id == 6){
			 
				require_once('../apps/frontend/ajaxs/post_option/apartmentOption.php');
				
			} elseif($id == 7) {
			 
				require_once('../apps/frontend/ajaxs/post_option/houseOption.php');
				
			} elseif($id == 8) {
			 
				require_once('../apps/frontend/ajaxs/post_option/shopOption.php');
				
			} elseif($id == 9) {
			 
				require_once('../apps/frontend/ajaxs/post_option/landOption.php');
				
			} elseif($id == 10) {
			 
				require_once('../apps/frontend/ajaxs/post_option/roomOption.php');
				
			} elseif($id == 11) {
			 
				require_once('../apps/frontend/ajaxs/post_option/newPropertyOption.php');
				
			} elseif($id == 25) {
				
				require_once('../apps/frontend/ajaxs/post_option/jobOption.php');
				
			} else {
			 
			    require_once('../apps/frontend/ajaxs/post_option/priceOption.php');
			 
			}

		} 
	}
	
		/*
	*  Ajax image thumbnail on imall
	*/
	public function ajaxmessageAction() {
		$this->view->disable(); 
		$request = new \Phalcon\Http\Request();
		if($request->isAjax() == true) {   
		    if($this->request->isPost()) {
		        if($this->request->getPost('post_xmt') == '') {
					$this->flash->error('Invalid token');
				} elseif($this->request->getPost('post_xmt') != $this->session->get('PKLCMSG')) {
					$this->flash->error('Error token.');
				} elseif(!is_numeric($this->request->getPost('post_id'))) {
					$this->flash->error('Invalid id.');
				} elseif(!is_numeric($this->request->getPost('post_xmd'))) {
					$this->flash->error('Ops... something goin wrong.');
				} elseif(strlen($this->request->getPost('post_name')) < 5 || strlen($this->request->getPost('post_name')) > 32) {
					$this->flash->error('Please valid name. Min 5 to 32 character long.');
				} elseif(!is_numeric($this->request->getPost('post_phone'))) {
					$this->flash->error('Invalid phone number, Please enter number only.');
				} elseif(strlen($this->request->getPost('post_phone')) < 10 || strlen($this->request->getPost('post_phone')) > 12) {
					$this->flash->error('Invalid phone number.');
				} elseif(!filter_var($this->request->getPost('post_email'), FILTER_VALIDATE_EMAIL)) {
					$this->flash->error('Please valid email address.');
				} elseif(strlen($this->request->getPost('post_body')) < 5 || strlen($this->request->getPost('post_body')) > 122) {
					$this->flash->error('Please enter your message. Min 5 to 122 character long.');
				} elseif($this->request->getPost('post_uxmt') == '') {
					$this->flash->error('Invalid link.');
				} else {
					
					$post_id = $this->request->getPost('post_id');
					$user_id = $this->request->getPost('post_xmd');
					$name = $this->request->getPost('post_name');
					$phone = $this->request->getPost('post_phone');
					$email = $this->request->getPost('post_email');
					$body = $this->request->getPost('post_body');
					$slug = $this->request->getPost('post_uxmt'); 
					// Proceed to save message 
					if($this->insert_message($post_id, $slug, $user_id, $name, $phone, $email, $body)) {
						// Send notification
						if($this->notification($user_id, $name)) {
							$this->flash->success('Your message has been sent.');
						}
					}
					
				}
			    
		    }
		}
	}
	
	private function insert_message($post_id, $slug, $user_id, $name, $phone, $email, $body) {
		$msg = new Postmessages();
		$msg->post_id = $post_id; 
		$msg->slug = $slug;
		$msg->user_id = $user_id; 
		$msg->name = $name; 
		$msg->email = $email; 
		$msg->phone = $phone; 
		$msg->ip_address = $this->get_ip(); 
		$msg->created = date('Y-m-d H:i:s'); 
		$msg->is_read = 0; 
		$msg->body = $body;
		return $msg->save();
	}
	
	/*
	*  Send notification after UPDATEw, used on updateAction
	*/
	private function notification($user_id, $name) {
		//Send SMS	& notification
	    $note = new Notifications();
	    $note->user_id = $user_id;
	    $note->body = "iMall message from $name";
	    $note->created = date('Y-m-d H:i:s');
	    $note->read = 0;
	    $note->type = 15;
	    return $note->save();
	}
	
	private function get_ip() {
		$ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
 
        return $ipaddress;
	}

}