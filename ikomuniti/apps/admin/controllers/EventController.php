<?php

namespace JunMy\Admin\Controllers;

use JunMy\Models\Users;
use JunMy\Models\Usercounters;
use JunMy\Components\Pagination\Pagination;  

class EventController extends ControllerBase {
	
	public $paginationUrl;
	
	public function initialize() {
		$this->tag->setTitle('Event');
		parent::initialize();
	}
	
	public function indexAction() {
		parent::pageProtect();
		// Get session in array
	    $auth = $this->session->get('junauth');
	    // Role
		$this->role($auth['role'], array(3, 4, 5, 6, 7, 8, 9));
	    
	    // Check vip 
	    $this->check_vip($auth['id'], $auth['username']);
	      
	    $offset = mt_rand(0, 109800);
		$key = 'event_index_'.$auth['id'].'_'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) {   
		    $this->view->setVar('navigations', $this->get_user($auth['id']));
			$this->view->setVar('events', $this->root(2));
		}  
		$this->view->cache(array("key" => $key));
		$this->view->paginationUrl = $this->paginationUrl;
	}
	
	/*
	*  Root user
	*/
	private function root($event) {
		$phql = "SELECT u.username AS username, u.name AS name, u.telephone AS phone,
		             c.is_one AS is_one, c.status AS c_status
					 FROM JunMy\Models\Users AS u
					 LEFT JOIN JunMy\Models\Usercounters AS c ON(u.id = c.user_id)
					 WHERE c.is_one >= '10' LIMIT 140";
		$rows = $this->modelsManager->executeQuery($phql);
		
		foreach($rows as $row) { 
			$username = $row['username'];
			if($this->get_event($username, $event) >= 10) {
				 
				echo "<tr>
				    <td><p>$row[username]</p></td> 
				    <td><p>$row[name]</p></td>
					<td><p>$row[phone]</p></td>  
				</tr>";
			}
		}
	}
	
	private function get_event($username, $event) {
		$phql = "SELECT u.username AS username, 
		             c.is_one AS is_one 
					 FROM JunMy\Models\Usercounters AS c
					 LEFT JOIN JunMy\Models\Users AS u ON(u.id = c.user_id)
					 WHERE c.is_one >= '$event' AND u.username_sponsor = '$username' LIMIT 11";
		$rows = $this->modelsManager->executeQuery($phql);
		return count($rows);
	}
	/*
	*  List user y event
	*/
	private function event($event) {
		$records_per_page = 30;
	    $paginations = new Pagination();
        $paginate = (($paginations->get_page() - 1) * $records_per_page);
		$phql = "SELECT 
		             u.id AS id, u.username AS username,
					 one.id AS one_id, one.username AS one_username, 
					 c.is_one AS c_is_one, c.status AS c_status,
					 d.is_one AS d_is_one, d.status AS d_status
				   FROM JunMy\Models\Users AS u
				   INNER JOIN JunMy\Models\Users AS one ON(one.username_sponsor = u.username)
				   LEFT JOIN JunMy\Models\Usercounters AS c ON(u.id = c.user_id)
				   INNER JOIN JunMy\Models\Usercounters AS d ON(one.id = d.user_id)
				   WHERE d.is_one >= '$event' AND c.is_one >= '10' GROUP BY one.username_sponsor ORDER by u.id ASC";
		$count = $this->modelsManager->executeQuery($phql);	
        $paginations->records(count($count));
        $rows = $this->modelsManager->executeQuery($phql." LIMIT $paginate , $records_per_page");	
        // records per page
        
        $paginations->records_per_page($records_per_page); 
        $this->paginationUrl = $paginations->render();
         
        return $rows;
	}
	  
	
	private function check_vip($user_id, $username) {
		$count = Usercounters::findFirst($user_id);
		if($count->is_one >= 10 && $count->status == 0) {
			// Select is two if each has 2 downline
			$phql = "SELECT u.id AS id, c.is_one AS is_one
				    FROM JunMy\Models\Users AS u
					LEFT JOIN JunMy\Models\Usercounters AS c ON(u.id = c.user_id) 
					WHERE u.username_sponsor = '$username' AND c.is_one >= 2 LIMIT 11";
			$rows = $this->modelsManager->executeQuery($phql);
			//return $rows;
			if(count($rows) >= 10) {
				$count->status = 1;  // Langkawi
				return $count->save(); 
			}
		} elseif($count->is_one >= 10 && $count->status == 1) {
			// Select is two if each has 5 downline
			$phql = "SELECT u.id AS id, c.is_one AS is_one
				    FROM JunMy\Models\Users AS u
					LEFT JOIN JunMy\Models\Usercounters AS c ON(u.id = c.user_id) 
					WHERE u.username_sponsor = '$username' AND c.is_one >= 5 LIMIT 11";
			$rows = $this->modelsManager->executeQuery($phql);
			//return $rows;
			if(count($rows) >= 10) {
				$count->status = 5;  // Vip
				return $count->save(); 
			}
		} elseif($count->is_one >= 10 && $count->status == 5) {
			// Select is two if each has 5 downline
			$phql = "SELECT u.id AS id, c.is_one AS is_one
				    FROM JunMy\Models\Users AS u
					LEFT JOIN JunMy\Models\Usercounters AS c ON(u.id = c.user_id) 
					WHERE u.username_sponsor = '$username' AND c.status == '5' LIMIT 11";
			$rows = $this->modelsManager->executeQuery($phql);
			//return $rows;
			if(count($rows) >= 10) {
				$count->status = 6;  // VVIP
				return $count->save(); 
			}
		}
	} 
	
	private function get_user($id) {
	    $phql = "SELECT id, username, email, name FROM JunMy\Models\Users WHERE id = '$id' LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql);
		return $rows;
		 
	}
}