<?php

namespace JunMy\Admin\Controllers;

use JunMy\Models\Users; 
use JunMy\Models\News;
use JunMy\Components\Pagination\Pagination;

class InewsController extends ControllerBase {
	
	public $paginationUrl; 
	
	public function initialize() { 
		$this->tag->setTitle('iNews');
		parent::initialize();
	}
	
    public function indexAction() {
		parent::pageProtect();
		$this->flashSession->output();
		$auth = $this->session->get('junauth');
		$this->role($auth['role'], array(3, 4, 5, 6, 7));
		$this->flashSession->output();
		// Sve news
		if($this->request->isPost()) {
			if(strlen($this->request->getPost('title')) < 5 || strlen($this->request->getPost('title')) > 64) {
				$this->flash->error('Title too short or too long. Min 5 max 64 character');
			} elseif(strlen($this->request->getPost('body')) < 5) {
				$this->flash->error('News body too short. Min 5 character');
			} elseif($this->request->getPost('visible') == '') {
				$this->flash->error('Please select visibility');
			} else {
			    $title = $this->request->getPost('title'); 
				$body = $this->request->getPost('body'); 
				$visible = $this->request->getPost('visible');
				if($this->insert_news($title, $body, $visible)) {
					$this->flashSession->success('iNews has been saved');
					return $this->response->redirect('gghadmin/inews/index');
				}
			}
		}
		
		$this->view->setVar('navigations', $this->get_user($auth['id']));
		$this->view->setVar('news', $this->all_news());
		$this->view->paginationUrl = $this->paginationUrl;
	}
	
	private function insert_news($title, $body, $visible) {
		$news = new News(); 
		$news->title = $title;
		$news->body = $body;
		$news->created = date('Y-m-d H:i:s');
		$news->slug = $this->slug($title);
		$news->visibility = $visible;
		if($news->save()) {
			return true;
		} else {
			foreach ($news->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
		}
	}
	
	public function viewAction() {
		parent::pageProtect();
		$auth = $this->session->get('junauth'); 
		
		$this->view->setVar('news', $this->view_news($this->dispatcher->getParam('slug')));  
	    $this->view->setVar('navigations', $this->get_user($auth['id']));
		$this->view->setVar('right_news', $this->right_news());   
	}
	
	private function all_news() {
		$records_per_page = 15;
	    $paginations = new Pagination();
        $paginate = (($paginations->get_page() - 1) * $records_per_page);
		$phql = "SELECT
		    title, slug, DATE_FORMAT(created,'%d %b %Y %h:%i %p') AS created, SUBSTRING(body, 1, 70) AS body   
			FROM JunMy\Models\News  
			ORDER BY id DESC";
		$count = $this->modelsManager->executeQuery($phql);	
        $paginations->records(count($count));
        $rows = $this->modelsManager->executeQuery($phql." LIMIT $paginate , $records_per_page");	
        // records per page
        $paginations->records_per_page($records_per_page);
		$this->paginationUrl = $paginations->render();

		return $rows;
	} 
	
	// Show on right view
	private function right_news() {
	    $phql = "SELECT title, created, slug, SUBSTRING(body, 1, 70) AS body FROM JunMy\Models\News ORDER BY id DESC LIMIT 5";
		$rows = $this->modelsManager->executeQuery($phql);
		 
		return $rows;
	}
	
	private function view_news($param) {
	    $phql = "SELECT title, slug, DATE_FORMAT(created,'%d %b %Y %h:%i %p') AS created, body FROM JunMy\Models\News WHERE slug = '$param' LIMIT 1";
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
		  WHERE u.id = '$id'";
		$rows = $this->modelsManager->executeQuery($phql); 
		return $rows;
	}
		
	
	/*
	*  VReplace title to url
	*  Return STRING
	*/	
	private function slug($string) {
		return strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', 
		html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', 
		htmlentities($string, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));
	}

}