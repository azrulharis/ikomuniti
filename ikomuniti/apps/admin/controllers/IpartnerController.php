<?php 

namespace JunMy\Admin\Controllers;

use JunMy\Models\Users;
use JunMy\Models\Ipartner;
use JunMy\Models\Notifications;    
use JunMy\Components\Pagination\Pagination;   

class IpartnerController extends ControllerBase {
	
	public $paginationUrl; 
	
	public function initialize() {
		$this->tag->setTitle('iPartner');
		parent::initialize();
	}
	
	public function indexAction() {
		parent::pageProtect();
		$auth = $this->session->get('junauth');
		$this->flashSession->output();
		$offset = mt_rand(0, 21000);  
		$key = 'admin_partner_index_'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) {
		    $this->view->imall_dir = $this->imall_dir(); 
			$this->view->setVar('navigations', $this->get_user($auth['id']));
			$this->view->setVar('posts', $this->view_ads(1));
		}
		$this->view->paginationUrl = $this->paginationUrl;
		$this->view->cache(array("key" => $key)); 
	}
	
	public function pendingAction() {
		parent::pageProtect();
		$auth = $this->session->get('junauth');
		$this->flashSession->output();
		$offset = mt_rand(0, 21000);  
		$key = 'admin_partner_pending_'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) {
		    $this->view->imall_dir = $this->imall_dir(); 
			$this->view->setVar('navigations', $this->get_user($auth['id']));
			
		}
		$this->view->setVar('posts', $this->view_ads(0));
		$this->view->paginationUrl = $this->paginationUrl;
		$this->view->cache(array("key" => $key)); 
	}
	
	public function viewAction() {
	    //print_r($_SESSION);
		parent::pageProtect();
		$auth = $this->session->get('jun_user_auth'); 
		$post_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
		// Admin action
		if($this->request->isPost()) {
			if($this->request->getPost('submit') == 'Submit') {
				if($this->request->getPost('action') == 0) {
				    $this->flash->error('Please select action');
				} else {
				    // If approve, then update and send notification
				    $action = $this->request->getPost('action');
				    $user_id = $this->request->getPost('user_id');
					if($this->request->getPost('action') == 1) {
					    if($this->update_status($post_id, $action, '0')) {
							if($this->notification($user_id, $action)) {
								$this->flashSession->success('iPartner ad has been approve');
								return $this->response->redirect('gghadmin/ipartner/pending');	
							} 
						}
					} elseif($this->request->getPost('action') == 2) {
						if($this->request->getPost('reason_list') == '0') {
							$this->flash->error('Please select reason');
						} elseif($this->request->getPost('reason_list') == 1 && $this->request->getPost('reason') == '') {
							$this->flash->error('Please write your additional reason');
						} else {
						    $reason = $this->request->getPost('reason_list') == 1 ? $this->request->getPost('reason') : $this->request->getPost('reason_list');
							if($this->update_status($post_id, $action, $reason)) {
								if($this->notification($user_id, $action)) {
									$this->flashSession->success('iPartner ad has been rejected');
									return $this->response->redirect('gghadmin/ipartner/pending');	
								} 
							}
						}
					}
				}
			}
		}
		
		
		
		$this->view->setVar('posts', $this->view_ad($this->dispatcher->getParam('slug'))); 
		
		$offset = mt_rand(0, 921000);  
		$key = 'ipartner_view_'.$this->dispatcher->getParam('slug').'_'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) {
		    $this->view->setVar('navigations', $this->get_user($auth['id'])); 
			$this->view->host = $this->host();
		} 
		$this->view->cache(array("key" => $key)); 
	} 
	
	/*
	*  Update ad status
	*/
	private function update_status($post_id, $status, $reason) {
		$post = Ipartner::findFirst($post_id);
		$post->status = $status;
		$post->note = $reason;
		return $post->save();
	}
	
	private function notification($user_id, $action) {
	    if($action == 2) {
			$status = 'approve';
		}
		if($action == 3) {
			$status = 'reject';
		}
		$note = new Notifications();
		$note->user_id = $user_id;
		$note->body = 'Your ad on iPartner has been '.$status;
		$note->created = date('Y-m-d H:i:s');
		$note->read = 0;
		$note->type = 15;
		return $note->save();
	}
	
	/*
	*  Select ads listing on index
	*/
	private function view_ads($status) {
		$records_per_page = 30;
	    $paginations = new Pagination();
        $paginate = (($paginations->get_page() - 1) * $records_per_page);
		$phql = "SELECT
		    p.id AS id, p.title AS title, p.discount AS discount, SUBSTRING(p.description, 1, 160) AS description,
		    DATE_FORMAT(p.created,'%d %b %h:%i %p') AS created, p.url AS url, p.type AS type, p.status AS status, p.note AS note,
		    
		    i.image_name AS image, 
			c.name AS category,
		    u.username AS username,
		    r.name AS region
			FROM JunMy\Models\Ipartner AS p
			LEFT JOIN JunMy\Models\Users AS u ON(u.id = p.user_id)
			LEFT JOIN JunMy\Models\Regions AS r ON(r.id = p.region_id)
			LEFT JOIN JunMy\Models\Ipartnerimage AS i ON(p.id = i.post_id)
			LEFT JOIN JunMy\Models\Ipartnercategories AS c ON(p.category_id = c.id)
			WHERE p.status = '$status'
			ORDER BY p.id DESC";
		$count = $this->modelsManager->executeQuery($phql);	
        $paginations->records(count($count));
        $rows = $this->modelsManager->executeQuery($phql." LIMIT $paginate , $records_per_page");	
        $paginations->records_per_page($records_per_page); 
        $this->paginationUrl = $paginations->render();
        return $rows;
     
	}
	
	/*
	*  Select CATEGORY Condition as parameter 
	*/
	private function category($cond = NULL) {
		$phql = "SELECT 
			id, name, type, parent
			FROM JunMy\Models\Ipartnercategories 
			$cond";
		return $this->modelsManager->executeQuery($phql);
	}
	
	/*
	*  Select REGION Condition as parameter 
	*/
	private function region($cond = NULL) {
		$phql = "SELECT
			id,
			name
			FROM JunMy\Models\Regions
			$cond";
		return $this->modelsManager->executeQuery($phql);
	}
	
	/*
	*  Count ads for preview and view
	*/
	private function view_ad($param) {
		$phql = "SELECT 
		  p.id AS id, p.title AS title, p.description AS description, p.discount AS discount, p.address_one AS address_one, p.address_two AS address_two,
		  p.postcode AS postcode, p.city AS city,
		  p.created AS created, p.url AS url, p.type AS type, p.status AS status, p.note AS note,
		  i.image_name AS image,
		  r.name AS region,
		  c.name AS category,
		  u.id AS user_id, u.username AS username, u.name AS name, u.telephone AS telephone, u.created AS created, 
		  u.address AS address, u.email AS email
		  FROM JunMy\Models\Ipartner AS p
		  INNER JOIN JunMy\Models\Users AS u ON(u.id = p.user_id)
		  LEFT JOIN JunMy\Models\Ipartnerimage AS i ON(p.id = i.post_id) 
		  LEFT JOIN JunMy\Models\Ipartnercategories AS c ON(c.id = p.category_id) 
		  LEFT JOIN JunMy\Models\Regions AS r ON(r.id = p.region_id) 
		  WHERE p.url = '$param' LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql);  
		return $rows;
	}
	
	private function all_ads($status) {
		$records_per_page = 20;
	    $paginations = new Pagination();
        $paginate = (($paginations->get_page() - 1) * $records_per_page);
		$phql = "SELECT
		    p.id AS id, p.title AS title, p.discount AS discount,  
		    p.created AS created, p.url AS url, p.type AS type, p.status AS status, p.note AS note,
		    i.image_name AS image 
			FROM JunMy\Models\Ipartner AS p
			LEFT JOIN JunMy\Models\Ipartnerimage AS i ON(p.id = i.post_id)
			WHERE p.status = '$status'
			GROUP BY p.id ORDER BY p.id DESC";
		$count = $this->modelsManager->executeQuery($phql);	
        $paginations->records(count($count));
        $rows = $this->modelsManager->executeQuery($phql." LIMIT $paginate , $records_per_page");	
        // records per page
        $paginations->records_per_page($records_per_page);
        $this->paginationUrl = $paginations->render();

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
	
	/*
	*  Insert new post
	*  Used on steptwoAction
	*/
	private function save_image($id, $img_name) {
	    $save = new Ipartnerimage();
	    $save->post_id = $id;
	    $save->image_name = $img_name;
	    $save->default_image = 0;
	    if($save->save()) {
			return true;
		} else {
			return false;
		}
	    
	}
	
	private function resize_image($path, $name, $width, $height, $default) {
	    $thumb=new Thumbnail("./" . $path . $name);		
        $thumb->size_width($width);				
        $thumb->size_height($height);				
        $thumb->size_auto($default);				
        $thumb->jpeg_quality(100);				
        //$thumb->show();						
        $thumb->save("./". $path . $name);
		unset($thumb);
		return true;
	}
	
	private function thumb($open_path, $name, $save_path) {
	    $thumb=new Thumbnail("./" . $open_path . $name);		
        $thumb->size_width(100);				
        $thumb->size_height(100);				
        $thumb->size_auto(100);				
        $thumb->jpeg_quality(100);				
        //$thumb->show();						
        $thumb->save("./". $save_path . $name);
		unset($thumb);
		return true;
	}	
	
}