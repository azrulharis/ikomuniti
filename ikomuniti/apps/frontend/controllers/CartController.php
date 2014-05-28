<?php 

namespace JunMy\Frontend\Controllers;

use JunMy\Models\Users;  

class CartController extends ControllerBase {
	 
	
	public function initialize() {
		$this->tag->setTitle('Cart');
		parent::initialize();
	} 
	
	public function indexAction() {
		parent::pageProtect();
	    $this->flashSession->output();
	    // Get session in array
	    $auth = $this->session->get('jun_user_auth');
	    $this->view->role = $auth['role'];
	    $offset = mt_rand(0, 1000);
		$key = 'view_cart_'.$auth['id'].'_'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) {  
		    $this->view->setVar('navigations', $this->get_user($auth['id']));  
		} 
		$this->view->cache(array("key" => $key)); 
	}
	
	public function addAction() {
		parent::pageProtect();
	    $this->flashSession->output();
	    // Get session in array
	    $auth = $this->session->get('jun_user_auth');
	    $this->view->role = $auth['role'];
	    $offset = mt_rand(0, 1000);
		$key = 'view_cart_'.$auth['id'].'_'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) {  
		    $this->view->setVar('navigations', $this->get_user($auth['id']));  
		} 
		$this->view->cache(array("key" => $key)); 
	}
	
	private function get_user($id) {
	    $phql = "SELECT * FROM JunMy\Models\Users WHERE id = :id: LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql, array('id' => $id));
	 
		return $rows;
	}
	
	
}
	