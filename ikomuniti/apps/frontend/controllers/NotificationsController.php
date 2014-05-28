<?php

namespace JunMy\Frontend\Controllers;

use JunMy\Models\Users;
use JunMy\Models\Notifications;
use JunMy\Components\Pagination\Pagination;

class NotificationsController extends ControllerBase {
	
	public $paginationUrl;
	
	public function initialize() {
		$this->tag->setTitle('iKomuniti');
		parent::initialize(); 
	}

    public function indexAction() {
		parent::pageProtect(); 
	    $auth = $this->session->get('jun_user_auth'); 
	    $this->view->setVar('navigations', $this->get_user($auth['id']));
	    $this->view->setVar('notifications', $this->notification($auth['id']));
	    $this->view->paginationUrl = $this->paginationUrl;
	}
	
	public function viewAction() {
		parent::pageProtect(); 
	    $auth = $this->session->get('jun_user_auth'); 
	    $id = $this->dispatcher->getParam('slug');
	    $this->view->setVar('navigations', $this->get_user($auth['id']));
	    $this->view->setVar('notifications', $this->view_notification($id, $auth['id']));
	    $this->update_view($this->dispatcher->getParam('slug'));
	}
	
	private function update_view($id) {
		$note = Notifications::findFirst($id);
		$note->read = 1;
		return $note->save();
	}
	
	private function get_user($id) {
	    $phql = "SELECT * FROM JunMy\Models\Users WHERE id = '$id' LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql);
		 
		return $rows;
	}
	
	private function view_notification($id, $user_id) {
	    $phql = "SELECT id, DATE_FORMAT(created,'%d %b %h:%i %p') AS created, body, read, type 
		FROM JunMy\Models\Notifications WHERE id = '$id' AND user_id = '$user_id' LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql); 
		return $rows;
	}
	
	private function notification($user_id) {
	    $records_per_page = 30;
	    $paginations = new Pagination();
        $paginate = (($paginations->get_page() - 1) * $records_per_page);
	    $phql = "SELECT 
		id, DATE_FORMAT(created,'%d %b %h:%i %p') AS created, SUBSTRING(body, 1, 70) AS body, read, type 
		FROM JunMy\Models\Notifications WHERE user_id = '$user_id' ORDER BY id DESC";
		$count = $this->modelsManager->executeQuery($phql);	
        $paginations->records(count($count));
        $rows = $this->modelsManager->executeQuery($phql." LIMIT $paginate , $records_per_page");	
        // records per page
        $paginations->records_per_page($records_per_page);
		$this->paginationUrl = $paginations->render();

		return $rows;		
	}
}