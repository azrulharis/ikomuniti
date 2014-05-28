<?php

namespace JunMy\Frontend\Controllers;

use JunMy\Models\Users;  

class IresellerController extends ControllerBase {
	
	public $paginationUrl; 
	
	public function initialize() { 
		$this->tag->setTitle('iReseller');
		parent::initialize();
	}
	 
    public function indexAction() {
        $phql = "SELECT user_id,
						name,
						location,
						phone,
						username,
						created,
						profile_image 
            FROM JunMy\Models\Iresellers LIMIT 20";
		$rows = $this->modelsManager->executeQuery($phql); 
		//return $rows;
		
		$this->view->path = $this->profile_image_dir();
		$this->view->setVar('posts', $rows);
	}
	
	 
	 
	 
}