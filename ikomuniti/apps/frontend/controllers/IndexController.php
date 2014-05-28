<?php
// kjaf356ge6uihdkj
namespace JunMy\Frontend\Controllers;

use JunMy\Models\Users,
    JunMy\Models\Wallets,
	JunMy\Models\Epins,
	JunMy\Models\Insuran,
	JunMy\Models\Usercounters;
	
class IndexController extends ControllerBase {
    
    public $due;
    
    public function initialize() { 
		$this->tag->setTitle('iKomuniti');
		parent::initialize(); 
	}

	public function indexAction() {
	    parent::pageProtect();
	    
	    // Get session in array
	    $auth = $this->session->get('jun_user_auth');
	    $this->view->role = $auth['role'];
	    
	    $this->view->next_renewal_date = $this->next_renewal($auth['id']);
	    
	    $offset = mt_rand(0, 1000);
		$key = 'index_index_'.$auth['id'].'_'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) { 
		    $this->view->setVar('users', $this->get_user($auth['id']));  
		    $this->view->setVar('navigations', $this->get_user($auth['id'])); 
		    $this->view->setVar('informations', $this->get_info($auth['id'])); 
		    $this->view->epin_balance = $this->count_epin($auth['id']);
		    $this->view->count_new_member = $this->count_new_member($auth['username']);
		    $this->view->total_unread = $this->count_message($auth['id']);
		    $this->view->setVar('iprihatins', $this->iprihatin_preview());
		    $this->view->blink = $this->blink_notification($this->due);
		    $this->view->setVar('news', $this->get_news());
		    $this->view->setVar('offers', $this->ioffer_preview());
		} 
		$this->view->cache(array("key" => $key));
		$id = $auth['id'];
		
		$user = Usercounters::findFirst("user_id = '$id'"); 
		if($user->is_one >= 10) {
			if(count($this->event($id, 2, $auth['username'])) >= 10) {
				$this->update_event($id, 2); //LANGKAWI
			}
			if(count($this->event($id, 5, $auth['username'])) >= 10) {
				$this->update_event($id, 5); //VIP
			}
			if(count($this->vvip($id, 5, $auth['username'])) >= 10) {
				$this->update_event($id, 6); //VVIP
			}	
		} 
		  
		if($user->status == 2) {
			$status = 'Langkawi';
		} elseif($user->status == 5) {
			$status = 'Langkawi + VIP';
		} elseif($user->status == 6) {
			$status = 'Langkawi + VVIP';
		} else {
			$status = 'None';
		}
		$this->view->event = $status; 
		// Check profile is complete
		if(count($this->my_profile($auth['id'])) == 0) {
			$this->view->my_profile = 0;
		} else {
			$this->view->my_profile = 1;
		}
	}
	
	public function blink_notification($date) {
	    $time = strtotime($date);
        $final = date("Y-m-d", strtotime("-1 month", $time));
        if(date("Y-m-d") >= $final || date("Y-m-d") >= $time) {
			$color = 'panel-danger';
		} else {
			$color = 'panel-success';
		}
		return $color;
	}
	
	/*
	*  Add vip 
	*/
	private function event($id, $event, $username) { 
		$phql = "SELECT c.user_id AS c_id, u.id AS u_id 
		         FROM 
				 JunMy\Models\Usercounters AS c 
				 LEFT JOIN JunMy\Models\Users AS u ON(u.id = c.user_id)
				 WHERE u.username_sponsor = '$username' AND u.role != '0' AND c.is_one >= '$event'";
	    $rows = $this->modelsManager->executeQuery($phql);
	    return $rows; 
	}
	
	/*
	*  Add  vvip 
	*/
	private function vvip($id, $event, $username) { 
		$phql = "SELECT c.user_id AS c_id, u.id AS u_id 
		         FROM 
				 JunMy\Models\Usercounters AS c 
				 LEFT JOIN JunMy\Models\Users AS u ON(u.id = c.user_id)
				 WHERE u.username_sponsor = '$username' AND c.status >= '$event'";
	    $rows = $this->modelsManager->executeQuery($phql);
	    return $rows; 
	}
    
    private function update_event($user_id, $status) {
        $user = Usercounters::findFirst("user_id = '$user_id'");  
		$user->status = $status;
		return $user->save();
	}
	
	private function get_news() {
		$phql = "SELECT title, DATE_FORMAT(created,'%d %b %h:%i %p') AS created, slug, SUBSTRING(body, 1, 50) AS body FROM JunMy\Models\News ORDER BY id DESC LIMIT 5";
		$rows = $this->modelsManager->executeQuery($phql);
		return $rows;
	}
	
	private function get_user($id) {
	    $phql = "SELECT id, username_sponsor, username, name, insuran_due_date, verified, role FROM JunMy\Models\Users WHERE id = '$id' LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql);
		return $rows;
		 
	}
	
	private function next_renewal($id) {
		$phql = "SELECT next_renewal FROM JunMy\Models\Insuran WHERE user_id = '$id' LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql);
		foreach($rows as $row) {
			return $row['next_renewal'];
		}
	}
	
	private function get_info($id) {
		$phql = "SELECT w.amount AS amount FROM JunMy\Models\Wallets AS w
		 WHERE w.user_id = '$id'";
		$rows = $this->modelsManager->executeQuery($phql);
		return $rows;
	}
	
	private function count_epin($id) {
		$phql = "SELECT id FROM JunMy\Models\Epins WHERE user_id = '$id' AND used_user_id = '0' LIMIT 200";
		$rows = $this->modelsManager->executeQuery($phql);
		return count($rows);
	}
	 
	private function count_new_member($username) {
		$phql = "SELECT id FROM JunMy\Models\Users WHERE username_sponsor = '$username' AND role = '0'";
		$rows = $this->modelsManager->executeQuery($phql);
		return count($rows);
	}
	
	/**
	* Check profile is completed
	*/
	private function my_profile($id) {
		$phql = "SELECT user_id FROM JunMy\Models\Profiles WHERE user_id = :user_id: LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql, array('user_id' => $id));
		return $rows;
	}
	
	/**
	* Count message where 
	*/
	private function count_message($id) {
		$phql = "SELECT id FROM JunMy\Models\Messages WHERE to_user_id = '$id' AND is_read = '0'";
		$rows = $this->modelsManager->executeQuery($phql);
		return count($rows);
	}
	
	private function iprihatin_preview() {
		$phql = "SELECT
		    id, title, DATE_FORMAT(created,'%d %b %h:%i %p') AS created, slug, amount, type, pic, SUBSTRING(body, 1, 30) AS body
			FROM JunMy\Models\Iprihatin WHERE type = '1'
			GROUP BY id ORDER BY id DESC LIMIT 5";
		$rows = $this->modelsManager->executeQuery($phql);	
		return $rows;
	}
	
	private function ioffer_preview() {
		$phql = "SELECT
		    p.id AS id, SUBSTRING(p.title, 1, 50) AS title, p.price AS price, p.stock AS stock,
		    DATE_FORMAT(p.created,'%d %b %h:%i %p') AS created, p.slug AS slug, 
		    i.image_name AS image 
			FROM JunMy\Models\Companyproducts AS p
			LEFT JOIN JunMy\Models\Companyproductimages AS i ON(p.id = i.company_product_id)
			WHERE p.status = '1' AND p.stock != '0'
			GROUP BY p.id ORDER BY p.id DESC LIMIT 10";
		$rows = $this->modelsManager->executeQuery($phql);
		return $rows;
	}
}

