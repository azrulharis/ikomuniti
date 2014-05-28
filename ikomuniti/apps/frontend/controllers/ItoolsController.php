<?php

namespace JunMy\Frontend\Controllers;

use JunMy\Models\Users;
use JunMy\Components\Pagination\Pagination;

class ItoolsController extends ControllerBase {
	
	public $paginationUrl;
	
	public function initialize() { 
		$this->tag->setTitle('iTool');
		parent::initialize(); 
	}
	
	public function indexAction() {
		parent::pageProtect();
	     
	    $auth = $this->session->get('jun_user_auth');
	    $this->view->setVar('navigations', $this->get_user($auth['id']));
	    $this->view->username = $auth['username'];
	    $this->view->host = $this->host();
	}
	
	public function viewAction() {
		parent::pageProtect(); 
	    $auth = $this->session->get('jun_user_auth');
	    $this->view->setVar('navigations', $this->get_user($auth['id'])); 
	    $this->view->setVar('stats', $this->stats($auth['id']));
	}
	
	private function stats($id) {
		
	    $records_per_page = 30;
	    $paginations = new Pagination();
        $paginate = (($paginations->get_page() - 1) * $records_per_page);
		$phql = "SELECT 
		            SUBSTRING(s.http_ref, 1, 70) AS ref, s.status AS status, DATE_FORMAT(s.created,'%d %b %h:%i %p') AS created, s.downline_id AS d_id, s.counter AS counter,
		            u.username AS d_username
			FROM JunMy\Models\Hits AS s
			LEFT OUTER JOIN JunMy\Models\Users AS u ON(s.downline_id = u.id) 
			WHERE s.user_id = '$id'
			ORDER BY s.created DESC";
		$count = $this->modelsManager->executeQuery($phql);	
        $paginations->records(count($count));
        $rows = $this->modelsManager->executeQuery($phql." LIMIT $paginate , $records_per_page");	
        // records per page
        $paginations->records_per_page($records_per_page);
		$this->paginationUrl = $paginations->render();

		return $rows;
	}
	
	public function graphAction() { 
		$date = date('Y-m-d', strtotime('-30 days'));
		  //  
		$auth = $this->session->get('jun_user_auth');
		$id = $auth['id'];
		$this->view->disable(); 
		$phql = "SELECT DATE(created) AS created, COUNT(id) AS counter FROM JunMy\Models\Hits WHERE user_id = '$id' AND created > '$date' GROUP BY DATE(created)";
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
	
	public function graphisahabatAction() { 
		$date = date('Y-m-d', strtotime('-30 days'));
		$auth = $this->session->get('jun_user_auth');
		$id = $auth['id']; 
		$this->view->disable(); 
		$phql = "SELECT DATE(created) AS created, COUNT(id) AS counter FROM JunMy\Models\Hits WHERE user_id = '$id' AND created > '$date' AND status = '1' GROUP BY DATE(created)";
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
	
	public function graphikomunitiAction() { 
		$date = date('Y-m-d', strtotime('-30 days'));
		$auth = $this->session->get('jun_user_auth');
		$username = $auth['username']; 
		$this->view->disable(); 
		$phql = "SELECT DATE(created) AS created, COUNT(id) AS counter FROM JunMy\Models\Users WHERE username_sponsor = '$username' AND created > '$date' AND role != '0' GROUP BY DATE(created)";
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
	
	private function get_user($id) {
	    $phql = "SELECT id, username_sponsor, username, name, insuran_due_date, verified, role FROM JunMy\Models\Users WHERE id = '$id' LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql);
		return $rows;
		 
	}
}