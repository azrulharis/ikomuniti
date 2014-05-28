<?php

namespace JunMy\Admin\Controllers;

use JunMy\Models\Users;
use JunMy\Models\Messages;

class AjaxController extends ControllerBase {
	
	/*
	*  Ajax username auto suggest
	*/
	public function ajaxusernameAction() {
		 
		$this->view->disable();
		$request = new \Phalcon\Http\Request();
		if($request->isAjax() == true) {
			$term=$_GET["term"];
			
			$phql = "SELECT username FROM JunMy\Models\Users WHERE username like '%$term%' GROUP BY username LIMIT 15";
			$rows = $this->modelsManager->executeQuery($phql);
			//$this->view->since = date('j F, Y', strtotime($rows['users']['created']));
			$json = '[';
	        $first = true;
			foreach($rows as $row) {
				if (!$first) { 
				    $json .=  ','; 
				} else { 
					$first = false; 
				}
	            $json .= '{"value":"'.$row['username'].'"}';
			}  
			$json .= ']';
	        echo $json;
	    }
	}
	
	/*
	*  Ajax user id auto suggest
	*  Return user id
	*/
	public function ajaxuseridAction() {
		$this->view->disable();
		$request = new \Phalcon\Http\Request();
		if($request->isAjax() == true) {
			$term=$_GET["term"];
			
			$phql = "SELECT id FROM JunMy\Models\Users WHERE username like '%$term%' GROUP BY username LIMIT 15";
			$rows = $this->modelsManager->executeQuery($phql);
			//$this->view->since = date('j F, Y', strtotime($rows['users']['created']));
			$json = '[';
	        $first = true;
			foreach($rows as $row) {
				if (!$first) { 
				    $json .=  ','; 
				} else { 
				    $first = false; 
				}
	            $json .= '{"value":"'.$row['id'].'"}';
			}  
			$json .= ']';
	        echo $json;	
		} 
	}
	
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
	*  Ajax image thumbnail on imall
	*/
	public function ajaxiofferAction() {
		$this->view->disable();
		$request = new \Phalcon\Http\Request();
		if($request->isAjax() == true) {
			if($request->isPost() == true) {
			    $image = $_POST['id'];
				echo '<div class="loadimage"><img src="'.$this->ioffer_image_dir().$image.'" alt="" title="" /></div>';
			}
		}
	}
	
	public function ajaxreplyAction() { 
		$request = new \Phalcon\Http\Request();
		if($request->isAjax() == true) {
		    $this->view->success = 0;
		    $auth = $this->session->get('junauth');  
		    if($this->request->isPost()) {
		        if($this->request->getPost('post_token') != $_SESSION['ARMTV']) {
					$this->flash->error('Invalid token, please try again.');
				} elseif($this->request->getPost('post_message_id') == '') {
					$this->flash->error('Invalid message, please try again.');
				} elseif($this->request->getPost('post_message_to_id') == '') {
					$this->flash->error('Invalid recipient, please try again.');
				} elseif($this->request->getPost('post_message_from_id') != $auth['id']) {
					$this->flash->error('Invalid sender id, please try again.');
				} elseif($this->request->getPost('post_message') == '') {
					$this->flash->error('Please enter your message.');
				} else {
					// Proceed to insert and retreive from database
					$token = $this->request->getPost('post_token');
					$message_id = $this->request->getPost('post_message_id');
					$to = $this->request->getPost('post_message_to_id');
					$from = $this->request->getPost('post_message_from_id');
					$message = $this->request->getPost('post_message');
					$message_id = $this->request->getPost('post_message_id');
					if($this->reply_message($from, $to, $message, $message_id, $token)) {
						$this->view->success = 1;
						$this->view->setVar('replys', $this->ajax_conversation($token));
					}
				}
			 
		    }
		}
	}
	
    private function ajax_conversation($token) {
	    $phql = "SELECT 	
					m.id AS m_id, m.from_user_id AS from_id, m.to_user_id AS to_id,  m.body AS body, DATE_FORMAT(m.created,'%d %b') AS created, 
			DATE_FORMAT(m.created,'%h:%i %p') AS time, m.is_read AS is_read,
			u.username AS username, u.id AS user_id, u.profile_image AS image
			FROM JunMy\Models\Messages AS m 
			INNER JOIN JunMy\Models\Users AS u ON(m.from_user_id = u.id)
			WHERE token = :token: ORDER BY m.id ASC LIMIT 50";
		$rows = $this->modelsManager->executeQuery($phql, array('token' => $token));
		return $rows;
	}
	
	private function reply_message($from, $to, $message, $message_id, $token) {
		$msg = new Messages();
		$msg->from_user_id = $from; 
		$msg->to_user_id = $to;
		$msg->body = $message;
		$msg->created = date('Y-m-d H:i:s');
		$msg->is_read = 0; 
		$msg->message_id = $message_id;
		$msg->token = $token;
		return $msg->save();
	}
	
	/*
	*  Ajax user id auto suggest
	*  Return user id
	*/
	public function ajaxcategoryAction() {
		$this->view->disable();
		$request = new \Phalcon\Http\Request();
		if($request->isAjax() == true) {
		    /*$id = $_REQUEST['category'];
			if($id == 3 ) { 
				require_once('../apps/frontend/ajaxs/search/apartment_search.php');
			} elseif($id == 4) {
				require_once('../apps/frontend/ajaxs/search/apartment_search.php');
			} elseif($id == 5) {
				require_once('../apps/frontend/ajaxs/search/apartment_search.php');
			} elseif($id == 6) {
				require_once('../apps/frontend/ajaxs/search/apartment_search.php');
			} elseif($id == 7) {
				require_once('../apps/frontend/ajaxs/search/commercial_search.php');
			} elseif($id == 8) {
				require_once('../apps/frontend/ajaxs/search/land_search.php');
			} elseif($id == 10) {
				require_once('../apps/frontend/ajaxs/search/car_search.php');
			} elseif($id == 11) {
				require_once('../apps/frontend/ajaxs/search/newproperty_search.php');
			}
			*/
			
		} 
	}
}