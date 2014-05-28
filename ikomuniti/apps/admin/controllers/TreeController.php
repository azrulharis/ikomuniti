<?php

namespace JunMy\Admin\Controllers;

use JunMy\Models\Users;

class TreeController extends ControllerBase {
	
	public function initialize() {
		$this->tag->setTitle('iKomuniti');
		parent::initialize();
	}
	
	public function indexAction() {
		parent::pageProtect();
		// Get session in array
	    $auth = $this->session->get('junauth');
	    $this->view->urlajax = $this->url->get('gghadmin/tree/first');
	    $this->view->ajaxurlsecond = $this->url->get('gghadmin/tree/second');
	    $offset = mt_rand(0, 1000);
		$key = 'admin_tree_index_'.$auth['id'].'_'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) {  
		    $this->view->setVar('navigations', $this->get_user($auth['id']));
			
		}  
		$this->view->cache(array("key" => $key));
	}
	
	public function firstAction() {
		$this->view->disable();
		$request = new \Phalcon\Http\Request();
		if($request->isAjax() == true) {
			$auth = $this->session->get('junauth'); 
			$username = 'admin';
			$phql = "SELECT id, username, name, role, DATE_FORMAT(insuran_due_date,'%d %b %Y') AS due_date 
					FROM JunMy\Models\Users WHERE username_sponsor = '$username' LIMIT 1000";
			$rows = $this->modelsManager->executeQuery($phql);
			$result = array();
			foreach($rows as $row) { 
	            $helper = array(); // Array for each Node's Data
			    $helper['attr']['id'] = $row['username']; 
			    $helper['attr']['rel'] = $row['username'];
			    $helper['data']  = $row['username'].' Status: '.$this->user_status($row['role']).' Due: '.$row['due_date'];
			    $helper['state'] = $this->count_downline($row['username']); // if state='closed' this node can be opened
			    $result[] = $helper;
				 
			} 
			$response = new \Phalcon\Http\Response(); 
	        $response->setContent(json_encode($result));
	        return $response;
		 }   
	}
	
	public function secondAction() {
	    $this->view->disable();
	    $request = new \Phalcon\Http\Request();
		if($request->isAjax() == true) {
		    $username = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING); 
			$phql = "SELECT 
			    id, username, name, telephone, role, DATE_FORMAT(insuran_due_date,'%d %b %Y') AS due_date
			    FROM JunMy\Models\Users WHERE username_sponsor = '$username' LIMIT 1000";
			$rows = $this->modelsManager->executeQuery($phql);
			$result = array();
			foreach($rows as $row) { 
	            $helper = array(); // Array for each Node's Data
			    $helper['attr']['id'] = $row['username'];
			    $helper['attr']['rel'] = $row['username'];
			    $helper['data']  = $row['username'].' Status: '.$this->user_status($row['role']).' Due: '.$row['due_date'];
			    $helper['state'] = $this->count_downline($row['username']); // if state='closed' this node can be opened
			    $result[] = $helper;
				 
			} 
			$response = new \Phalcon\Http\Response(); 
	        $response->setContent(json_encode($result));
	        return $response;
	    }
	}
	
	private function user_status($status) {
		if($status == 0) {
			return 'iSahabat';
		} elseif($status == 1) {
			return 'iKomuniti';
		} elseif($status == 2) {
			return 'iReseller';
		} else {
			return 'iManagement';
		}
	}  
	
	private function count_downline($username) {
		$phql = "SELECT id 
				FROM JunMy\Models\Users WHERE username_sponsor = '$username' LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql);
		foreach($rows as $row) {
			if(count($row['id']) > 0) {
				return "closed";
			} else {
				return "";
			}
		}
	}
	
	public function render_tree($username) {
		$phql = "SELECT id, username, name, telephone, DATE_FORMAT(insuran_due_date,'%d %b %Y') AS due_date 
				FROM JunMy\Models\Users WHERE username_sponsor = '$username' LIMIT 1000";
		$rows = $this->modelsManager->executeQuery($phql);
		return $rows;
	}
	
	private function get_user($id) {
	    $phql = "SELECT * FROM JunMy\Models\Users WHERE id = '$id' LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql);
		return $rows;
		 
	}
}