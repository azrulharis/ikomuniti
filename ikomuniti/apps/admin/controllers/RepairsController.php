<?php

namespace JunMy\Admin\Controllers;

use JunMy\Models\Users; 
use JunMy\Components\Pagination\Pagination;


class RepairsController extends ControllerBase {
	
	 
	public $paginationUrl;
	 
	
	public function initialize() {
		$this->tag->setTitle('iAdmin');
		parent::initialize();
	}
	
	public function indexAction() {
		parent::pageProtect();
		// Get session in array
	    $auth = $this->session->get('junauth');
	    if($auth['id'] != 9) {
			die('Only Azrul can access this area');
		}
	    
	    $this->view->setVar('views', $this->view());
	     
	   
	    
	    $this->view->paginationUrl = $this->paginationUrl;
	}
	
	private function view() {
		$records_per_page = 50;
	    $paginations = new Pagination();
        $paginate = (($paginations->get_page() - 1) * $records_per_page);
		$phql = "SELECT
		    u.id AS u_id, u.username AS username, u.owner_nric AS owner_ic, u.postcode AS postcode, u.telephone AS phone,
		    d.user_detail_nric AS d_nric, d.user_detail_vehicle_nric AS d_owner_ic, d.user_detail_pin AS pin, d.user_detail_vehicle_owner AS d_owner_name, 
		    d.user_detail_name AS d_name,
		    l.user_name AS l_username
			FROM JunMy\Models\Users AS u
			LEFT JOIN JunMy\Models\Loginusers AS l ON(l.user_name = u.username)
			LEFT JOIN JunMy\Models\Userdetails AS d ON(d.user_detail_refid = l.user_id)  
			ORDER BY u.id DESC";
		$count = $this->modelsManager->executeQuery($phql);	
        $paginations->records(count($count));
        $rows = $this->modelsManager->executeQuery($phql." LIMIT $paginate , $records_per_page");	
        
        // records per page
        $paginations->records_per_page($records_per_page);
		$this->paginationUrl = $paginations->render();
		   
		foreach($rows as $row) {
		   $id = $row['u_id'];
		    $owner = $row['d_owner_name'];
		    /* 
			$ic = Users::findFirst($id);
			$ic->owner_nric = $owner;
			if(!$ic->save()) {
				foreach ($ic->getMessages() as $message) {
	                $this->flash->error((string) $message);
	            }
			}	 
			 */
			
		}    
		 
		return $rows;
	}
	
	
}