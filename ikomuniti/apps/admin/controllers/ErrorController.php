<?php

namespace JunMy\Admin\Controllers;

use JunMy\Models\Users;

class ErrorController extends ControllerBase {
	
	public function initialize() {
		$this->tag->setTitle('Not allowed access');
		parent::initialize();
	}
	
	public function notallowedAction() {
		parent::pageProtect(); 
		$auth = $this->session->get('junauth');
		$this->view->setVar('navigations', $this->get_user($auth['id']));   
	}
	
	private function get_user($id) {
	    $phql = "SELECT * FROM JunMy\Models\Users WHERE id = :id: LIMIT 1";
	    
		$rows = $this->modelsManager->executeQuery($phql, array('id' => $id));
	 
		return $rows;
	}
}