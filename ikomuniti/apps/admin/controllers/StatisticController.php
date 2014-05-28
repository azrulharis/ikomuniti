<?php

namespace JunMy\Admin\Controllers;
 
use JunMy\Models\Users;  
use JunMy\Components\Pagination\Pagination;

class StatisticController extends ControllerBase {
	
	public $paginationUrl;
	
	public function initialize() {
		$this->tag->setTitle('Statistics');
		parent::initialize();
	}
	
	public function indexAction() {
		parent::pageProtect(); 
	    $auth = $this->session->get('junauth');
	    
	    
	}
}