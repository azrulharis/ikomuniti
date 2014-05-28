<?php

namespace JunMy\Admin\Controllers;

use JunMy\Models\Users;
use JunMy\Models\Epins;
use JunMy\Components\Pagination\Pagination;

class EpinsController extends ControllerBase {
	
	
	public $salt_length = 9;
	
	public $paginationUrl;
	
	public function initialize() {
		$this->tag->setTitle('iPin');
		parent::initialize();
	}
	
    public function indexAction() {
		parent::pageProtect();  
		$auth = $this->session->get('junauth');
		$this->role($auth['role'], array(4, 6, 7));
		$user_id = $auth['id'];
	    $this->view->setVar('navigations', $this->get_user($user_id));  
	    $this->view->setVar('epins', $this->view_epin("WHERE e.used_user_id = '0' AND e.status = '1' AND e.user_id = '$user_id'"));
		$this->view->paginationUrl = $this->paginationUrl;
	 
	}
    
    public function addAction() {
        parent::pageProtect();
        
        $auth = $this->session->get('junauth');
        $this->role($auth['role'], array(6, 7));
        $this->view->setVar('navigations', $this->get_user($auth['id'])); 
        
        $this->view->setVar('users', $this->get_user($auth['id']));
		if($this->request->isPost()) {
			if(is_numeric($this->request->getPost('count'))) {
				if($this->request->getPost('count') > 1) {
					// Generate E-Pin using Concate
					$date = date('Y-m-d H:i:s'); 
				    $i = 0;
					for($i > 0; $i < $this->request->getPost('count'); $i++) {
						$epin = new Epins();
						$gen_plus = $this->generate();
	                    $epin->user_id = $auth['id'];
						$epin->epin = $gen_plus; 
						$epin->created = date('Y-m-d H:i:s'); 
						$epin->status = 1;
						$epin->used_username = 0;
						$epin->used_user_id = 0;
						$epin->last_owner = 'system';
						$epin->token = 0;
						$epin->save(); 
					}
					$this->flash->success('iPin has been saved');
					//return $this->modelsManager->executeQuery($phql);	
				} elseif($this->request->getPost('count') == 1) {
					// Generate E-Pin without comma (,)
					
					$epin = new Epins();
					$gen_plus = $this->generate();
                    $epin->user_id = $auth['id'];
					$epin->epin = $gen_plus; 
					$epin->created = date('Y-m-d H:i:s'); 
					$epin->status = 1;
					$epin->used_username = 0;
					$epin->used_user_id = 0;
					$epin->last_owner = 'system';
					$epin->token = 0;
					if($epin->save()) {
						$this->flash->success('iPin has been saved');
					} else {
			            foreach ($epin->getMessages() as $message) {
			                $this->flash->error((string) $message);
			            }
			        }
					
					 
				} else {
					$this->flash->error('Not valid number');
				} 
			} else {
				$this->flash->error('Please enter count epin');
			}
		} 
	}
	public function trackAction() {
		parent::pageProtect();
		
		$auth = $this->session->get('junauth');
		$offset = mt_rand(0, 1000);
		$key = 'admin_track_epins_'.$offset;
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
		$auth = $this->session->get('junauth');
		$this->role($auth['role'], array(4, 6, 7));
		$this->view->hide = 0; 
	    $this->view->setVar('users', $this->get_user($auth['id']));
	    $this->view->setVar('navigations', $this->get_user($auth['id'])); 
	    $this->view->urlajax = $this->url->get('ajax/ajaxusername');
	    
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
				$this->flash->error('Username penerima tidak sah');
			} elseif($count > count($this->select_epin($auth['id']))) {
				$this->flash->error('Baki iPin anda tidak mencukupi');
			} elseif(count($this->select_user($username)) != 1) {
				$this->flash->error('Username tidak terdapat di dalam sistem kami');
			} elseif(count($this->master_key($auth['id'], $master_key)) == 0) {
				$this->flash->error('Kod transaksi tidak sepadan');
			} else {
			    
			    // Hide form
			    $this->view->hide = 1;
			    
			    $users = Users::findFirst("username='$username'");
				$this->flash->success('<h3>Adakah anda pasti?</h3>');
				     
				    echo '<div class="form-group"><form action="" method="get">';
				    echo '<input type="hidden" name="ntsv" value="'.$this->passwordHash($users->username).'">';
				    echo '<input type="hidden" name="ref" value="'.$this->passwordHash($users->username).date('YmdHis').'">';
				    echo '<input type="hidden" name="status" value="'.$users->id.'">';
				    echo '<input type="hidden" name="nt" value="'.$count.'">';
					echo '<p class="lead">Username Penerima:<b>'.$users->username.'</b></p>';
					echo '<p class="lead">Nama Penerima: <b>'.$users->name.'</b></p>';
					echo '<p class="lead">No Pendaftaran: <b>'.$users->reg_number.'</b></p>';
					echo '<p class="lead">No Telefon: <b>'.$users->telephone.'</b></p>';
				    echo '<input type="submit" name="proceed" value="Batal" class="btn btn-warning">&nbsp;
					<input type="submit" name="proceed" value="Teruskan" class="btn btn-success">';
					echo '</form></div>';
			
			} 
			
			 
		} 
		
		
		// Confirmation transfer epin
		if(isset($_GET['ref']) && isset($_GET['ntsv']) && isset($_GET['status']) && isset($_GET['proceed']) && isset($_GET['nt'])) {
			if($_GET['proceed'] == 'Batal') {
				$this->response->redirect('gghadmin/epins/transfer');
			} elseif($_GET['proceed'] == 'Teruskan' && is_numeric($_GET['status']) && is_numeric($_GET['nt']) && ctype_alnum($_GET['ref'])) {
				
				// Prevent REFRESH PAGE
				$token = $_GET['ref'];
				if(count($this->select_epin_token($token)) > 0) {
					$this->flash->error('Token tidak sah, sila cuba sekali lagi');
				} else {
					// Proceed transfer
					$receiver_id = $_GET['status'];
					$total_epin = $_GET['nt'];
					$sender_id = $auth['id'];
					$sender_username = $auth['username'];
				    if($this->update_epin($receiver_id, $sender_id, $sender_username, $total_epin, $token)) {
						$this->flash->success('Pemindahan iPin telah berjaya');
					} else {
						$this->flash->error('Error pada iPin transfer');
				    } 	
				}
				
				
			} else {
				$this->flash->error('Pemindahan iPin tidak sah');
			} 
		} 
	}
	
	public function viewuseripinAction() {
		parent::pageProtect();
		$auth = $this->session->get('junauth');
		$this->role($auth['role'], array(3, 4, 6, 7));
		$this->view->setVar('navigations', $this->get_user($auth['id']));
		if($this->request->isGet('username')) {
		    
		    $user_id = $this->usernametoid($this->request->getQuery('username'));
		    $this->view->setVar('epins', $this->view_epin("WHERE e.user_id = '$user_id' AND used_user_id ='0'")); 
		    
		    // Set username for field value
			$get_username = filter_input(INPUT_GET, 'username', FILTER_SANITIZE_ENCODED);
		} else {
		    // Set username for field value if empty
			$get_username = '';
		}
		$this->view->setVar('users', $this->get_user($auth['id'])); 
		$this->view->get_username = $get_username;
		$this->view->paginationUrl = $this->paginationUrl;
	    $this->view->urlajax = $this->url->get('ajax/ajaxusername');
	    
	}
	
	/*
	*  Select count valid username
	*/
    private function select_user($username) {
		$phql = "SELECT * FROM JunMy\Models\Users WHERE username = '$username' LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql);
		return $rows;
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
	*  Select id from username, used on viewuseripin
	*/
	private function usernametoid($username) {
		$phql = "SELECT id FROM JunMy\Models\Users WHERE username = '$username' LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql);
		foreach($rows as $row) {
			return $row['id'];
		}
		
	}
	
	/*
	*  Select and count epin balance from sender
	*/
	private function select_epin($user_id) {
		$phql = "SELECT id FROM JunMy\Models\Epins WHERE user_id = '$user_id'";
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
	
	private function get_user($id) {
	    $phql = "SELECT * FROM JunMy\Models\Users WHERE id = '$id' LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql);
		//$this->view->since = date('j F, Y', strtotime($rows['users']['created']));
		foreach($rows as $key => $row) {
			$this->due = $key['created'];
		}
		return $rows;
	}
	
	private function track_epin($id) {
		
	    $records_per_page = 30;
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
			WHERE e.used_user_id != '0'
			ORDER BY e.created ASC";
		$count = $this->modelsManager->executeQuery($phql);	
        $paginations->records(count($count));
        $rows = $this->modelsManager->executeQuery($phql." LIMIT $paginate , $records_per_page");	
        // records per page
        $paginations->records_per_page($records_per_page);
		$this->paginationUrl = $paginations->render();

		return $rows;
	
	} 


    private function view_epin($where = NULL) {
		
	    $records_per_page = 25;
	    $paginations = new Pagination();
        $paginate = (($paginations->get_page() - 1) * $records_per_page);
		$phql = "SELECT
		    e.id AS id, e.user_id AS user_id, e.epin AS epin, e.created AS created, 
			e.status AS status, e.used_user_id AS used_user_id, SUBSTRING_INDEX(e.last_owner, ', ', -5) AS last_owner,
		    u.username AS username, used.username AS used_username
			FROM JunMy\Models\Epins as e
			INNER JOIN JunMy\Models\Users AS u ON(e.user_id = u.id)
			LEFT JOIN JunMy\Models\Users AS used ON (e.used_user_id = used.id)
			 ".($where == '' ? '' : $where)." ORDER BY e.id DESC";
		 
		$count = $this->modelsManager->executeQuery($phql);	
        $paginations->records(count($count));
        $rows = $this->modelsManager->executeQuery($phql." LIMIT $paginate , $records_per_page");	
        // records per page
        $paginations->records_per_page($records_per_page);
		$this->paginationUrl = $paginations->render();

		return $rows;
	
	}
	
	/*
	*  Update ePin user_id to receiver
	*/
	private function update_epin($to_user_id, $from_user_id, $from_username, $limit, $token) {
	    $date = date('Y-m-d H:i:s');
		$phql = "UPDATE JunMy\Models\Epins SET 
				user_id = '$to_user_id', 
				last_owner = CONCAT(last_owner, ', ', '$from_username'), 
				token = '$token', 
				created = '$date'
				WHERE user_id = '$from_user_id' 
				AND used_user_id = '0' LIMIT $limit";
		$update = $this->modelsManager->executeQuery($phql);
		return $update;
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