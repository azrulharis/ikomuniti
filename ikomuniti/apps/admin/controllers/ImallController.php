<?php 

namespace JunMy\Admin\Controllers;

use JunMy\Models\Users;
use JunMy\Models\Posts; 
use JunMy\Models\Notifications; 
use JunMy\Components\Pagination\Pagination;  

class ImallController extends ControllerBase {
	
	public $paginationUrl;
	
	private $post_id;
	
	private $title;
	
	public $date;
	
	public $index_date;
	
	public function initialize() {
		$this->tag->setTitle('iMall');
		parent::initialize();
	} 
	
	public function indexAction() {
		parent::pageProtect();
		$auth = $this->session->get('junauth');
		$this->flashSession->output();
		$offset = mt_rand(0, 21000);  
		$key = 'admin_imall_ads_'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) {
		    $this->view->setVar('navigations', $this->get_user($auth['id'])); 
		}
		$this->view->cache(array("key" => $key));
		
		$this->view->setVar('posts', $this->view_ads(2));
		$this->view->paginationUrl = $this->paginationUrl;
		$this->view->imall_thumb_image_dir = $this->thumb_image_dir(); 
		 
	} 
	
	public function pendingAction() {
		parent::pageProtect();
		$auth = $this->session->get('junauth');
		$this->flashSession->output();
		$offset = mt_rand(0, 21000);  
		$key = 'admin_imall_pending_'.$auth['id'].'_'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) {
		    $this->view->setVar('navigations', $this->get_user($auth['id'])); 
		}
		$this->view->cache(array("key" => $key));
		
		$this->view->setVar('posts', $this->view_ads(1));
		$this->view->paginationUrl = $this->paginationUrl;
		$this->view->imall_thumb_image_dir = $this->thumb_image_dir(); 
		 
	} 
	
	public function viewAction() {
		parent::pageProtect();
		$auth = $this->session->get('junauth'); 
		$this->view->setVar('posts', $this->view_ad($this->dispatcher->getParam('slug')));
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
					if($this->request->getPost('action') == 2) {
					    if($this->update_status($post_id, $action, '0')) {
							if($this->notification($user_id, $action)) {
								$this->flashSession->success('iMall ad has been approve');
								return $this->response->redirect('gghadmin/imall/pending');	
							} 
						}
					} elseif($this->request->getPost('action') == 3) {
						if($this->request->getPost('reason_list') == '0') {
							$this->flash->error('Please select reason');
						} elseif($this->request->getPost('reason_list') == 1 && $this->request->getPost('reason') == '') {
							$this->flash->error('Please write your additional reason');
						} else {
						    $reason = $this->request->getPost('reason_list') == 1 ? $this->request->getPost('reason') : $this->request->getPost('reason_list');
							if($this->update_status($post_id, $action, $reason)) {
								if($this->notification($user_id, $action)) {
									$this->flashSession->success('iMall ad has been rejected');
									return $this->response->redirect('gghadmin/imall/pending');	
								} 
							}
						}
					}
				}
			}
		}
		// Check if image > 1 then show thumb by set thumbnail == 1;
		foreach($this->view_ad($this->dispatcher->getParam('slug')) as $row) {
	 
			if(count($this->thumbnails($row['id'])) > 1) {
				$this->view->thumbnail = 1;
			} else {
				$this->view->thumbnail = 0;
			}
			
			$this->view->thumb_image_dir = $this->thumb_image_dir();
			// View thumbnails
			$this->view->setVar('thumbs', $this->thumbnails($row['id']));	
		}  
		
		$offset = mt_rand(0, 921000);  
		$key = 'imall_view_'.$this->dispatcher->getParam('slug').'_'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) {
		    
			$this->view->setVar('navigations', $this->get_user($auth['id']));
			$this->view->host = $this->host();
		} 
		$this->view->cache(array("key" => $key)); 
		$this->view->urlajax = $this->url->get('ajax/ajaximall');
		$this->view->date = $this->date;
		$this->view->image_dir = $this->imall_image_dir();
	}
	
	/*
	*  Update ad status
	*/
	private function update_status($post_id, $status, $reason) {
		$post = Posts::findFirst($post_id);
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
		$note->body = 'Your post on iMall has been '.$status.'. Thanks for using our service.';
		$note->created = date('Y-m-d H:i:s');
		$note->read = 0;
		$note->type = 15;
		return $note->save();
	}
	/*
	*  View ad thumbnails, used on finishAction and viewAction
	*/
	private function thumbnails($id) {
		$phql = "SELECT
		    image_name 
			FROM JunMy\Models\Postimages
			WHERE post_id = :id:
			LIMIT 4";
		$rows = $this->modelsManager->executeQuery($phql, array('id' => $id));
		return $rows;
	}
	
	/*
	*  Count ads for preview and view
	*/
	private function view_ad($param) {
		$phql = "SELECT 
		  p.id AS id, p.title AS title, p.description AS description, p.price AS price,  
		  p.created AS created, p.url AS url, p.type AS type, p.status AS status, p.note AS note,
		  p.stock AS stock, p.location AS location, p.item_condition AS condition,
		  i.image_name AS image,
		  r.name AS region,
		  c.name AS category,
		  u.id AS user_id, u.username AS username, u.name AS name, u.telephone AS telephone, u.created AS created, 
		  u.address AS address, u.email AS email
		  FROM JunMy\Models\Posts AS p
		  INNER JOIN JunMy\Models\Users AS u ON(u.id = p.user_id)
		  LEFT JOIN JunMy\Models\Postimages AS i ON(p.id = i.post_id) 
		  LEFT JOIN JunMy\Models\Categories AS c ON(c.id = p.category_id) 
		  LEFT JOIN JunMy\Models\Regions AS r ON(r.id = p.region_id) 
		  WHERE p.url = '$param' LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql);  
		return $rows;
	}
 	
	/*
	*  Insert new post
	*  Used on steptwoAction
	*/
	private function save_image($id, $img_name) {
	    $save = new Postimages();
	    $save->post_id = $id;
	    $save->image_name = $img_name;
	    if($save->save()) {
			return true;
		} else {
			return false;
		}
	    
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
		//$this->view->since = date('j F, Y', strtotime($rows['users']['created']));
		foreach($rows as $key => $row) {
			$this->due = $key['created'];
		}
		return $rows;
	}
	
	/*
	*  Select ads listing on index
	*/
	private function view_ads($param) {
		$records_per_page = 30;
	    $paginations = new Pagination();
        $paginate = (($paginations->get_page() - 1) * $records_per_page);
		$phql = "SELECT
		    p.id AS id, p.title AS title, SUBSTRING(p.description, 1, 80) AS body, p.price AS price,  
		  p.created AS created, p.url AS slug, p.type AS type, p.status AS status, p.note AS note,
		  p.stock AS stock, p.location AS location, p.item_condition AS condition,
		  i.image_name AS image,
		  r.name AS region,
		  c.name AS category,
		  u.username AS username, u.name AS name, u.telephone AS telephone, u.created AS created, 
		  u.address AS address, u.email AS email
		  FROM JunMy\Models\Posts AS p
		  INNER JOIN JunMy\Models\Users AS u ON(u.id = p.user_id)
		  LEFT JOIN JunMy\Models\Postimages AS i ON(p.id = i.post_id) 
		  LEFT JOIN JunMy\Models\Categories AS c ON(c.id = p.category_id) 
		  LEFT JOIN JunMy\Models\Regions AS r ON(r.id = p.region_id)
			WHERE p.status = '$param'
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
	*  Select CATEGORY Condition as parameter 
	*/
	private function category($cond = NULL) {
		$phql = "SELECT 
			id, name, type, parent
			FROM JunMy\Models\Categories 
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
	*  VReplace title to url
	*  Return STRING
	*/	
	private function slug($string) {
		return strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', 
		html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', 
		htmlentities($string, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));
	}	
}