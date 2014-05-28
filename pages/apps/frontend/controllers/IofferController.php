<?php 

namespace JunMy\Frontend\Controllers;

use JunMy\Models\Users; 
use JunMy\Models\Companyproductorders;
use JunMy\Models\Transactions;
use JunMy\Components\Pagination\Pagination;  

class IofferController extends ControllerBase {
	
	public $paginationUrl; 
	
	public $salt_length = 9;
	
	public function initialize() {
		$this->tag->setTitle('iOffer');
		parent::initialize();
	} 
	
	public function indexAction() { 
	    $this->flashSession->output(); 
	    $offset = mt_rand(0, 1000);
		$key = 'ioffer_index_'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) {  
		    $this->view->setVar('posts', $this->view_listings()); 
		} 
		$this->view->cache(array("key" => $key));
		$this->view->paginationUrl = $this->paginationUrl;
		$this->view->ioffer_thumb_dir = $this->ioffer_thumb_dir();
		
		// Set path url for view
		$this->view->path = $this->path();
		
	}
	
	public function viewAction() {  
		$id = $this->dispatcher->getParam('slug');
		$offset = mt_rand(0, 21000);  
		$key = 'ioffer_view_'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) { 
		     
		}
		$this->view->cache(array("key" => $key));
		 
	    if(count($this->select_ad($id)) != 1) {
			$this->flashSession->error('Product not found');
			return $this->response->redirect('ioffer');
		} else { 
		 
			
			$this->view->urlajax = $this->url->get('ajax/ajaxioffer'); 
			// Preview ad
			$this->view->setVar('posts', $this->view_ad($id));
			 
			
			// Check if image > 1 then show thumb by set thumbnail == 1;
			foreach($this->view_ad($id) as $row) {
				if(count($this->thumbnails($row['id'])) > 1) {
					$this->view->thumbnail = 1;
				} else {
					$this->view->thumbnail = 0;
				}
				
				// Set view path for ioffer dir
				$this->view->image_dir = $this->ioffer_image_dir();
				
				$this->view->ioffer_thumb_dir = $this->ioffer_thumb_dir();
				// View thumbnails
				$this->view->setVar('thumbs', $this->thumbnails($row['id']));	
			}
			
		}
		 
	}
	
	
	
	/*
	*  View ad, used on finishAction and viewAction
	*/
	private function view_ad($slug) {
		$phql = "SELECT
		    p.id AS id, p.title AS title, p.price AS price, p.stock AS stock, p.market_price AS market_price,
		    DATE_FORMAT(p.created,'%d %b %h:%i %p') AS created, p.slug AS slug, p.status AS status, p.body AS body,
		    i.image_name AS image 
			FROM JunMy\Models\Companyproducts AS p
			LEFT JOIN JunMy\Models\Companyproductimages AS i ON(p.id = i.company_product_id)
			WHERE p.slug = :slug: AND p.status = '1' AND p.stock > 0
			LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql, array('slug' => $slug));
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
	*  View ads, used on ioffer/index
	*/
	private function view_listings() {
		$records_per_page = 20;
	    $paginations = new Pagination();
        $paginate = (($paginations->get_page() - 1) * $records_per_page);
		$phql = "SELECT
		    p.id AS id, p.title AS title, p.price AS price, p.stock AS stock, p.market_price AS market_price, p.counter AS counter, SUBSTRING(p.body, 1, 80) AS body,
		    DATE_FORMAT(p.created,'%d %b %h:%i %p') AS created, p.slug AS slug, p.status AS status,
		    i.image_name AS image 
			FROM JunMy\Models\Companyproducts AS p
			LEFT JOIN JunMy\Models\Companyproductimages AS i ON(p.id = i.company_product_id)
			WHERE p.status = '1' AND p.stock != '0' GROUP BY p.id ORDER BY p.id DESC";
		$count = $this->modelsManager->executeQuery($phql);	
        $paginations->records(count($count));
        $rows = $this->modelsManager->executeQuery($phql." LIMIT $paginate , $records_per_page");	
        // records per page
        $paginations->records_per_page($records_per_page); 
        $this->paginationUrl = $paginations->render(); 
        return $rows;
	}
		

	private function get_user($id) {
	    $phql = "SELECT id, username ,name, email, postcode, telephone FROM JunMy\Models\Users WHERE id = :id: LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql, array('id' => $id));
	 
		return $rows;
	}
	
	
	
	
	/*
	*  Check if product exist
	*/
	private function select_ad($id) {
		$phql = "SELECT
		    id, title, body, price, stock
			FROM JunMy\Models\Companyproducts
			WHERE slug = :id: LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql, array('id' => $id));
		return $rows;	
	}
	
	public function passwordHash($pwd, $salt = null) {
        if ($salt === null)     {
            $salt = substr(md5(uniqid(rand(), true)), 0, $this->salt_length);
        } else {
            $salt = substr($salt, 0, $this->salt_length);
        }
        return $salt . sha1($pwd . $salt);
    }

}