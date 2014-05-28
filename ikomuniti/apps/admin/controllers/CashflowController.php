<?php

namespace JunMy\Admin\Controllers;

use JunMy\Models\Users;

class CashflowController extends ControllerBase {
	
	public function initialize() {
		$this->tag->setTitle('Cashflow');
		parent::initialize();
	}
	
	public function indexAction() {
		parent::pageProtect();
		// Get session in array
	    $auth = $this->session->get('junauth');
	    $this->role($auth['role'], array(4, 6, 7));
	    $this->view->setVar('navigations', $this->get_user($auth['id']));
	    
	}
	
	public function statisticAction() {
		
	}

    private function cashflow() {
	    $records_per_page = 30;
	    $paginations = new Pagination();
        $paginate = (($paginations->get_page() - 1) * $records_per_page);
		$phql = "SELECT
		    u.id AS id, 
			u.username AS username, 
			u.telephone AS tel, 
			u.reg_number AS reg_no, 
			u.owner_name AS owner,  
			u.model AS model, 
			u.year_make AS year,
			
			w.amount AS amount,
		    
		    i.insurance AS ins_amount, 
			i.road_tax AS r_amount, 
			i.total AS total, 
			SUM(i.total) AS sum_total, 
		    SUM(i.insurance) AS sum_insurance,
			SUM(i.road_tax) AS sum_road_tax,
			SUM(w.amount) AS sum_wallet
			 
			FROM JunMy\Models\Users AS u
			INNER JOIN JunMy\Models\Wallets AS w ON(w.id = u.id)
			LEFT JOIN JunMy\Models\Insuran AS i ON(i.user_id = u.id)
			WHERE i.insurance > '0.00'".$this->search_parameter().$this->search_date()."
			ORDER BY i.next_renewal DESC";
		 
		$count = $this->modelsManager->executeQuery($phql);	
        $paginations->records(count($count));
        $rows = $this->modelsManager->executeQuery($phql." LIMIT $paginate , $records_per_page");	
        // records per page
        $paginations->records_per_page($records_per_page);
		$this->paginationUrl = $paginations->render();

		return $rows;
	}
	
	/*
	*  View MY PROFILE
	*  Return BOOLEAN
	*/	
	private function get_user($id) {
	    $phql = "SELECT * FROM JunMy\Models\Users WHERE id = '$id' LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql);
		//$this->view->since = date('j F, Y', strtotime($rows['users']['created']));
		foreach($rows as $key => $row) {
			$this->due = $key['created'];
		}
		return $rows;
	}
	
}