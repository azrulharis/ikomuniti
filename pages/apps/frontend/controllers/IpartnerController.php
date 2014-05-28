<?php 

namespace JunMy\Frontend\Controllers;

use JunMy\Models\Users;
use JunMy\Models\Ipartner; 
use JunMy\Models\Ipartnerimage;
use JunMy\Models\Ipartnercategories; 
use JunMy\Components\Pagination\Pagination;   

class IpartnerController extends ControllerBase {
	
	public $paginationUrl; 
	
	public function initialize() {
		$this->tag->setTitle('iPartner');
		parent::initialize();
	}
	
	public function indexAction() { 
		$this->view->ipartner_thumb_dir = $this->ipartner_thumb_image_dir();   
		
		$this->view->path = $this->path();
		
		
		
		$offset = mt_rand(0, 9521000);  
		$key = 'ipartner_index_'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) { 
			$this->view->setVar('posts', $this->view_ads());
		}
		
		$this->view->paginationUrl = $this->paginationUrl;
		 
		$this->view->cache(array("key" => $key)); 
	}
	
	public function viewAction() { 
	    $this->view->image_dir = $this->ipartner_image_dir();
	    
	    if(count($this->view_ad($this->dispatcher->getParam('slug'))) > 0) {
			$this->view->setVar('posts', $this->view_ad($this->dispatcher->getParam('slug')));
		} else {
			return $this->response->redirect('ipartner/add');
		}  
		
		$offset = mt_rand(0, 921000);  
		$key = 'ipartner_view_'.$this->dispatcher->getParam('slug').'_'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) { 
			
		} 
	    $this->view->host = $this->host();
		$this->view->cache(array("key" => $key)); 
	}
	
	 
	/*
	*  Select ads listing on index
	*/
	private function view_ads() {
		$records_per_page = 7;
	    $paginations = new Pagination();
        $paginate = (($paginations->get_page() - 1) * $records_per_page);
		$phql = "SELECT
		    p.id AS id, p.title AS title, p.discount AS discount, SUBSTRING(p.description, 1, 80) AS body,
		    DATE_FORMAT(p.created,'%d %b %h:%i %p') AS created, p.url AS slug, p.type AS type, p.status AS status, p.note AS note,
		    i.image_name AS image, c.name AS category
			FROM JunMy\Models\Ipartner AS p
			LEFT JOIN JunMy\Models\Ipartnerimage AS i ON(p.id = i.post_id)
			LEFT JOIN JunMy\Models\Ipartnercategories AS c ON(p.category_id = c.id)
			WHERE p.status = '1'
			GROUP BY i.id ORDER BY p.id DESC";
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
		  DATE_FORMAT(p.created,'%d %b %h:%i %p') AS created, p.url AS slug, p.type AS type, p.status AS status, p.note AS note,
		  i.image_name AS image,
		  r.name AS region,
		  c.name AS category,
		  u.username AS username, u.name AS name, u.telephone AS telephone, u.created AS created, 
		  u.address AS address, u.email AS email
		  FROM JunMy\Models\Ipartner AS p
		  INNER JOIN JunMy\Models\Users AS u ON(u.id = p.user_id)
		  LEFT JOIN JunMy\Models\Ipartnerimage AS i ON(p.id = i.post_id) 
		  LEFT JOIN JunMy\Models\Ipartnercategories AS c ON(c.id = p.category_id) 
		  LEFT JOIN JunMy\Models\Regions AS r ON(r.id = p.region_id) 
		  WHERE p.url = '$param' AND status = '1' LIMIT 1";
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
	
	private function my_ads($user_id) {
		$records_per_page = 20;
	    $paginations = new Pagination();
        $paginate = (($paginations->get_page() - 1) * $records_per_page);
		$phql = "SELECT
		    p.id AS id, p.title AS title, p.discount AS discount,  
		    p.created AS created, p.url AS url, p.type AS type, p.status AS status, p.note AS note,
		    i.image_name AS image 
			FROM JunMy\Models\Ipartner AS p
			LEFT JOIN JunMy\Models\Ipartnerimage AS i ON(p.id = i.post_id)
			WHERE p.user_id = '$user_id'
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
	
    	// This function will proportionally resize image 
	private function resizeImage($CurWidth,$CurHeight,$MaxSize,$DestFolder,$SrcImage,$Quality,$ImageType) {
		//Check Image size is not 0
		if($CurWidth <= 0 || $CurHeight <= 0) {
			return false;
		}
		
		//Construct a proportional size of new image
		$ImageScale      	= min($MaxSize/$CurWidth, $MaxSize/$CurHeight); 
		$NewWidth  			= ceil($ImageScale*$CurWidth);
		$NewHeight 			= ceil($ImageScale*$CurHeight);
		$NewCanves 			= imagecreatetruecolor($NewWidth, $NewHeight);
		
		// Resize Image
		if(imagecopyresampled($NewCanves, $SrcImage,0, 0, 0, 0, $NewWidth, $NewHeight, $CurWidth, $CurHeight)) {
			switch(strtolower($ImageType)) {
				case 'image/png':
					imagepng($NewCanves,$DestFolder);
					break;
				case 'image/gif':
					imagegif($NewCanves,$DestFolder);
					break;			
				case 'image/jpeg':
				case 'image/pjpeg':
					imagejpeg($NewCanves,$DestFolder,$Quality);
					break;
				default:
					return false;
			}
			//Destroy image, frees memory	
			if(is_resource($NewCanves)) {
			    imagedestroy($NewCanves);
			} 
			return true;
		}
	
	}
	
	//This function corps image to create exact square images, no matter what its original size!
	private function cropImage($CurWidth,$CurHeight,$iSize,$DestFolder,$SrcImage,$Quality,$ImageType) {	 
		//Check Image size is not 0
		if($CurWidth <= 0 || $CurHeight <= 0) {
			return false;
		}
		
		//abeautifulsite.net has excellent article about "Cropping an Image to Make Square bit.ly/1gTwXW9
		if($CurWidth>$CurHeight) {
			$y_offset = 0;
			$x_offset = ($CurWidth - $CurHeight) / 2;
			$square_size 	= $CurWidth - ($x_offset * 2);
		} else {
			$x_offset = 0;
			$y_offset = ($CurHeight - $CurWidth) / 2;
			$square_size = $CurHeight - ($y_offset * 2);
		}
		
		$NewCanves 	= imagecreatetruecolor($iSize, $iSize);	
		if(imagecopyresampled($NewCanves, $SrcImage,0, 0, $x_offset, $y_offset, $iSize, $iSize, $square_size, $square_size)) {
			switch(strtolower($ImageType)) {
				case 'image/png':
					imagepng($NewCanves,$DestFolder);
					break;
				case 'image/gif':
					imagegif($NewCanves,$DestFolder);
					break;			
				case 'image/jpeg':
				case 'image/pjpeg':
					imagejpeg($NewCanves,$DestFolder,$Quality);
					break;
				default:
					return false;
			}
			//Destroy image, frees memory	
			if(is_resource($NewCanves)) {  
			    imagedestroy($NewCanves);
			} 
			return true;
	
		}
		  
	}
	
}