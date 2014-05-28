<?php

namespace JunMy\Frontend\Controllers;

use JunMy\Components\Pagination\Pagination;
use JunMy\Models\Users; 

class NewsController extends ControllerBase {
	
	public $paginationUrl; 
	
	public function initialize() { 
		$this->tag->setTitle('iNews');
		parent::initialize();
	}
	
    public function indexAction() {
		parent::pageProtect();
		
		$auth = $this->session->get('jun_user_auth');
		$offset = mt_rand(0, 1000);
		$key = 'inews_index_'.$auth['id'].'_'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) {
		    $this->view->setVar('users', $this->get_user($auth['id'])); 
		    $this->view->setVar('navigations', $this->get_user($auth['id'])); 
		    $this->view->setVar('news', $this->all_news());
		    $this->view->paginationUrl = $this->paginationUrl;
			 
		} 
		$this->view->cache(array("key" => $key)); 
	}
	
	public function viewAction() {
		parent::pageProtect();
		
		$auth = $this->session->get('jun_user_auth');
		if(count($this->view_news($this->dispatcher->getParam('slug'))) < 1) {
			$this->flash->error('Error, Page not found on database');
		} else {
			$this->view->setVar('news', $this->view_news($this->dispatcher->getParam('slug')));
		}
		$offset = mt_rand(0, 1000);
		$key = 'inews_view_'.$this->dispatcher->getParam('slug').'_'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) {
		    $this->view->setVar('users', $this->get_user($auth['id'])); 
		    $this->view->setVar('navigations', $this->get_user($auth['id']));
			$this->view->setVar('right_news', $this->right_news());  
		}
		$this->view->cache(array("key" => $key));
		
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
	
	private function get_user($id) {
	    $phql = "SELECT * FROM JunMy\Models\Users WHERE id = '$id' LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql);
		 
		return $rows;
	}
	 
	 
}