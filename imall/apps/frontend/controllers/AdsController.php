<?php

namespace JunMy\Frontend\Controllers;
use JunMy\Models\Users;
use JunMy\Models\Posts;
use JunMy\Models\Wallets;
use JunMy\Models\Categories;
use JunMy\Models\Postimages; 
	
class AdsController extends ControllerBase {
 
     
	
	public $salt_length = 9;
	
	public function initialize() {
		$this->tag->setTitle('iMall');
		parent::initialize();
	}
	

    public function indexAction() { 
     
		$auth = $this->session->get('jun_user_auth');
		
		$this->view->ajaxMessage = $this->url->get('ajax/ajaxmessage'); 
	     
		// Session token to prevent CSRF, used on message
		$_SESSION['PKLCMSG'] = $this->passwordHash(date('YmdHis')); 
		$this->view->token_value = $_SESSION['PKLCMSG'];
		
		// Set id for slug url
		$id = $this->dispatcher->getParam('slug');
		 
		// if post not found 
	    if(count($this->view_ad($id)) != 1) {
			$this->flashSession->error('Product not found');
			return $this->response->redirect('index');
		} else { 
		    // Set back url
		    $this->view->back_url = $_SESSION['back_url'];
		    
			// Ikomuniti dashboard
		    $this->view->ikomuniti_dir = $this->ikomuniti_dir();
		    
		    // Set view for register url
		    $this->view->register = 'http://ishare.com.my/daftar.html';
		    
		    // Set view for ajax path
			$this->view->urlajax = $this->url->get('ajax/ajaximall'); 
			
			// View main ad
			$this->view->setVar('posts', $this->view_ad($id));
			
			// Set view for path for image
			$this->view->thumb_dir = $this->thumb_image_dir();
			$this->view->image_dir = $this->imall_image_dir();
			
			// User profile image path
			$this->view->profile_image_path = $this->profile_image_dir();
			
			
			// Check if image > 1 then show thumb by set thumbnail == 1;
			foreach($this->view_ad($id) as $row) {
			    
			    // Update hit
			    $hit = Posts::findFirst($row['id']);
			    $hit->hit += 1;
			    $hit->save();
			    
			    // Check if thumbnail > 1
				if(count($this->thumbnails($row['id'])) > 1) {
					$this->view->thumbnail = 1;
				} else {
					$this->view->thumbnail = 0;
				}
				
				if(count($this->seller_ads($row['u_id'])) > 1) {
					$this->view->other_ad = 1;
				} else {
					$this->view->other_ad = 0;
				}
				// This seller ads
				$this->view->setVar('ads', $this->seller_ads($row['u_id']));
				 
				// View thumbnails
				$this->view->setVar('thumbs', $this->thumbnails($row['id']));	
			}
			
		}
	 
	     
	}	
	/*
	*  Count ads for preview and view
	*/
	private function view_ad($param) {  
		$phql = "SELECT 
		  p.id AS id, p.title AS title, p.description AS body, p.price AS price, stock AS stock, p.location AS location,
		  DATE_FORMAT(p.created,'%d %b %h:%i %p') AS created, p.url AS url, p.type AS type, p.status AS status, p.note AS note, p.item_condition AS cond,
		  i.image_name AS image,
		  r.name AS region,
		  c.name AS category,
		  u.id AS u_id, u.username AS username, u.name AS name, u.telephone AS telephone, DATE_FORMAT(u.created,'%d %b %h:%i %p') AS since, 
		  u.address AS address, u.email AS email, u.profile_image AS profile_image
		  FROM JunMy\Models\Posts AS p
		  INNER JOIN JunMy\Models\Users AS u ON(u.id = p.user_id)
		  LEFT JOIN JunMy\Models\Postimages AS i ON(p.id = i.post_id) 
		  LEFT JOIN JunMy\Models\Categories AS c ON(c.id = p.category_id) 
		  LEFT JOIN JunMy\Models\Regions AS r ON(r.id = p.region_id) 
		  WHERE p.url = :param: LIMIT 1"; //AND status = :status: 
		$rows = $this->modelsManager->executeQuery($phql, array('param' => $param)); //, 'status' => 1
	 
		return $rows;
	}
	
	/*
	*  This seller ads, Used on index
	*/
	private function seller_ads($user_id) {
		$phql = "SELECT 
		  p.id AS id, p.title AS title, p.price AS price, 
		  i.image_name AS image  
		  FROM JunMy\Models\Posts AS p 
		  LEFT JOIN JunMy\Models\Postimages AS i ON(p.id = i.post_id)  
		  WHERE p.user_id = :param: GROUP BY p.id ORDER BY RAND() LIMIT 4"; //AND status = :status: 
		$rows = $this->modelsManager->executeQuery($phql, array('param' => $user_id)); 
	 
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
	
	private function passwordHash($pwd, $salt = null) {
        if ($salt === null)     {
            $salt = substr(md5(uniqid(rand(), true)), 0, $this->salt_length);
        } else {
            $salt = substr($salt, 0, $this->salt_length);
        }
        return $salt . sha1($pwd . $salt);
    }
	
		private function view_object($cart) {
		foreach($cart as $row) {
			 return $row;
		}
	}
	
	private function view_cart($quantity, $price) {
		return '<li class="list-group-item">Item In Cart<span class="pull-right">'.$quantity.'</span></li>
		<li class="list-group-item">Total<span class="pull-right">RM'.$price.'</span></li>';
	}
	
    /*
	*  Sum speciefic column name ie: price or quantity
	*/
	private function sum_index($array, $column_name){
	    $sum = 0;
	    $cart = $this->session->get('cart');
	    foreach ($cart as $item) {
	        $sum += $item[$column_name];
	    }
	    return $sum;
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
		Function resize($filename_original,$filename_resized,$new_w,$new_h)
	    creates a resized image
	    variables:
	    $filename_original    Original filename
	    $filename_resized    Filename of the resized image
	    $new_w        width of resized image
	    $new_h        height of resized image
    */    
	public function resize($filename_original, $filename_resized, $new_w, $new_h) {
	    $extension = pathinfo($filename_original, PATHINFO_EXTENSION);
	 
	    if ( preg_match("/jpg|jpeg/", $extension) ) $src_img=@imagecreatefromjpeg($filename_original);
	 
	    if ( preg_match("/png/", $extension) ) $src_img=@imagecreatefrompng($filename_original);
	 
	    if(!$src_img) return false;
	 
	    $old_w = imageSX($src_img);
	    $old_h = imageSY($src_img);
	 
	    $x_ratio = $new_w / $old_w;
	    $y_ratio = $new_h / $old_h;
	 
	    if ( ($old_w <= $new_w) && ($old_h <= $new_h) ) {
	        $thumb_w = $old_w;
	        $thumb_h = $old_h;
	    }
	    elseif ( $y_ratio <= $x_ratio ) {
	        $thumb_w = round($old_w * $y_ratio);
	        $thumb_h = round($old_h * $y_ratio);
	    }
	    else {
	        $thumb_w = round($old_w * $x_ratio);
	        $thumb_h = round($old_h * $x_ratio);
	    }        
	 
	    $dst_img=ImageCreateTrueColor($thumb_w,$thumb_h);
	    imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_w,$old_h); 
	 
	    if (preg_match("/png/",$extension)) imagepng($dst_img,$filename_resized); 
	    else imagejpeg($dst_img,$filename_resized,100); 
	 
	    imagedestroy($dst_img); 
	    imagedestroy($src_img);
	 
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
}

