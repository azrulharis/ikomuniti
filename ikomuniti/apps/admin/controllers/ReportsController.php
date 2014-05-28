<?php

namespace JunMy\Admin\Controllers;
 
use JunMy\Models\Users;  
use JunMy\Components\Pagination\Pagination;

class ReportsController extends ControllerBase {
 
    public $paginationUrl;
	
	public function initialize() {
		$this->tag->setTitle('iReports');
		parent::initialize();
	}
	
	public function indexAction() {
		parent::pageProtect(); 
	    $auth = $this->session->get('junauth');
	    
		$offset = mt_rand(0, 561000);  
		$key = 'admin_report_index_'.$offset;
		
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) { 
			$this->view->setVar('navigations', $this->get_user($auth['id']));
		} 
		$this->view->cache(array("key" => $key)); 
		$this->view->set_view = 0;
		$this->view->set_print = 0;
		if(isset($_GET['start']) && isset($_GET['end'])) {
			$start = $this->request->getQuery('start');
			$end = $this->request->getQuery('end');
			if($this->isValidDate($start) && $this->isValidDate($end)) {
				$this->view->start = $start;
				$this->view->end = $end;
				$this->view->counter = count($this->joining_report($start, $end));
				$this->view->set_view = 1;
				$this->view->set_print = 1;
				$this->view->path = $this->admin_path();
				$this->view->setVar('reports', $this->joining_report($start, $end)); 
			} else {
				$this->flash->error('Please enter valid date format.');
			}
		}
		// If search by username
		if(isset($_GET['username'])) {
			if(ctype_alnum($_GET['username'])) {
				$username = $_GET['username']; 
				$this->view->set_view = 1;
				$this->view->set_print = 2;
				$this->view->username = $username;
				$this->view->path = $this->admin_path();
				$this->view->counter = count($this->joining_report_username($username));
				$this->view->setVar('reports', $this->joining_report_username($username)); 
			} else {
				$this->flash->error('Please enter valid username.');
			}
		} 
	}
	
	public function printAction() {
		if(isset($_GET['start']) && isset($_GET['end'])) {
			$start = $this->request->getQuery('start');
			$end = $this->request->getQuery('end');
			if($this->isValidDate($start) && $this->isValidDate($end)) {
				$this->view->setVar('reports', $this->joining_report($start, $end)); 
				
			} else {
				$this->flash->error('Please enter valid date format.');
			}
		} 
		
		if(isset($_GET['username'])) {
			if(ctype_alnum($_GET['username'])) {
				$username = $_GET['username'];
				$this->view->setVar('reports', $this->joining_report_username($username)); 
			} else {
				$this->flash->error('Please enter valid username.');
			}
		}
	}
	
	public function renewalAction() {
		parent::pageProtect(); 
	    $auth = $this->session->get('junauth');
	    
		$offset = mt_rand(0, 561000);  
		$key = 'admin_report_renewal_'.$offset;
		
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) { 
			$this->view->setVar('navigations', $this->get_user($auth['id']));
		} 
		$this->view->cache(array("key" => $key)); 
		$this->view->setVar('reports', $this->renewal_report());
		$this->view->paginationUrl = $this->paginationUrl; 
		
		// View Gross and Count result
		 
		foreach($this->sum_gross() as $result) {
			$this->view->gross = round($result['gross'], 2);
			$this->view->result = round($result['result'], 2);
			$profit = $result['gross'] / 100 * 10;
			$this->view->gross_profit = round($profit, 2);
		} 
	}
	
	public function bankinAction() {
		parent::pageProtect(); 
	    $auth = $this->session->get('junauth');
	    
		$offset = mt_rand(0, 561000);  
		$key = 'admin_report_bankin_'.$offset;
		
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) { 
			$this->view->setVar('navigations', $this->get_user($auth['id']));
		} 
		$this->view->cache(array("key" => $key)); 
		$this->view->setVar('reports', $this->bankin_report());
		$this->view->paginationUrl = $this->paginationUrl;
		// View Gross and Count result
		 
		foreach($this->sum_gross() as $result) {
			$this->view->gross = round($result['gross'], 2);
			$this->view->result = round($result['result'], 2);
		} 
	}
	
	public function payoutAction() {
		parent::pageProtect(); 
	    $auth = $this->session->get('junauth');
	    
		$offset = mt_rand(0, 561000);  
		$key = 'admin_report_bankin_'.$offset;
		
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) { 
			$this->view->setVar('navigations', $this->get_user($auth['id']));
		} 
		$this->view->cache(array("key" => $key)); 
		$this->view->setVar('reports', $this->payout_action());
		$this->view->paginationUrl = $this->paginationUrl;
		// View Gross and Count result
		foreach($this->sum_gross() as $gross) {
			$this->view->gross = $gross['gross']; 
		} 
		 
		foreach($this->sum_payout() as $result) {
			$this->view->payout = round($result['gross'], 2);
			$this->view->result = round($result['result'], 2);
		} 
		
		foreach($this->sum_payout_sms() as $res) {
			$this->view->sum_sms = round($res['sum_sms'], 2); 
		}  
	}
	
	public function iprihatinAction() {
		parent::pageProtect(); 
	    $auth = $this->session->get('junauth');
	     
		$this->view->setVar('navigations', $this->get_user($auth['id']));
		 
		// Set view for total donation
		$this->view->sum_donation = $this->sum_donation();
		
		$this->view->setVar('reports', $this->iprihatin());
		$this->view->paginationUrl = $this->paginationUrl;
		 
	}
	
	private function iprihatin() {
		$records_per_page = 30;
	    $paginations = new Pagination();
        $paginate = (($paginations->get_page() - 1) * $records_per_page);
		$phql = "SELECT   
				    i.id AS i_id, i.user_id AS user_id, i.amount AS amount, i.created AS donation_date,
				    p.title AS title, p.slug AS slug,
					u.username AS username,
					u.reg_number AS reg_number
			FROM JunMy\Models\Iprihatindonations AS i
			LEFT JOIN JunMy\Models\Iprihatin AS p ON(i.iprihatin_id = p.id)
			LEFT JOIN JunMy\Models\Users AS u ON(u.id = i.user_id) 
			ORDER BY i.id DESC";
		$count = $this->modelsManager->executeQuery($phql);	
        $paginations->records(count($count));
        $rows = $this->modelsManager->executeQuery($phql." LIMIT $paginate , $records_per_page");	
        // records per page
        $paginations->records_per_page($records_per_page);
		$this->paginationUrl = $paginations->render();

		return $rows;
	}
	
	private function sum_donation() {
		$phql = "SELECT   
				    SUM(amount) AS sum_amount
			FROM JunMy\Models\Iprihatindonations";
		$rows = $this->modelsManager->executeQuery($phql);
		foreach($rows as $row) {
			return $row['sum_amount'];
		}
	}
	
	private function payout_action() {
		//Renewalhistories
		$records_per_page = 30;
	    $paginations = new Pagination();
        $paginate = (($paginations->get_page() - 1) * $records_per_page);
		$phql = "SELECT   
				    i.amount AS payout_amount, 
					i.created AS payout_created, 
					i.reference AS ref, 
					i.pic AS pic,  
					u.username AS ikomuniti_username,
					u.reg_number AS reg_number,
					a.username AS pic_username
			FROM JunMy\Models\Transactions AS i
			LEFT JOIN JunMy\Models\Users AS u ON(u.id = i.user_id)
			LEFT JOIN JunMy\Models\Users AS a ON(a.id = i.pic)
			WHERE i.type = '6'".$this->search_option(2)." ORDER BY i.created DESC";
		$count = $this->modelsManager->executeQuery($phql);	
        $paginations->records(count($count));
        $rows = $this->modelsManager->executeQuery($phql." LIMIT $paginate , $records_per_page");	
        // records per page
        $paginations->records_per_page($records_per_page);
		$this->paginationUrl = $paginations->render();

		return $rows;
	}
	
	private function bankin_report() {
		//Renewalhistories
		$records_per_page = 30;
	    $paginations = new Pagination();
        $paginate = (($paginations->get_page() - 1) * $records_per_page);
		$phql = "SELECT   
				    i.amount AS bank_amount, 
					i.created AS bank_created, 
					i.reference AS reference, 
					i.pic AS pic,  
					u.username AS ikomuniti_username,
					u.reg_number AS reg_number,
					a.username AS pic_username
			FROM JunMy\Models\Transactions AS i
			LEFT JOIN JunMy\Models\Users AS u ON(u.id = i.user_id)
			LEFT JOIN JunMy\Models\Users AS a ON(a.id = i.pic)
			WHERE i.type = '7'".$this->search_option(2)." ORDER BY i.created DESC";
		$count = $this->modelsManager->executeQuery($phql);	
        $paginations->records(count($count));
        $rows = $this->modelsManager->executeQuery($phql." LIMIT $paginate , $records_per_page");	
        // records per page
        $paginations->records_per_page($records_per_page);
		$this->paginationUrl = $paginations->render();

		return $rows;
	}
	
	private function renewal_report() {
		//Renewalhistories
		$records_per_page = 30;
	    $paginations = new Pagination();
        $paginate = (($paginations->get_page() - 1) * $records_per_page);
		$phql = "SELECT 
				    i.insurance AS insurance, 
					i.wind_screen AS wind_screen, 
					i.second_driver AS second_driver, 
					i.road_tax AS road_tax, 
					i.cover AS cover, 
					i.service_charge AS service_charge, 
					i.total AS total, 
					i.next_renewal AS next_renewal, 
					i.created AS created_at,  
					i.tracking_code AS tracking_code, 
					i.delivery_method AS delivery_method, 
					i.crp AS crp, 
					i.pa AS pa,
					u.username AS ikomuniti_username,
					u.reg_number AS reg_number,
					a.username AS pic_username
			FROM JunMy\Models\Renewalhistories AS i
			LEFT JOIN JunMy\Models\Users AS u ON(u.id = i.user_id)
			LEFT JOIN JunMy\Models\Users AS a ON(a.id = i.pic)
			".$this->search_option(1)." ORDER BY i.id DESC";
		$count = $this->modelsManager->executeQuery($phql);	
        $paginations->records(count($count));
        $rows = $this->modelsManager->executeQuery($phql." LIMIT $paginate , $records_per_page");	
        // records per page
        $paginations->records_per_page($records_per_page);
		$this->paginationUrl = $paginations->render();

		return $rows;
	}
	
	/*
	*  SUM gross  from ikomuniti renewal
	*  Used on renewal action
	*/
	private function sum_gross() {
		$phql = "SELECT   
					SUM(i.insurance) AS gross,
					COUNT(i.id) AS result
			FROM JunMy\Models\Renewalhistories AS i
			".$this->search_option(1)." ORDER BY i.created DESC";
		$rows = $this->modelsManager->executeQuery($phql);
		return $rows; 
	}
	
	/*
	*  SUM bankin from ikomuniti
	*  Used on bankin action
	*/
	private function sum_bankin() {
		$phql = "SELECT   
					SUM(i.amount) AS gross,
					COUNT(i.id) AS result
			FROM JunMy\Models\Transactions AS i
			WHERE i.type = '7'".$this->search_option(2)." ORDER BY i.id DESC";
		$rows = $this->modelsManager->executeQuery($phql);
		return $rows; 
	}
	
	/*
	*  SUM payout
	*  Used on payout action
	*/
	private function sum_payout() {
		$phql = "SELECT   
					SUM(i.amount) AS gross,
					COUNT(i.id) AS result
			FROM JunMy\Models\Transactions AS i
			WHERE i.type = '6'".$this->search_option(2)." ORDER BY i.created DESC";
		$rows = $this->modelsManager->executeQuery($phql);
		return $rows; 
	}
	
	/*
	*  SUM payout
	*  Used on payout action
	*/
	private function sum_payout_sms() {
		$phql = "SELECT   
					SUM(i.amount) AS sum_sms 
			FROM JunMy\Models\Transactions AS i
			WHERE i.type = '8'".$this->search_option(2)." ORDER BY i.created DESC";
		$rows = $this->modelsManager->executeQuery($phql);
		return $rows; 
	}

	/*
	*  Search option for phql date
	*  Return STRING
	*/	
	private function search_option($type) {
		if(isset($_GET['start']) && isset($_GET['end'])) {
		    $start = $_GET['start'];
		    $end = $_GET['end'];
			if($this->isValidDate($start) && $this->isValidDate($end)) {
		        if($type == 1) {
		            // USED ON RENEWAL REPORT
					return " WHERE i.created >= '$start' AND i.created <= '$end'";
				} elseif($type == 2) {
				    // USED ON BANK IN REPORT
					return " AND i.created >= '$start' AND i.created <= '$end'";
				}
				 
			} 
		}
	}
	
	private function get_user($id) {
	    $phql = "SELECT id, username, role, name FROM JunMy\Models\Users WHERE id = '$id' LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql); 
		return $rows;
	}
	
	private function joining_report($start, $end) {
		$phql = "SELECT  
					u.id AS uid, u.username_sponsor AS username_sponsor, u.username AS username, u.name AS name, 
					u.nric_new AS nric_new, u.kin_name AS kin_name, u.relation AS relation, u.nric_new_kin AS nric_new_kin,
					u.bank_number AS bank_number, u.bank_name AS bank_name, u.address AS address, u.second_address AS second_address, u.city AS city, u.region AS region, u.postcode AS postcode, u.kin_phone AS kin_phone,
					u.telephone AS telephone, u.occupation AS occupation,
					u.email AS email, u.previous_insuran_company AS previous_insuran_company,
					u.cover_note AS cover_note, u.insuran_ncb AS insuran_ncb, u.road_tax AS road_tax, 
					u.insuran_due_date AS insuran_due_date, u.reg_number AS reg_number, u.owner_name AS owner_name,
					u.owner_nric AS owner_nric, u.owner_dob AS owner_dob, u.model AS model, u.year_make AS year_make, 
					u.capacity AS capacity, u.engine_number AS engine_number,
					u.chasis_number AS chasis_number, u.grant_serial_number AS grant_serial_number, 
					u.created AS created_at,
					e.epin AS epin, e.last_owner AS last_owner 
		  FROM JunMy\Models\Users AS u
		  LEFT JOIN JunMy\Models\Epins AS e ON(e.used_user_id = u.id)  
		  WHERE u.created >= '$start' AND u.created <= '$end' AND u.role = '1'";
		$rows = $this->modelsManager->executeQuery($phql); 
		return $rows;
	}
	
	private function joining_report_username($username) {
		$phql = "SELECT  
					u.id AS uid, u.username_sponsor AS username_sponsor, u.username AS username, u.name AS name, 
					u.nric_new AS nric_new, u.kin_name AS kin_name, u.relation AS relation, u.nric_new_kin AS nric_new_kin,
					u.bank_number AS bank_number, u.bank_name AS bank_name, u.address AS address, u.postcode AS postcode, 
					u.telephone AS telephone, 
					u.email AS email, u.previous_insuran_company AS previous_insuran_company,
					u.cover_note AS cover_note, u.insuran_ncb AS insuran_ncb, u.road_tax AS road_tax, 
					u.insuran_due_date AS insuran_due_date, u.reg_number AS reg_number, u.owner_name AS owner_name,
					u.owner_nric AS owner_nric, u.owner_dob AS owner_dob, u.model AS model, u.year_make AS year_make, 
					u.capacity AS capacity, u.engine_number AS engine_number,
					u.chasis_number AS chasis_number, u.grant_serial_number AS grant_serial_number, 
					u.created AS created,
					e.epin AS epin, e.last_owner AS last_owner  
		  FROM JunMy\Models\Users AS u
		  LEFT OUTER JOIN JunMy\Models\Epins AS e ON(e.used_user_id = u.id)  
		  WHERE u.username = '$username' AND u.role != '0' LIMIT 5";
		$rows = $this->modelsManager->executeQuery($phql); 
		return $rows;
	}
	
    private function isValidDate($date) {
		if(preg_match("/^(\d{4})-(\d{2})-(\d{2})$/", $date, $matches)) {
			if(checkdate($matches[2], $matches[3], $matches[1])) {
				return true;
			}
		}
	}
	
}