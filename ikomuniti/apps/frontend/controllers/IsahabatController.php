<?php 

namespace JunMy\Frontend\Controllers;

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
	    $auth = $this->session->get('jun_user_auth');
	    $this->view->role = $auth['role'];
	    $offset = mt_rand(0, 1000);
		$key = 'isahabat_index_'.$auth['id'].'_'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) {  
		    $this->view->setVar('navigations', $this->get_user($auth['id']));  
		} 
		$this->view->cache(array("key" => $key));
	}
	
	public function upgradeAction() {
		parent::pageProtect();
	    
	    // Get session in array
	    $auth = $this->session->get('jun_user_auth');
	    $this->view->role = $auth['role'];
	    $offset = mt_rand(0, 1000);
		$key = 'isahabat_upgrade_'.$auth['id'].'_'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) {  
		    $this->view->setVar('navigations', $this->get_user($auth['id']));  
		} 
		$this->view->cache(array("key" => $key));
		$this->view->setVar('iresellers', $this->get_ireseller());
		$this->view->paginationUrl = $this->paginationUrl;
	}
	
	private function get_user($id) {
	    $phql = "SELECT id, username_sponsor, username, name, insuran_due_date, verified, role FROM JunMy\Models\Users WHERE id = '$id' LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql);
		return $rows; 
	}
	
	private function get_ireseller() {
		$records_per_page = 25;
	    $paginations = new Pagination();
        $paginate = (($paginations->get_page() - 1) * $records_per_page);
		$phql = "SELECT 
		        username, name, telephone, address, postcode
			FROM JunMy\Models\Users
			WHERE role = '2' 
			ORDER BY id ASC";
		$count = $this->modelsManager->executeQuery($phql);	
        $paginations->records(count($count));
        $rows = $this->modelsManager->executeQuery($phql." LIMIT $paginate , $records_per_page");	
        // records per page
        $paginations->records_per_page($records_per_page);
		$this->paginationUrl = $paginations->render();

		return $rows;
	
	}
}