<?php

namespace JunMy\Admin\Controllers;

use JunMy\Components\Pagination\Pagination;


class PayoutsController extends ControllerBase {
	
	public $paginationUrl;
	
	public function initialize() {
        //Set the document title
        $this->tag->setTitle('Payout Reports');
        parent::initialize();
    }
    
    public function indexAction() {
		parent::pageProtect();
		$this->flashSession->output();
		$auth = $this->session->get('junauth');
		$this->role($auth['role'], array(3, 4, 5, 6, 7));
		$this->view->setVar('navigations', $this->get_user($auth['id']));
		
	}
	
	private function get_user($id) {
	    $phql = "SELECT id, username, role, name FROM JunMy\Models\Users WHERE id = '$id' LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql); 
		return $rows;
	}
}