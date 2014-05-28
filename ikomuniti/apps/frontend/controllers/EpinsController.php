<?php

namespace JunMy\Frontend\Controllers;

use JunMy\Models\Users;
use JunMy\Models\Epins;
use JunMy\Models\Epinhistories;
use JunMy\Components\Pagination\Pagination;

use Phalcon\Tag as Tag;

class EpinsController extends ControllerBase {
	
	
	public $salt_length = 9;
	
	public $paginationUrl;
	
	public function initialize() {
	    $this->view->setTemplateAfter('main');
		$this->tag->setTitle('User ePins');
		parent::initialize();
	}
	
    public function indexAction() {
		parent::pageProtect();
		
		$auth = $this->session->get('jun_user_auth');
		$this->role($auth['role'], array(1, 2, 3, 4, 5, 6, 7, 8, 9));
		$offset = mt_rand(0, 1000);
		$key = 'index_epins_'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) {
		    $this->view->setVar('users', $this->get_user($auth['id'])); 
		    $this->view->setVar('navigations', $this->get_user($auth['id'])); 
			
		}
		$this->view->setVar('epins', $this->view_epin($auth['id']));
		$this->view->cache(array("key" => $key));
		$this->view->paginationUrl = $this->paginationUrl;
	}
	
	public function trackAction() {
		parent::pageProtect();
		
		$auth = $this->session->get('jun_user_auth');
		
		// Role
		$this->role($auth['role'], array(1, 2, 3, 4, 5, 6, 7, 8, 9));
		
		$offset = mt_rand(0, 1000);
		$key = 'index_epins_'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) { 
		    $this->view->setVar('navigations', $this->get_user($auth['id']));  
		}
		$this->view->setVar('epins', $this->track_epin($auth['id']));
		$this->view->cache(array("key" => $key));
		$this->view->paginationUrl = $this->paginationUrl;
	}
	
	public function transferAction() {
		parent::pageProtect();
		$auth = $this->session->get('jun_user_auth');
		
		// Role
		$this->role($auth['role'], array(1, 2, 3, 4, 5, 6, 7, 8, 9));
		
		$this->view->hide = 0;  
	    $this->view->setVar('navigations', $this->get_user($auth['id']));
	    $this->flashSession->output();
	    if($this->request->isPost()) {
			$username = $this->request->getPost('username');
            $count = $this->request->getPost('count');
            $master_key = $this->request->getPost('master_key');
            // Check valid number
            if(!is_numeric($count)) { 
                // Check epin balance
				$this->flash->error('Jumlah ePin tidak sah, Sila masukan nombor sahaja'); 	 
			} elseif(strlen($username) < 5 && strlen($username) > 18) {
				$this->flash->error('Username penerima tidak sah');
			} elseif(!ctype_alnum($username)) {
				$this->flash->error('Please enter valid username');
			} elseif($count > count($this->select_epin($auth['id']))) {
				$this->flash->error('You have no iPin to transfer.');
			} elseif(count($this->select_user($username)) != 1) {
				$this->flash->error('Username not found or not upgrade to iKomuniti.');
			} elseif(count($this->master_key($auth['id'], $master_key)) == 0) {
				$this->flash->error('Transaction code not match');
			} else {
			    $_SESSION['csrf'] = $this->passwordHash(date('YmdHis'));
			    // Hide form
			    $this->view->hide = 1;
			    
			    $users = Users::findFirst("username='$username'");
				$this->flash->success('<h3>Adakah anda pasti?</h3>');
				     
				    echo '<form action="" method="get">';
				    echo '<input type="hidden" name="csrset" value="'.$_SESSION['csrf'].'">';
				    echo '<input type="hidden" name="ntsv" value="'.$this->passwordHash($users->username).'">';
				    echo '<input type="hidden" name="ref" value="'.$this->passwordHash($users->username).date('YmdHis').'">';
				    echo '<input type="hidden" name="status" value="'.$users->id.'">';
					echo '<input type="hidden" name="username" value="'.$users->username.'">';
				    echo '<input type="hidden" name="nt" value="'.$count.'">';
					echo '<p class="lead">Username Penerima:<b>'.$users->username.'</b></p>';
					echo '<p class="lead">Nama Penerima: <b>'.$users->name.'</b></p>';
					echo '<p class="lead">No Pendaftaran: <b>'.$users->reg_number.'</b></p>';
					echo '<p class="lead">No Telefon: <b>'.$users->telephone.'</b></p>';
				    echo '<input type="submit" name="proceed" value="Batal" class="btn btn-danger">&nbsp;
					<input type="submit" name="proceed" value="Teruskan" class="btn btn-success">';
					echo '</form>';
			
			} 
			
			 
		} 
	    
	    
	     // Confirmation transfer epin
		if(isset($_GET['ref']) && isset($_GET['ntsv']) && isset($_GET['status']) && isset($_GET['proceed']) && isset($_GET['nt'])) {
			if($_GET['proceed'] == 'Batal') {
				$this->response->redirect('epins/transfer');
			} elseif($_GET['proceed'] == 'Teruskan' && is_numeric($_GET['status']) && is_numeric($_GET['nt']) && ctype_alnum($_GET['ref'])) {
				
				// Prevent REFRESH PAGE
				$token = $_GET['ref'];
				if(count($this->select_epin_token($token)) > 0) { 
					$this->flashSession->error('Error, invalid token.');
					return $this->response->redirect('epins/transfer');
				} elseif($_SESSION['csrf'] != $_GET['csrset']) {
					$this->flashSession->error('Error, invalid token.');
					return $this->response->redirect('epins/transfer');
				} else {
					// Proceed transfer
					$recipent_username = $_GET['username'];
					$receiver_id = $_GET['status'];
					$total_epin = $_GET['nt'];
					$sender_id = $auth['id'];
					$sender_username = $auth['username'];
					
					// Proceed
				    if($this->update_epin($receiver_id, $sender_id, $sender_username, $total_epin, $token)) {
				        unset($_SESSION['csrf']);
						$this->flashSession->success('iPin transfer has been done.');
						return $this->response->redirect('epins/transfer');
					} else {
						$this->flash->error('Error pada iPin transfer');
				    } 	
				}
				
				
			} else {
				$this->flash->error('Pemindahan iPin tidak sah');
			} 
		} 
	} 
	
		/*
	*  Update ePin user_id to receiver
	*/
	private function update_epin($to_user_id, $from_user_id, $from_username, $limit, $token) {
	    $date = date('Y-m-d H:i:s');
	    if($limit <= count($this->select_epin($from_user_id))) {
		   $phql = "UPDATE JunMy\Models\Epins SET  
							last_owner = CONCAT(last_owner, ', ', '$from_username'), 
							token = '$token', 
							created = '$date',
							user_id = '$to_user_id'
							WHERE user_id='$from_user_id' AND used_user_id = '0' LIMIT $limit";
					$update = $this->modelsManager->executeQuery($phql);
					return $update;	
			
		} else {
			die('Error');
		}
		
	}
	
	/*
	*  Update epin histories
	*/
	private function transfer_history($epin_id, $sender_id, $epin, $to_user_id) {
		$hist = new Epinhistories();
		$hist->epin_id = $epin_id;
		$hist->user_id = $sender_id;
		$hist->epin = $epin;
		$hist->created = date('Y-m-d H:i:s');
		$hist->to_user_id = $to_user_id;
		return $hist->save();
	}	 
	
	/*
	*  Prevent refresh transfer on get form
	*/
    private function select_epin_token($token) {
		$phql = "SELECT id FROM JunMy\Models\Epins WHERE token = '$token' LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql);
		
		return $rows;
	}
	
	/*
	*  Select and count epin balance from sender
	*/
	private function select_epin($user_id) {
		$phql = "SELECT id FROM JunMy\Models\Epins WHERE user_id = '$user_id' AND used_user_id = '0'";
		$rows = $this->modelsManager->executeQuery($phql);
		
		return $rows;
	}
	 
	
	/*
	*  Select and count master key from users table
	*/
	private function master_key($user_id, $master_key) {
		$phql = "SELECT master_key FROM JunMy\Models\Users WHERE id = '$user_id' AND master_key = '$master_key' LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql);
		
		return $rows;
	}
    
    /*
	*  Select count valid username
	*/
    private function select_user($username) {
		$phql = "SELECT * FROM JunMy\Models\Users WHERE username = '$username' AND role >= 1 LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql);
		return $rows;
	}
	
	private function get_user($id) {
	    $phql = "SELECT * FROM JunMy\Models\Users WHERE id = '$id' LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql);
		   
		return $rows;
	}
	
	private function count_user($id) {
	    $phql = "SELECT username FROM JunMy\Models\Users WHERE username = '$id' LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql);
		//$this->view->since = date('j F, Y', strtotime($rows['users']['created']));
		
		return count($rows);
	}
	
	/*
	*  Update ePin user_id to receiver
	
	private function update_epin($to_user_id, $from_user_id, $from_username, $limit, $token) {
	    $date = date('Y-m-d H:i:s');
	    $select = "SELECT id, epin FROM JunMy\Models\Epins WHERE user_id = '$from_user_id' AND status = '0' AND used_user_id = '0' LIMIT $limit";
		$rows = $this->modelsManager->executeQuery($select);
		foreach($rows as $row) {
			$id = $row['id']; 
			$epin = $row['epin'];
			$phql = "UPDATE JunMy\Models\Epins SET  
					last_owner = CONCAT(last_owner, ', ', '$from_username'), 
					token = '$token', 
					created = '$date',
					user_id = '$to_user_id'
					WHERE id = '$id' LIMIT $limit";
			$update = $this->modelsManager->executeQuery($phql);
			if($update) {
				return $this->transfer_history($id, $from_user_id, $epin, $to_user_id);
			} 
		
		}
	}*/
	
	private function track_epin($id) {
		
	    $records_per_page = 15;
	    $paginations = new Pagination();
        $paginate = (($paginations->get_page() - 1) * $records_per_page);
		$phql = "SELECT 
		        e.id AS id, 
				e.epin AS epin,
				 DATE_FORMAT(e.created,'%d %b %h:%i %p') AS created,
				e.status AS status,
				e.used_user_id AS used_user_id,
				e.last_owner AS last_owner,
				u.username AS username,
				o.username AS activator_username
			FROM JunMy\Models\Epins AS e
			INNER JOIN JunMy\Models\Users AS u ON(e.used_user_id = u.id)
			LEFT JOIN JunMy\Models\Users AS o ON(e.user_id = o.id)
			WHERE e.user_id = '$id' AND e.used_user_id != '0'
			ORDER BY e.created ASC";
		$count = $this->modelsManager->executeQuery($phql);	
        $paginations->records(count($count));
        $rows = $this->modelsManager->executeQuery($phql." LIMIT $paginate , $records_per_page");	
        // records per page
        $paginations->records_per_page($records_per_page);
		$this->paginationUrl = $paginations->render();

		return $rows;
	
	} 

    private function view_epin($id) {
		
	    $records_per_page = 15;
	    $paginations = new Pagination();
        $paginate = (($paginations->get_page() - 1) * $records_per_page);
		$phql = "SELECT
		    *
			FROM JunMy\Models\Epins 
			WHERE user_id = '$id' AND used_user_id = '0'
			ORDER BY id ASC";
		$count = $this->modelsManager->executeQuery($phql);	
        $paginations->records(count($count));
        $rows = $this->modelsManager->executeQuery($phql." LIMIT $paginate , $records_per_page");	
        // records per page
        $paginations->records_per_page($records_per_page);
		$this->paginationUrl = $paginations->render();

		return $rows;
	
	}
	
	private function generate($length = 12) {
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
	
	public function passwordHash($pwd, $salt = null) {
        if ($salt === null)     {
            $salt = substr(md5(uniqid(rand(), true)), 0, $this->salt_length);
        } else {
            $salt = substr($salt, 0, $this->salt_length);
        }
        return $salt . sha1($pwd . $salt);
    }

}