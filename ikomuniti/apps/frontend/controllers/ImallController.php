<?php 

namespace JunMy\Frontend\Controllers;

use JunMy\Models\Users;
use JunMy\Models\Posts;
use JunMy\Models\Wallets;
use JunMy\Models\Categories;
use JunMy\Models\Postimages;
use JunMy\Components\Pagination\Pagination;  

class ImallController extends ControllerBase {
	
	public $paginationUrl;
	
	private $post_id;
	
	private $title;
	
	public $salt_length = 9; 
	
	public $date;
	
	public $index_date;
	
	public function initialize() {
		$this->tag->setTitle('iMall');
		parent::initialize();
	}
	
	public function myadsAction() {
		parent::pageProtect();
		$auth = $this->session->get('jun_user_auth');
		
		$offset = mt_rand(0, 21000);  
		$key = 'imall_index_'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) { 
			$this->view->setVar('navigations', $this->get_user($auth['id']));
		} 
		$this->view->setVar('posts', $this->index_ads());
		$this->view->paginationUrl = $this->paginationUrl;
		$this->view->imall_thumb_image_dir = $this->imall_thumb_image_dir();
		$this->view->cache(array("key" => $key)); 
	}
	
	/*
	*  Select ads listing on index
	*/
	private function index_ads() {
		$records_per_page = 20;
	    $paginations = new Pagination();
        $paginate = (($paginations->get_page() - 1) * $records_per_page);
		$phql = "SELECT
		    p.id AS id, p.title AS title, p.price AS price, SUBSTRING(p.description, 1, 120) AS body,
		    p.created AS created, p.url AS slug,
		    c.name AS category,
		    i.image_name AS image 
			FROM JunMy\Models\Posts AS p
			LEFT JOIN JunMy\Models\Postimages AS i ON(p.id = i.post_id) 
			LEFT JOIN JunMy\Models\Categories AS c ON(p.category_id = c.id) 
			WHERE ".
			$this->getCategory(filter_input(INPUT_GET, 'category', FILTER_VALIDATE_INT)). 
			$this->get_query(filter_input(INPUT_GET, 'title', FILTER_SANITIZE_STRING)). 
			$this->getRegion(filter_input(INPUT_GET, 'region', FILTER_VALIDATE_INT)). 
			"GROUP BY p.id ORDER BY p.id DESC";
		$count = $this->modelsManager->executeQuery($phql);	
        $paginations->records(count($count));
        $rows = $this->modelsManager->executeQuery($phql." LIMIT $paginate , $records_per_page");	
        // records per page
        
        $paginations->records_per_page($records_per_page); 
        $this->paginationUrl = $paginations->render();
         
        return $rows;
	} 
	
	public function getRegion($id) {
	    if($id) {
			if($id == 102) {
				return " AND p.region_id > 0";
			} elseif($id == 112) {
			    $phql = "SELECT 
				neighbourhood
				FROM JunMy\Models\Regions 
				WHERE id = ".
				    ($this->session->has("region_id") ? $this->session->get("region_id") : '5')
					." LIMIT 1";
				$regions = $this->modelsManager->executeQuery($phql);
			    
			    foreach($regions as $in) {
					return " AND p.region_id IN (".$in['neighbourhood'].")";
				}
				
			} else {
				return " AND p.region_id = '$id'";
			}	
		}		
		
	} 
	
	private function get_query($query) {
		if(!empty($query)) {
			return " AND p.title LIKE '%$query%' OR p.description LIKE '%$query%' ";
		}
	}
	
	public function getCategory($id) {
		if($id == 986750) {
			return "p.category_id > '0'";
		} elseif($id == '') {
			return "p.category_id > '0'";
		} else {
			return "p.category_id = '$id'";
		}
	}
		
	 
	
	public function indexAction() {
		parent::pageProtect();
		
		$auth = $this->session->get('jun_user_auth');
		
		$this->role($auth['role'], array(4, 5, 6, 7, 8, 9)); 
		
		$offset = mt_rand(0, 9521000);  
		$key = 'imall_myads_'.$auth['id'].'_'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) {
		    $this->view->setVar('navigations', $this->get_user($auth['id'])); 
		    $this->view->imall_thumb_image_dir = $this->imall_thumb_image_dir();
			
		}
		$this->view->paginationUrl = $this->paginationUrl;
		$this->view->setVar('posts', $this->view_ads($auth['id']));
		$this->view->cache(array("key" => $key)); 
	}
	
	public function addAction() {
	    parent::pageProtect();
	    $this->flashSession->output();
	    $auth = $this->session->get('jun_user_auth');
	    
	    $this->role($auth['role'], array(4, 5, 6, 7, 8, 9)); 
	    
	    $this->view->urlajax = $this->url->get('ajax/ajaxcategory');
	    
        if($this->request->isPost()) { 
		    if($this->request->getPost('region_id') == 0) {
				$this->flash->error('Please select region');
				
			} elseif($this->request->getPost('category_id') == 0) {
				$this->flash->error('Please select category');
				
			} else { 
			    //print_r($_POST);
				$this->session->set('jun_post_data', $_POST);
				return $this->response->redirect('imall/steptwo');
				
			}
			
			
		} 
		$offset = mt_rand(0, 958695);
		$key = 'imall_add_'.$auth['id'].'_'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) {
		    $this->view->setVar('users', $this->get_user($auth['id'])); 
			$this->view->setVar('regions', $this->region("LIMIT 50")); 
			$this->view->setVar('categories',$this->category("LIMIT 50"));
			$this->view->setVar('navigations', $this->get_user($auth['id']));
		}
		$this->view->cache(array("key" => $key));
	}
	
	public function steptwoAction() {
		parent::pageProtect();
		$auth = $this->session->get('jun_user_auth');
		
		$this->role($auth['role'], array(4, 5, 6, 7, 8, 9)); 
		
		$this->view->setVar('navigations', $this->get_user($auth['id']));
	    if($this->session->has('jun_post_data')) {
	        $ses = $this->session->get('jun_post_data');
	        $region = $ses['region_id']; 
	        $category = $ses['category_id'];
	        $type = $ses['type'];
	        
	        // View previous data
			$this->view->setVar('regions', $this->region("WHERE id = '$region' LIMIT 1"));
			$this->view->setVar('categories', $this->category("WHERE id = '$category' LIMIT 1"));
			$this->view->type = $type;
			
			// Submit data on 2nd step
			if($this->request->isPost()) {
			  
			  
				if(strlen($this->request->getPost('title')) > 64 || strlen($this->request->getPost('title')) < 5) {
					$this->flash->error('Title must between 5 - 64 character'); 
				} elseif(strlen($this->request->getPost('body')) < 3) {
					$this->flash->error('Minimum description 3 character'); 
				} elseif(strlen($this->request->getPost('location')) < 3) {
					$this->flash->error('Please enter item location'); 
				} elseif($this->request->getPost('item_condition') == '0') {
					$this->flash->error('Please select Item Condition'); 
				} else {
				    $url = $this->slug($this->request->getPost('title')).'-'.date('YmdHis');
				    //insert post to database
				    $posts = new Posts();  
					$posts->title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);  
					$posts->description = filter_input(INPUT_POST, 'body', FILTER_SANITIZE_SPECIAL_CHARS);  
					$posts->location = filter_input(INPUT_POST, 'location', FILTER_SANITIZE_SPECIAL_CHARS); 
					$posts->item_condition = $cond = ($this->request->getPost('item_condition') == '' ? 0 : $this->request->getPost('item_condition'));
					$posts->price = $price = ($this->request->getPost('price') == '' ? 0 : $this->request->getPost('price'));  
					$posts->stock = 1; 
					$posts->category_id = $category;  
					$posts->region_id = $region;  
					$posts->user_id = $auth['id']; 
					$posts->created = date('Y-m-d H:i:s'); 
					$posts->url = $url;  
					$posts->type = $type;
					$posts->status = 0; 
					$posts->note = 0;
					$posts->hit = 0;
					if (!$posts->save()) {
			            foreach ($posts->getMessages() as $message) {
			                $this->flash->error((string) $message);
			            } 
			        } else {  
			            // Redirect to step three
			            return $this->response->redirect('imall/stepthree/'.$url);
					}
					
				}
			} 
		} else {
		    $this->flashSession->error('Sorry. Page not found'); 
			return $this->response->redirect('imall/add');
		}  
		
		$offset = mt_rand(0, 921000);  
		$key = 'imall_steptwo_'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) {
		    
			$this->view->setVar('users', $this->get_user($auth['id']));
			 
		} 
		$this->view->cache(array("key" => $key)); 
	}
	
	public function stepthreeAction() {
		parent::pageProtect();
		$auth = $this->session->get('jun_user_auth');
		
		$this->role($auth['role'], array(4, 5, 6, 7, 8, 9)); 
		
		if(count($this->view_ad($this->dispatcher->getParam('slug'), $auth['id'])) == 1) {
			$this->view->setVar('posts', $this->view_ad($this->dispatcher->getParam('slug'), $auth['id']));
			$_SESSION['upload_token_name'] = $this->passwordHash(date('YmdHis'));
			$_SESSION['upload_token'] = $this->passwordHash(date('YmdHis'));
			$this->view->upload_token_name = $_SESSION['upload_token_name'];
			$this->view->upload_token = $_SESSION['upload_token'];  
		} else {
			$this->flashSession->error('Sorry. Page not found'); 
			return $this->response->redirect('imall/add');
		}  
		
		$offset = mt_rand(0, 921000);  
		$key = 'imall_stepthree_'.$auth['id'].'_'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) {
		    $this->view->setVar('navigations', $this->get_user($auth['id']));  
		} 
		$this->view->cache(array("key" => $key));
		 
		$this->view->urlajax = $this->url->get('ajax/ajaxupload'); 
	}
	
	public function finishAction() {
		parent::pageProtect();
		$auth = $this->session->get('jun_user_auth');
		
		$this->role($auth['role'], array(4, 5, 6, 7, 8, 9)); 
		
	    if(count($this->view_ad($this->dispatcher->getParam('slug'), $auth['id'])) == 1) {
			$this->view->setVar('posts', $this->view_ad($this->dispatcher->getParam('slug'), $auth['id']));
			
			// Check if image > 1 then show thumb by set thumbnail == 1;
			foreach($this->view_ad($this->dispatcher->getParam('slug'), $auth['id']) as $row) {
			    $this->update_status($row['id']);
				if(count($this->thumbnails($row['id'])) > 1) {
					$this->view->thumbnail = 1;
				} else {
					$this->view->thumbnail = 0;
				}
				
				$this->view->thumb_image_dir = $this->thumb_image_dir();
				// View thumbnails
				$this->view->setVar('thumbs', $this->thumbnails($row['id']));	
			}
		} else {
			$this->flashSession->error('Sorry. Page not found'); 
			return $this->response->redirect('imall/add');
		}  
		
		$offset = mt_rand(0, 921000);  
		$key = 'imall_steptwo_'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) {
		    $this->view->setVar('navigations', $this->get_user($auth['id']));
			$this->view->setVar('users', $this->get_user($auth['id']));
			$this->view->date = $this->date; 
		} 
		$this->view->cache(array("key" => $key));
		 
		$this->view->urlajax = $this->url->get('ajax/ajaximall');
		unset($_SESSION['jun_post_data']);
	}
	
	private function update_status($id) {
		$posts = Posts::findFirst($id);
		if($posts->status == 0) {
		    $posts->status = 1;
			if($posts->save()) {
				$this->flash->success('Your ad has been saved. Please wait our staff check before publish it.');
			}
		}
		 
	}
	
	public function viewAction() {
		parent::pageProtect();
		$auth = $this->session->get('jun_user_auth');
	    if(count($this->view_ad($this->dispatcher->getParam('slug'), $auth['id'])) == 1) {
			$this->view->setVar('posts', $this->view_ad($this->dispatcher->getParam('slug'), $auth['id']));
			
			// Check if image > 1 then show thumb by set thumbnail == 1;
			foreach($this->view_ad($this->dispatcher->getParam('slug'), $auth['id']) as $row) {
			    $this->update_status($row['id']);
				if(count($this->thumbnails($row['id'])) > 1) {
					$this->view->thumbnail = 1;
				} else {
					$this->view->thumbnail = 0;
				}
				
				$this->view->thumb_image_dir = $this->thumb_image_dir();
				// View thumbnails
				$this->view->setVar('thumbs', $this->thumbnails($row['id']));	
			}
		} else {
			$this->flashSession->error('Sorry. Page not found'); 
			return $this->response->redirect('imall/add');
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
	}
	
	/*
	*  Count ads for preview and view
	*/
	private function view_ad($param, $id) {
		$phql = "SELECT 
		  p.id AS id, p.title AS title, p.description AS description, p.price AS price,  
		  DATE_FORMAT(p.created,'%d %b %h:%i %p') AS created, p.url AS url, p.type AS type, p.status AS status, p.note AS note,
		  p.stock AS stock, p.location AS location, p.item_condition AS condition, p.hit AS hit,
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
		  WHERE p.url = '$param' AND p.user_id = '$id' LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql); 
		 
		return $rows;
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
	*  Insert new post
	*  Used on steptwoAction
	*/
	private function save_image($id, $img_name) {
	    $save = new Postimages();
	    $save->post_id = $id;
	    $save->image_name = $img_name;
	    $save->default_image = 0;
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
		 
		return $rows;
	}
	
	/*
	*  Select ads listing on index
	*/
	private function view_ads($user_id) {
		$records_per_page = 30;
	    $paginations = new Pagination();
        $paginate = (($paginations->get_page() - 1) * $records_per_page);
		$phql = "SELECT
		    p.id AS id, p.title AS title, SUBSTRING(p.description, 1, 80) AS body, p.price AS price,  
		  DATE_FORMAT(p.created,'%d %b %h:%i %p') AS created, p.url AS slug, p.type AS type, p.status AS status, p.hit AS hit, 
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
			WHERE p.status != '0' AND user_id = '$user_id'
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
	
	public function passwordHash($pwd, $salt = null) {
        if ($salt === null)     {
            $salt = substr(md5(uniqid(rand(), true)), 0, $this->salt_length);
        } else {
            $salt = substr($salt, 0, $this->salt_length);
        }
        return $salt . sha1($pwd . $salt);
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