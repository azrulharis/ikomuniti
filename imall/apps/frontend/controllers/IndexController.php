<?php

namespace JunMy\Frontend\Controllers;


	
class IndexController extends ControllerBase {
 
    public function initialize() { 
        $this->tag->setTitle('iMall');
        parent::initialize();
    }

	public function indexAction() { 
	    $this->flashSession->output();
	    $this->view->user_login = 0;
	    if($this->session->has('jun_user_auth')) {
			$this->view->user_login = 1;
			$auth = $this->session->get('jun_user_auth');
			$this->view->setVar('users', $this->get_user($auth['id']));
		}
	    $this->view->setVar('categories', $this->category()); 
	}
	
	private function category() {
		$phql = 'SELECT 
			id, name 
			FROM JunMy\Models\Categories 
			LIMIT 50';
		$rows = $this->modelsManager->executeQuery($phql);
		return $rows;
	}
	
	/*
	*  Select user WHERE user_id = $_SESSION
	*/
	private function get_user($id) {
	    $phql = "SELECT u.username AS username, u.name AS name, u.telephone AS telephone, u.created AS created, 
		  u.address AS address, u.email AS email, u.insuran_due_date AS insuran_due_date, 
		  u.profile_image AS profile_image, u.reg_number AS reg_number,
	      w.amount AS amount
		  FROM JunMy\Models\Users AS u
		  INNER JOIN JunMy\Models\Wallets AS w ON(u.id = w.user_id) 
		  WHERE u.id = :id: LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql, array('id' => $id));
	 
		return $rows;
	}
}

