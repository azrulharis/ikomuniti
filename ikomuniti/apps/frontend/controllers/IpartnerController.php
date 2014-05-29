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
	    parent::pageProtect();
	    
		$this->view->ipartner_thumb_dir = $this->ipartner_thumb_image_dir();
		
		$auth = $this->session->get('jun_user_auth');
		
		$this->role($auth['role'], array(3, 4, 5, 6, 7, 8, 9));
		 
		$offset = mt_rand(0, 9521000);  
		$key = 'imall_myads_'.$auth['id'].'_'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) {
		    $this->view->setVar('navigations', $this->get_user($auth['id'])); 
			$this->view->setVar('posts', $this->view_ads($auth['id']));
		}
		 
		$this->view->cache(array("key" => $key)); 
	}
	
	public function viewAction() {
		parent::pageProtect();
		$auth = $this->session->get('jun_user_auth');
	    if(count($this->view_ad($this->dispatcher->getParam('slug'))) > 0) {
			$this->view->setVar('posts', $this->view_ad($this->dispatcher->getParam('slug')));
		} else {
			return $this->response->redirect('ipartner/add');
		}  
		
		$offset = mt_rand(0, 921000);  
		$key = 'ipartner_view_'.$this->dispatcher->getParam('slug').'_'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) {
		    $this->view->setVar('navigations', $this->get_user($auth['id'])); 
			$this->view->host = $this->host();
		} 
		$this->view->cache(array("key" => $key)); 
	}
	
	public function addAction() {
	    parent::pageProtect();
	    $auth = $this->session->get('jun_user_auth');
	    
		$this->role($auth['role'], array(3, 4, 5, 6, 7, 8, 9));
	    
	    $this->view->urlajax = $this->url->get('ajax/ajaxcategory');
        if($this->request->isPost()) { 
		    if($auth['role'] < 4) {
			    $this->flash->error('You are not allow to add new post on iPartner, Please upgrade your account.');
		    } elseif($this->request->getPost('region_id') == 0) {
				$this->flash->error('Please select region');
				
			} elseif($this->request->getPost('category_id') == 0) {
				$this->flash->error('Please select category');
				
			} else { 
			    //print_r($_POST);
				$this->session->set('jun_post_data', $_POST);
				return $this->response->redirect('ipartner/steptwo'); 
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
	
	public function myadsAction() {
		
	}
	
	public function steptwoAction() {
		parent::pageProtect();
		$auth = $this->session->get('jun_user_auth');
		
		$this->role($auth['role'], array(4, 5, 6, 7, 8, 9));
		
		$this->view->setVar('navigations', $this->get_user($auth['id']));
	    if(isset($_SESSION['jun_post_data'])) {
	     
	        $region = $_SESSION['jun_post_data']['region_id']; 
	        $category = $_SESSION['jun_post_data']['category_id']; 
	        
	        // View previous data
			$this->view->setVar('regions', $this->region("WHERE id = '$region' LIMIT 1"));
			$this->view->setVar('categories', $this->category("WHERE id = '$category' LIMIT 1")); 
			
			// Submit data on 2nd step
			if($this->request->isPost()) {
			  
			  
				if(strlen($this->request->getPost('title')) > 64 || strlen($this->request->getPost('title')) < 5) {
					$this->flash->error('Title must between 5 - 64 character'); 
				} elseif(strlen($this->request->getPost('body')) < 3) {
					$this->flash->error('Minimum description 3 character'); 
				} elseif(strlen($this->request->getPost('address_one')) < 3) {
					$this->flash->error('Please enter your business address'); 
				} elseif(strlen($this->request->getPost('postcode')) < 3 || strlen($this->request->getPost('postcode')) > 6) {
					$this->flash->error('Please enter valid postcode'); 
				} elseif(!is_numeric($this->request->getPost('postcode'))) {
					$this->flash->error('Please enter valid postcode');
				} elseif($this->request->getPost('discount') == '') {
					$this->flash->error('Please describe discount for iKomuniti');
				} elseif($this->request->getPost('city') == '') {
					$this->flash->error('Please enter valid city');
				} else {
				    $url = $this->slug($this->request->getPost('title')).'-'.date('mdHis');
				    //insert post to database
				    $posts = new Ipartner();  
					$posts->title = $this->request->getPost('title');  
					$posts->description = $this->request->getPost('body');
					$posts->discount = $this->request->getPost('discount');   
					$posts->address_one = $this->request->getPost('address_one');
					$posts->address_two = $this->request->getPost('address_two') != '' ? $this->request->getPost('address_two') : '0';
					$posts->city = $this->request->getPost('city');
					$posts->postcode = $this->request->getPost('postcode'); 
					$posts->category_id = $category;  
					$posts->region_id = $region;  
					$posts->user_id = $auth['id']; 
					$posts->created = date('Y-m-d H:i:s'); 
					$posts->url = $url;  
					$posts->type = 0;
					$posts->status = 0; 
					$posts->note = 0; 
					if (!$posts->save()) {
			            foreach ($posts->getMessages() as $message) {
			                $this->flash->error((string) $message);
			            }
			
			        } else {  
			            $post_id = $posts->id;
					    if($this->request->hasFiles() == true) {  
						    ############ Edit settings ##############
							$ThumbSquareSize 		= 160; //Thumbnail will be 200x200
							$BigImageMaxSize 		= 700; //Image Maximum height or width
							$ThumbPrefix			= ""; //Normal thumb Prefix
							$DestinationThumbDirectory = 'C:xampp/htdocs/ishare/isharephal/public/uploads/ipartners/thumbnails/'; 
							//specify upload directory ends with / (slash)
							$DestinationDirectory	= 'C:xampp/htdocs/ishare/isharephal/public/uploads/ipartners/images/'; 
							$Quality 				= 90; //jpeg quality 
							##########################################
							 
							
							// check $_FILES['ImageFile'] not empty
							
							
							// Random number will be added after image name
							$RandomNumber 	= rand(0, 9999999999); 
						
							$ImageName 		= str_replace(' ','-',strtolower($_FILES['ImageFile']['name'])); //get image name
							$ImageSize 		= $_FILES['ImageFile']['size']; // get original image size
							$TempSrc	 	= $_FILES['ImageFile']['tmp_name']; // Temp name of image file stored in PHP tmp folder
							$ImageType	 	= $_FILES['ImageFile']['type']; //get file type, returns "image/png", image/jpeg, text/plain etc.
						
							//Let's check allowed $ImageType, we use PHP SWITCH statement here
							switch(strtolower($ImageType)) {
								case 'image/png':
									//Create a new image from file 
									$CreatedImage =  imagecreatefrompng($_FILES['ImageFile']['tmp_name']);
									break;
								case 'image/gif':
									$CreatedImage =  imagecreatefromgif($_FILES['ImageFile']['tmp_name']);
									break;			
								case 'image/jpeg':
								case 'image/pjpeg':
									$CreatedImage = imagecreatefromjpeg($_FILES['ImageFile']['tmp_name']);
									break;
								default:
									die('Unsupported File!'); //output error and exit
							}
							
							//PHP getimagesize() function returns height/width from image file stored in PHP tmp folder.
							//Get first two values from image, width and height. 
							//list assign svalues to $CurWidth,$CurHeight
							list($CurWidth,$CurHeight)=getimagesize($TempSrc);
							if($CurWidth < 200 || $CurHeight < 200) {
								die('File width X height too small. Please upload minimum 200 px.');
							}
							//Get file extension from Image name, this will be added after random name
							$ImageExt = substr($ImageName, strrpos($ImageName, '.'));
						  	$ImageExt = str_replace('.','',$ImageExt);
							
							//remove extension from filename
							$ImageName 		= preg_replace("/\\.[^.\\s]{3,4}$/", "", $ImageName); 
							
							//Construct a new name with random number and extension.
							$NewImageName = date('YmdHis').'-'.$RandomNumber.'.'.$ImageExt;
							
							//set the Destination Image
							$thumb_DestRandImageName 	= $DestinationThumbDirectory.$ThumbPrefix.$NewImageName; //Thumbnail name with destination directory
							$DestRandImageName 			= $DestinationDirectory.$NewImageName; // Image with destination directory
							
							//Resize image to Specified Size by calling resizeImage function.
							if($this->resizeImage($CurWidth,$CurHeight,$BigImageMaxSize,$DestRandImageName,$CreatedImage,$Quality,$ImageType)) {
								//Create a square Thumbnail right after, this time we are using cropImage() function
								if(!$this->cropImage($CurWidth,$CurHeight,$ThumbSquareSize,$thumb_DestRandImageName,$CreatedImage,$Quality,$ImageType)) { 
									$this->flash->error('Error creating thumbnail. Please try again.');
								}
								/*
								We have succesfully resized and created thumbnail image
								We can now output image to user's browser or store information in the database
								*/ 
								if($this->save_image($post_id, $NewImageName)) {
									// Redirect to finish page even no image was upload
						            $this->response->redirect('ipartner/finish/'.$url);	
								} else {
									die('Error IMU222, Please contact administrator.');
								}
								 
						
							} else {
								die('Resize Error'); //output error
							} 	
						} else {
							// Redirect to finish page even no image was upload
						    $this->response->redirect('ipartner/finish/'.$url);	
						} 
					}
					
				}
			}
			
			
		} else {
			return $this->response->redirect('ipartner/add');
		}  
		
		$offset = mt_rand(0, 921000);  
		$key = 'ipartner_steptwo_'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) {
		    
			$this->view->setVar('users', $this->get_user($auth['id']));
			 
		} 
		$this->view->cache(array("key" => $key)); 
	}
	
	public function finishAction() {
		parent::pageProtect();
		$auth = $this->session->get('jun_user_auth');
		
		$this->role($auth['role'], array(4, 5, 6, 7, 8, 9));
		
	    if(count($this->view_ad($this->dispatcher->getParam('slug'))) > 0) {
			$this->view->setVar('posts', $this->view_ad($this->dispatcher->getParam('slug')));
		} else {
			return $this->response->redirect('ipartner/add');
		}  
		
		$offset = mt_rand(0, 921000);  
		$key = 'imall_steptwo_'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) {
		    $this->view->setVar('navigations', $this->get_user($auth['id'])); 
		} 
		$this->view->cache(array("key" => $key)); 
		unset($_SESSION['jun_post_data']);
	}
	
	/*
	*  Select ads listing on index
	*/
	private function view_ads($user_id) {
		$records_per_page = 20;
	    $paginations = new Pagination();
        $paginate = (($paginations->get_page() - 1) * $records_per_page);
		$phql = "SELECT
		    p.id AS id, p.title AS title, p.discount AS discount, SUBSTRING(p.description, 1, 160) AS body,
		    DATE_FORMAT(p.created,'%d %b %h:%i %p') AS created, p.url AS slug, p.type AS type, p.status AS status, p.note AS note,
		    i.image_name AS image, c.name AS category
			FROM JunMy\Models\Ipartner AS p
			LEFT JOIN JunMy\Models\Ipartnerimage AS i ON(p.id = i.post_id)
			LEFT JOIN JunMy\Models\Ipartnercategories AS c ON(p.category_id = c.id)
			WHERE p.user_id = '$user_id'
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
		  p.created AS created, p.url AS url, p.type AS type, p.status AS status, p.note AS note,
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