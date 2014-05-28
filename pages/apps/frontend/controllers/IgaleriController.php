<?php

namespace JunMy\Frontend\Controllers; 

use JunMy\Components\Pagination\Pagination;

class IgaleriController extends ControllerBase {

    public $paginationUrl;
	
	public function initialize() {
		$this->tag->setTitle('iGaleri');
		parent::initialize();
	} 
    
    public function indexAction() {
		
	}
}