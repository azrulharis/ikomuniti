<?php

namespace JunMy\Admin\Controllers;

use JunMy\Models\Users;
	
class IndexController extends ControllerBase {
 
    //public $paginationUrl;
    public function initialize()
    {
        //Set the document title
        $this->tag->setTitle('iManagement');
        parent::initialize();
    }

	public function indexAction() {
	    parent::pageProtect();
	    
	    // Get session in array
	    $auth = $this->session->get('junauth');
	    
	    $offset = mt_rand(0, 1000);
		$key = 'admin_index_index_'.$auth['id'].'_'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) { 
		    $this->view->setVar('users', $this->get_user($auth['id'])); 
		    $this->view->setVar('navigations', $this->get_user($auth['id'])); 
		    $this->view->setVar('informations', $this->get_info($auth['id'])); 
		    $this->view->epin_balance = $this->count_epin($auth['id']);
		    
		    $this->view->total_unread = $this->count_message($auth['id']);
		    $this->view->setVar('iprihatins', $this->iprihatin_preview());
		    
			$this->view->count_all_member = $this->count_all_member();
		    $this->view->today_joining = count($this->today_joining());
		    $this->view->setVar('news', $this->get_news());
		}  
		
		$this->view->cache(array("key" => $key));
		//$this->view->jsongrid = $this->jsongrid();
	}
	
	private function get_user($id) {
	    $phql = "SELECT * FROM JunMy\Models\Users WHERE id = '$id' LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql);
		return $rows;
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
	 
	private function count_all_member() {
		$phql = "SELECT id FROM JunMy\Models\Users WHERE role != '0'";
		$rows = $this->modelsManager->executeQuery($phql);
		return count($rows);
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
		    id, title, DATE_FORMAT(created,'%d %b %h:%i %p') AS created, slug, amount, type, pic, SUBSTRING(body, 1, 70) AS body
			FROM JunMy\Models\Iprihatin WHERE type = '1'
			ORDER BY id DESC LIMIT 5";
		$rows = $this->modelsManager->executeQuery($phql);	
		return $rows;
	}
	
	public function jsongridAction() {
		 $date = date('Y-m-d', strtotime('-30 days'));
		  //  
		$this->view->disable(); 
		$phql = "SELECT DATE(created) AS created, COUNT(id) AS counter FROM JunMy\Models\Users WHERE role > '0' AND created > '$date' GROUP BY DATE(created)";
		$rows = $this->modelsManager->executeQuery($phql); 
		$data = array();
		foreach($rows as $row) { 
            $data[] = array(
			'd' => $row['created'],
			'visits' => $row['counter']);
		}   
        //Create a response instance
        $response = new \Phalcon\Http\Response();

        //Set the content of the response
        $response->setContent(json_encode($data));
        return $response;
	     
	}
	
	public function jsongridmonthAction() {
		$date = date('Y-m-d', strtotime('-12 month'));
		//DATE_FORMAT(created, '%m')   
		$this->view->disable(); 
		$phql = "SELECT DATE_FORMAT(created, '%m') AS month, DATE_FORMAT(created, '%Y') AS year, COUNT(id) AS counter FROM JunMy\Models\Users WHERE created >= '$date' GROUP BY DATE_FORMAT(created, '%m')";
		$rows = $this->modelsManager->executeQuery($phql);  	
		foreach($rows as $row) { 
            $data[] = array(
			'd' => $row['month'].' - '.$row['year'],
			'visits' => $row['counter']);
		}   
        //Create a response instance
        $response = new \Phalcon\Http\Response();

        //Set the content of the response
        $response->setContent(json_encode($data));
        return $response;
	}
	
	private function today_joining() {
		$phql = "SELECT id FROM JunMy\Models\Users WHERE DATE(created) = DATE(NOW()) AND role != '0'";
		$rows = $this->modelsManager->executeQuery($phql);  
		return $rows;
	}
	
	private function get_news() {
		$phql = "SELECT title, DATE_FORMAT(created,'%d %b %h:%i %p') AS created, slug, SUBSTRING(body, 1, 70) AS body FROM JunMy\Models\News ORDER BY id DESC LIMIT 5";
		$rows = $this->modelsManager->executeQuery($phql);
		return $rows;
	}
	
}

