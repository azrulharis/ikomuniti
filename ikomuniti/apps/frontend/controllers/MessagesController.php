<?php

namespace JunMy\Frontend\Controllers;

use JunMy\Models\Users; 
use JunMy\Models\Messages; 
use JunMy\Components\Pagination\Pagination;

class MessagesController extends ControllerBase {
	
	public $paginationUrl;
	 
	
	public function initialize() { 
		$this->tag->setTitle('iMail');
		parent::initialize();
	}
	
	public function indexAction() {
		parent::pageProtect(); 
		$auth = $this->session->get('jun_user_auth');
		$this->flashSession->output();
		
		// Click send msg from profile
		if(isset($_GET['ref'])) {
			if(ctype_alnum($_GET['ref'])) {
				$use = $_GET['ref'];
			} else {
				$use = '';
			}
		} else {
			$use = '';
		}
		$this->view->ref_username = $use;
		// Send iMail
		if($this->request->isPost()) {
			if(strlen($this->request->getPost('username')) < 5 || strlen($this->request->getPost('username')) > 18) {
				$this->flash->error('Please enter valid iKomuniti username.');
			} elseif(!ctype_alnum($this->request->getPost('username'))) {
				$this->flash->error('Username not valid. Please enter alphanumeric character.');
			} elseif(count($this->get_username($this->request->getPost('username'))) == 0) {
				$this->flash->error('iKomuniti not found. Please try again.');
			} elseif($this->request->getPost('message') == '') {
				$this->flash->error('Please enter your message.');
			} else {
			    //print_r($_POST);
				// Proceed insert_message($from_id, $to_id, $message)
				foreach($this->get_username($this->request->getPost('username')) as $row) {
					if($this->send_message($auth['id'], $row['id'], $this->request->getPost('message'))) {
						$this->flashSession->success('Your message has been sent.');
						return $this->response->redirect('messages/index');
					} else { 
			            $this->falsh->error('Your message was not send.');
					}
					
					//echo $row['id'] . ' ' . $auth['id'];
				}
			}
		}
		
		$this->view->user_id = $auth['id'];
		$offset = mt_rand(0, 1000);
		$key = 'messages_index_'.$auth['id'].'_'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) { 
		    $this->view->setVar('messages', $this->view_messages('m.to_user_id', $auth['id'], 80, 'm.from_user_id')); 
		    $this->view->setVar('navigations', $this->get_user($auth['id']));
			$this->view->setVar('right_news', $this->right_news()); 
		}
		$this->view->cache(array("key" => $key));
		$this->view->paginationUrl = $this->paginationUrl;
	}
	
		
	// Insert message. Used on index
	private function send_message($from_id, $to_id, $msg) {
		$message = new Messages();
		$message->from_user_id = $from_id;
		$message->to_user_id = $to_id; 
		$message->body = $msg;
		$message->created = date('Y-m-d H:i:s');     
		$message->is_read = 0; 
		$message->message_id = 0;
		$message->token = 0;
		if($message->save()) {
			return true;
		} else {
			foreach ($message->getMessages() as $message) {
                $this->flash->error((string) $message);
            } 
		}
	}
	
	public function sentitemsAction() {
		 
	}
	
	public function viewAction() {
	    parent::pageProtect(); 
		$this->view->ajaxreply = $this->url->get('ajax/ajaxreply'); 
	    $auth = $this->session->get('jun_user_auth');
	    $this->view->user_id = $auth['id'];
	    
	    // Set view for current user on right
	    $this->view->param = $this->dispatcher->getParam('id');
	    
	    // Update read
	    $this->update_read($this->dispatcher->getParam('id'), $auth['id']);
	    
	    $this->view->my_username = $auth['username'];
	    $_SESSION['RMTV'] = $this->passwordHash(date('YmdHis'));
	    $this->view->token = $_SESSION['RMTV']; 
	    $this->view->my_id = $auth['id']; 
		$offset = mt_rand(0, 1000);
		$key = 'messages_view_'.$auth['id'].'_'.$this->dispatcher->getParam('id').'_'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) {
		    //$this->dispatcher->getParam('slug'); 
		    $this->view->setVar('messages', $this->read_messages($this->dispatcher->getParam('id'), $auth['id']));
		    $this->view->setVar('users', $this->get_user($auth['id'])); 
			$this->view->setVar('navigations', $this->get_user($auth['id']));
			$this->view->setVar('inboxs', $this->view_messages('m.to_user_id', $auth['id'], 50, 'm.from_user_id')); 
		}
	    $this->view->cache(array("key" => $key)); 
	    $this->view->setVar('replys', $this->reply_messages($this->dispatcher->getParam('id'), $auth['id']));
		
	}
	
	private function update_read($id, $auth) { 
		$phql = "UPDATE JunMy\Models\Messages SET 
				is_read = '1'
				WHERE to_user_id = :to_user_id: AND message_id = :message_id: OR id = :id:
				LIMIT 50";
				$update = $this->modelsManager->executeQuery($phql, array('to_user_id' => $auth, 'message_id' => $id, 'id' => $id));
		if($update) {
			return true;
		}
	}
	
	private function read_messages($id, $user_id) {
		$phql = "SELECT
		    m.id AS m_id, m.from_user_id AS from_id, m.to_user_id AS to_id,  m.body AS body, DATE_FORMAT(m.created,'%d %b') AS created, 
			DATE_FORMAT(m.created,'%h:%i %p') AS time, m.is_read AS is_read,
			u.username AS username, u.id AS user_id, u.profile_image AS image,
			s.username AS sender_username, s.id AS sender_id, s.profile_image AS sender_image
			FROM JunMy\Models\Messages AS m 
			INNER JOIN JunMy\Models\Users AS u ON(m.from_user_id = u.id) 
			INNER JOIN JunMy\Models\Users AS s ON(m.to_user_id = s.id) 
			WHERE m.id='$id' ORDER BY m.id ASC LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql); 
		return $rows;
	} 
	
	private function reply_messages($id, $auth) {
		$phql = "SELECT
		    m.id AS m_id, m.from_user_id AS from_id, m.to_user_id AS to_id,  m.body AS body, DATE_FORMAT(m.created,'%d %b') AS created, 
			DATE_FORMAT(m.created,'%h:%i %p') AS time, m.is_read AS is_read,
			u.username AS username, u.id AS user_id, u.profile_image AS image
			FROM JunMy\Models\Messages AS m 
			INNER JOIN JunMy\Models\Users AS u ON(m.from_user_id = u.id) 
			WHERE m.message_id='$id'  ORDER BY m.id ASC";
		$rows = $this->modelsManager->executeQuery($phql.$this->count_messages($id, $auth)); 
		return $rows;
	} 
	
	private function count_messages($id, $auth) {
		$phql = "SELECT id
			FROM JunMy\Models\Messages 
			WHERE message_id='$id' AND from_user_id = '$auth' OR to_user_id = '$auth'";
		$rows = $this->modelsManager->executeQuery($phql); 
		$count = count($rows);
		if($count <= 50) {
			$data = " LIMIT 50";
		} elseif($count > 50 || $count < 100) {
			$data = " LIMIT 50, 50";
		} elseif($count >= 100) {
		    $start = $count - 50;
			$data = " LIMIT $start, 50";
		}
		return $data;
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
	
	public function view_messages($column, $id, $substr, $param) {
		$records_per_page = 20;
	    $paginations = new Pagination();
        $paginate = (($paginations->get_page() - 1) * $records_per_page);
		$phql = "SELECT 
		    m.id AS m_id, 
			m.from_user_id AS from_id,
			m.to_user_id AS to_id, 
			SUBSTRING(m.body, 1, $substr) AS body, 
			DATE_FORMAT(m.created,'%d %b') AS created, 
			DATE_FORMAT(m.created,'%h:%i %p') AS time, 
			m.is_read AS is_read, 
			m.message_id AS message_id, 
			u.username AS username, u.profile_image AS image,
			t.username AS to_username, t.profile_image AS to_image
			
			FROM JunMy\Models\Messages AS m 
			LEFT JOIN JunMy\Models\Users AS u ON(m.from_user_id = u.id) 
			LEFT JOIN JunMy\Models\Users AS t ON(m.to_user_id = t.id)
			WHERE m.from_user_id='$id' OR m.to_user_id ='$id' 
			GROUP BY m.from_user_id, m.to_user_id  ORDER BY m.id DESC";
			 
		$count = $this->modelsManager->executeQuery($phql);	
        $paginations->records(count($count));
        $rows = $this->modelsManager->executeQuery($phql." LIMIT $paginate , $records_per_page");	
        // records per page
        $paginations->records_per_page($records_per_page);
		$this->paginationUrl = $paginations->render();
        
		return $rows;
	}
	
	// Check username for sent message used on index
	private function get_username($username) {
		$phql = "SELECT id FROM JunMy\Models\Users WHERE username = '$username' LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql);
		 
		return $rows;
	} 


	// Show on right view
	private function right_news() {
	    $phql = "SELECT title, created, slug, SUBSTRING(body, 1, 70) AS body FROM JunMy\Models\News ORDER BY id DESC LIMIT 5";
		$rows = $this->modelsManager->executeQuery($phql);
		 
		return $rows;
	}
		
	private function is_read($param) {
		if($param == 0) {
			return 'class="warning"';
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
}