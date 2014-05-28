<?php 

namespace JunMy\Admin\Controllers;

use JunMy\Models\Users; 
use JunMy\Components\Pagination\Pagination; 

class IsahabatController extends ControllerBase {
	
	public $paginationUrl; 
	
	public function initialize() {
		$this->tag->setTitle('iSahabat');
		parent::initialize();
	} 
	
	public function indexAction() {
		parent::pageProtect();
		// Get session in array
	    $auth = $this->session->get('junauth');
	    $offset = mt_rand(0, 561000);  
		$key = 'adm_user_index_'.$offset;
		
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) {
		    
			$this->view->setVar('views', $this->view_user());
			$this->view->setVar('navigations', $this->get_user($auth['id']));
		}
		$this->view->paginationUrl = $this->paginationUrl;
		$this->view->cache(array("key" => $key)); 
	}

    private function view_user() {
		
	    $records_per_page = 20;
	    $paginations = new Pagination();
        $paginate = (($paginations->get_page() - 1) * $records_per_page);
		$phql = "SELECT
		    id, username, username_sponsor, insuran_due_date, reg_number, model, year_make
			FROM JunMy\Models\Users
			WHERE role = '0' AND verified ='0'
			".$this->search_user(filter_input(INPUT_GET, 'query', FILTER_SANITIZE_ENCODED))."
			ORDER BY id DESC";
		$count = $this->modelsManager->executeQuery($phql);	
        $paginations->records(count($count));
        $rows = $this->modelsManager->executeQuery($phql." LIMIT $paginate , $records_per_page");	
        // records per page
        $paginations->records_per_page($records_per_page);
		$this->paginationUrl = $paginations->render();

		return $rows;
	
	}
	
	private function search_user($param) {
		if($param) {
			return " AND username LIKE '%$param%' OR reg_number LIKE '%$param%' OR name LIKE '%$param%'";
		}
	}
	
	private function get_user($id) {
	    $phql = "SELECT u.username AS username, u.email AS email, u.insuran_due_date AS insuran_due_date, 
		u.profile_image AS profile_image, u.reg_number AS reg_number,
	      w.amount AS amount
		  FROM JunMy\Models\Users AS u
		  INNER JOIN JunMy\Models\Wallets AS w ON(u.id = w.user_id) 
		  WHERE u.id = '$id'";
		$rows = $this->modelsManager->executeQuery($phql);
		 
		return $rows;
	}
}
