<?php 

namespace JunMy\Admin\Controllers;

use JunMy\Models\Users; 
use JunMy\Models\Companyproducts;
use JunMy\Models\Companyproductimages;
use JunMy\Components\Pagination\Pagination; 
use JunMy\Components\Thumbnail\Thumbnail;

class IofferController extends ControllerBase {
	
	public $paginationUrl; 
	
	public function initialize() {
		$this->tag->setTitle('iOffer');
		parent::initialize();
	} 
	
	public function indexAction() {
		parent::pageProtect();
		$auth = $this->session->get('junauth');
		$offset = mt_rand(0, 21000);  
		$key = 'admin_ioffer_index_'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) {
		    $this->view->setVar('navigations', $this->get_user($auth['id'])); 
		}
		$this->view->cache(array("key" => $key));
		$this->view->paginationUrl = $this->paginationUrl;
		$this->view->ioffer_thumb_dir = $this->ioffer_thumb_dir();
		$this->view->setVar('posts', $this->view_listings());
	}
	
	public function addAction() {
		parent::pageProtect();
		$auth = $this->session->get('junauth');
		$this->flashSession->output();
		$offset = mt_rand(0, 2165000);  
		$key = 'admin_ioffer_add_'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) {
		    $this->view->setVar('navigations', $this->get_user($auth['id']));
		     
		}
		$this->view->cache(array("key" => $key));
		
		if($this->request->isPost()) {
			if($this->request->getPost('title') == '') {
				$this->flash->error('Please enter product title.');
			} elseif(strlen($this->request->getPost('title')) < 5 || strlen($this->request->getPost('title')) > 64) {
				$this->flash->error('Title must between 5 to 64 character long.');
			} elseif($this->request->getPost('price') == '') {
				$this->flash->error('Please enter product price.');
			} elseif(!is_numeric($this->request->getPost('price'))) {
				$this->flash->error('Please enter valid price format.');
			} elseif(!is_numeric($this->request->getPost('stock'))) {
				$this->flash->error('Please enter valid numeric stock.');
			} elseif($this->request->getPost('body') == '') {
				$this->flash->error('Product description cannot be empty.');
			} elseif(!is_numeric($this->request->getPost('market_price'))) {
				$this->flash->error('Please enter valid market price.');
			} elseif($this->request->getPost('commission') == '') {
				$this->flash->error('Please enter commission separate by comma.');
			} elseif($this->check_commission($this->request->getPost('commission')) !== true) {
				$this->flash->error('Please enter valid commission number separate by comma.');
			} else {
			    
				// Insert ads
				$title = $this->request->getPost('title');
				$price = $this->request->getPost('price');
				$stock = $this->request->getPost('stock');
				$body = $this->request->getPost('body');
				$market_price = $this->request->getPost('market_price');
				$commission = $this->request->getPost('commission');
				
				
				$this->insert_ad($title, $price, $stock, $body, $market_price, $commission);
			}
		}
	}
	
	public function steptwoAction() {
		parent::pageProtect();
		$auth = $this->session->get('junauth');
	 
		$this->view->setVar('navigations', $this->get_user($auth['id']));
		 
		
		if(isset($_GET['id'])) {
		    // Check if not valid id
			if(!is_numeric($_GET['id'])) {
				$this->flashSession->error('Not valid id');
				return $this->response->redirect('gghadmin/ioffer/add');
			} elseif(count($this->select_ad($_GET['id'])) != 1) {
				$this->flashSession->error('Product not found');
				return $this->response->redirect('gghadmin/ioffer/add');
			} else {
				// Preview ad
				$this->view->setVar('posts', $this->select_ad((int)$_GET['id']));
				if($this->request->isPost()) {
					if($this->request->hasFiles() == true) {  
						$post_id = (int)$_GET['id'];
					    $count = count($_FILES['image']['name']);
					    
						for($i=0; $i<=$count; $i++) {
							if($_FILES['image']['name'][$i] != '') {
							    if($_FILES['image']['size'][$i] < (4096 * 4096)) {
									$extension  = pathinfo($_FILES['image']['name'][$i], PATHINFO_EXTENSION); 
								    $allow_ext = array('jpg', 'jpeg', 'png');
								    if(in_array($extension, $allow_ext)) {
										// IE: 98YUIY78TY87UY8T8U.jpg
										$rename = date('YmdHis').$post_id.$i.'.'.$extension;
										$path = 'uploads/ioffers/images/';
						    			$thumb ='uploads/ioffers/thumbnails/';
										if(move_uploaded_file($_FILES['image']['tmp_name'][$i], $path.$rename)) {
											if($this->save_image($post_id, $rename)) {
												if($this->resize_image($path, $rename, 675, 675, 675)) {
													if($this->thumb($path, $rename, $thumb)) {
														$this->response->redirect('gghadmin/ioffer/finish?id='.(int)$_GET['id']);
													} else {
														$this->flash->error('Error on Thumbs EOT908');
													}
												} else {
													$this->flash->error('Error on Upload EOT905');
												} 	
											} else {
												$this->flash->error('Error on save files ESF635');
											}  	
										} else {
											$this->flash->error('Error on upload files EUF324');
										}	
									} else {
										$this->flash->error('Invalid file extension');	
									}	
								} else {
									$this->flash->error('Maximum image size is 4mb');
								}  
							}  
						}  
					} else {
						// Redirect to finish page even no image was upload
					    //$this->response->redirect('gghadmin/ioffer/finish?id='.(int)$_GET['id']);	
					} 
				}		
			}
		}
		
		
	}
	
	public function finishAction() {
		parent::pageProtect();
		$auth = $this->session->get('junauth');
		$this->view->urlajax = $this->url->get('gghadmin/ajax/ajaxioffer');
		$offset = mt_rand(0, 21000);  
		$key = 'admin_ioffer_add_finish_'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) {
		    $this->view->setVar('navigations', $this->get_user($auth['id']));
		     
		}
		$this->view->cache(array("key" => $key));
		
		// Validate id
		if($this->request->isGet()) {
		    // Check if not valid id
			if(!is_numeric($_GET['id'])) {
				$this->flashSession->error('Not valid id');
				return $this->response->redirect('gghadmin/ioffer/add');
			} elseif(count($this->select_ad($_GET['id'])) != 1) {
				$this->flashSession->error('Product not found');
				return $this->response->redirect('gghadmin/ioffer/add');
			} else { 
				// Update status to 1
				$this->update_status((int)$_GET['id']);
				
				// Preview ad
				$this->view->setVar('posts', $this->view_ad((int)$_GET['id']));
				
				// Check if image > 1 then show thumb by set thumbnail == 1;
				if(count($this->thumbnails((int)$_GET['id'])) > 1) {
					$this->view->thumbnail = 1;
				} else {
					$this->view->thumbnail = 0;
				}
				
				$this->view->ioffer_thumb_dir = $this->ioffer_thumb_dir();
				// View thumbnails
				$this->view->setVar('thumbs', $this->thumbnails((int)$_GET['id']));
			}
		}
	}
	
	public function viewAction() {
		parent::pageProtect();
		$auth = $this->session->get('junauth');
		$this->view->urlajax = $this->url->get('gghadmin/ajax/ajaxioffer');
		$id = $this->dispatcher->getParam('slug');
		$offset = mt_rand(0, 21000);  
		$key = 'admin_ioffer_add_finish_'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) {
		    $this->view->setVar('navigations', $this->get_user($auth['id']));
		     
		}
		$this->view->cache(array("key" => $key));
		 
	    if(count($this->select_ad($id)) != 1) {
			$this->flashSession->error('Product not found');
			return $this->response->redirect('gghadmin/ioffer/add');
		} else { 
		 
			// Preview ad
			$this->view->setVar('posts', $this->view_ad($id));
			
			// Check if image > 1 then show thumb by set thumbnail == 1;
			if(count($this->thumbnails($id)) > 1) {
				$this->view->thumbnail = 1;
			} else {
				$this->view->thumbnail = 0;
			}
			
			$this->view->ioffer_thumb_dir = $this->ioffer_thumb_dir();
			// View thumbnails
			$this->view->setVar('thumbs', $this->thumbnails($id));
		}
		
	}
	
	public function editAction() {
		parent::pageProtect();
		$auth = $this->session->get('junauth'); 
		$id = $this->dispatcher->getParam('slug');
		$offset = mt_rand(0, 21000);  
		$key = 'admin_ioffer_edit_finish_'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) {
		    $this->view->setVar('navigations', $this->get_user($auth['id'])); 
		}
		$this->view->cache(array("key" => $key));
		// Preview ad
		$this->view->setVar('posts', $this->view_ad($id));
		if($this->request->isPost()) {
			if($this->request->getPost('title') == '') {
				$this->flash->error('Please enter product title.');
			} elseif(strlen($this->request->getPost('title')) < 5 || strlen($this->request->getPost('title')) > 64) {
				$this->flash->error('Title must between 5 to 64 character long.');
			} elseif($this->request->getPost('price') == '') {
				$this->flash->error('Please enter product price.');
			} elseif(!is_numeric($this->request->getPost('price'))) {
				$this->flash->error('Please enter valid price format.');
			} elseif(!is_numeric($this->request->getPost('stock'))) {
				$this->flash->error('Please enter valid numeric stock.');
			} elseif($this->request->getPost('body') == '') {
				$this->flash->error('Product description cannot be empty.');
			} elseif(!is_numeric($this->request->getPost('market_price'))) {
				$this->flash->error('Please enter valid market price format.');
			} else {
				// Insert ads
				$title = $this->request->getPost('title');
				$price = $this->request->getPost('price');
				$stock = $this->request->getPost('stock');
				$body = $this->request->getPost('body');
				$market_price = $this->request->getPost('market_price');
				if($this->update_ad($id, $title, $price, $stock, $body, $market_price)) {
					$this->flashSession->success('iOffer product has been save.');
					return $this->response->redirect('gghadmin/ioffer/finish?id='.$id);
				}
			}
		}
	}
	
	/*
	*  View ad, used on finishAction and viewAction
	*/
	private function view_ad($id) {
		$phql = "SELECT
		    p.id AS id, p.title AS title, p.price AS price, p.stock AS stock,  
		    DATE_FORMAT(p.created,'%d %b %h:%i %p') AS created, p.slug AS url, p.status AS status, p.body AS body,
		    i.image_name AS image 
			FROM JunMy\Models\Companyproducts AS p
			LEFT JOIN JunMy\Models\Companyproductimages AS i ON(p.id = i.company_product_id)
			WHERE p.id = :id:
			LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql, array('id' => $id));
		return $rows;
	}
	
	/*
	*  View ad thumbnails, used on finishAction and viewAction
	*/
	private function thumbnails($id) {
		$phql = "SELECT
		    image_name 
			FROM JunMy\Models\Companyproductimages
			WHERE company_product_id = :id:
			LIMIT 4";
		$rows = $this->modelsManager->executeQuery($phql, array('id' => $id));
		return $rows;
	}
	
	
	/*
	*  Update product status after steptwo, used on finishAction
	*/
	private function update_status($id) {
		$update = Companyproducts::findFirst($id);
		if($update->status == 0) {
			$update->status = 1;
			if($update->save()) {
				$this->flash->success('Your iOffer ad has been save');
			}
		}
	}
	
	/*
	*  Edit product
	*/
	public function update_ad($id, $title, $price, $stock, $body, $market_price, $commission) {
		$ads = Companyproducts::findFirst($id);
		$ads->title = $title;
		$ads->body = $body;
		$ads->price = $price;
		$ads->market_price = $market_price;
		$ads->stock = $stock;  
		$ads->commission = $commission;
		return $ads->save();
	}
	/*
	*  Insert ads, used on ioffer/add
	*/
	private function insert_ad($title, $price, $stock, $body, $market_price, $commission) {
		$ads = new Companyproducts();
		$ads->title = $title;
		$ads->body = $body;
		$ads->price = $price;
		$ads->market_price = $market_price;
		$ads->created = date('Y-m-d H:i:s');
		$ads->stock = $stock;
		$ads->slug = $this->slug($title).'-'.date('YmdHis');
		$ads->status = 0;
		$ads->counter = 0;
		$ads->commission = $commission;
		if($ads->save()) {
			$this->response->redirect('gghadmin/ioffer/steptwo?id='.$ads->id);
		}
	}
	
	/*
	*  View ads, used on ioffer/index
	*/
	private function view_listings() {
		$records_per_page = 20;
	    $paginations = new Pagination();
        $paginate = (($paginations->get_page() - 1) * $records_per_page);
		$phql = "SELECT
		    p.id AS id, p.title AS title, p.price AS price, p.stock AS stock, p.counter AS counter,
		    DATE_FORMAT(p.created,'%d %b %h:%i %p') AS created, p.slug AS slug, p.status AS status,
		    i.image_name AS image 
			FROM JunMy\Models\Companyproducts AS p
			LEFT JOIN JunMy\Models\Companyproductimages AS i ON(p.id = i.company_product_id)
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
	*  Check if product exist
	*/
	private function select_ad($id) {
		$phql = "SELECT
		    id, title, body, price, stock
			FROM JunMy\Models\Companyproducts
			WHERE id = :id: LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql, array('id' => $id));
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
		//$this->view->since = date('j F, Y', strtotime($rows['users']['created']));
		foreach($rows as $key => $row) {
			$this->due = $key['created'];
		}
		return $rows;
	}
	
	/*
	*  Insert new post
	*  Used on steptwoAction
	*/
	private function save_image($id, $img_name) {
	    $save = new Companyproductimages();
	    $save->company_product_id = $id;
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
	*  Validate 4 level commission
	*  Return BOOLEAN
	*  Used on addAction
	*/
	private function check_commission($commission) {
		$values = explode(',',$commission);
		$valid = true;
		
		foreach($values as $value) {
		    if(!is_numeric($value)) {
		        $valid = false;
		        break;
		    }
		}
		return $valid;
	}
		
}