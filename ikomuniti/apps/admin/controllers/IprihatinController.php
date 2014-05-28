<?php

namespace JunMy\Admin\Controllers;

use JunMy\Models\Users; 
use JunMy\Components\Pagination\Pagination;
use JunMy\Components\Imageupload\Imageupload;
use JunMy\Components\Thumbnail\Thumbnail;
use JunMy\Models\Iprihatin; 
use JunMy\Models\Iprihatinphoto;

class IprihatinController extends ControllerBase {
	
	public $paginationUrl;
	
	public function initialize() {
		$this->tag->setTitle('iPrihatin');
		parent::initialize();
	}
	
	public function indexAction() {
		parent::pageProtect(); 
		$offset = mt_rand(0, 1000);
		$key = 'iprihatin_index_'.$offset;
		$auth = $this->session->get('junauth');
		$this->role($auth['role'], array(3, 4, 6, 7));
		 $this->flashSession->output();
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) {
		    $this->view->setVar('rights', $this->right_post());
			$this->view->setVar('iprihatins', $this->view_all_post());
		    $this->view->setVar('navigations', $this->get_user($auth['id'])); 
			
		}
		$this->view->paginationUrl = $this->paginationUrl; 
		$this->view->cache(array("key" => $key));
		
	}
	
	public function viewAction() {
		parent::pageProtect(); 
		
		//get user session
		$auth = $this->session->get('junauth');
		
		//set admin role
		$this->role($auth['role'], array(3, 4, 6, 7));
		
		//echo flash message from edit
		$this->flashSession->output();
		
		//cache
		$offset = mt_rand(0, 251000);
		$key = 'iprihatin_view_'.$this->dispatcher->getParam('slug').$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) { 
			$this->view->setVar('iprihatins', $this->view_post($this->dispatcher->getParam('slug'))); 
			$this->view->setVar('navigations', $this->get_user($auth['id']));  
			$this->view->setVar('rights', $this->right_post());
		}
		 
		$this->view->cache(array("key" => $key));
	}
	
	public function addAction() {
		parent::pageProtect();
		$auth = $this->session->get('junauth');
		$this->role($auth['role'], array(3, 4, 6, 7));
		
		$offset = mt_rand(0, 251000);
		$key = 'iprihatin_new_post'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) { 
		    $this->view->setVar('navigations', $this->get_user($auth['id']));  
		    $this->view->setVar('rights', $this->right_post());
		}
		 
		$this->view->cache(array("key" => $key));
		
		if($this->request->isPost()) {
			if(strlen($this->request->getPost('title')) < 10) {
				$this->flash->error('Please enter iPrihatin title');
			} elseif(strlen($this->request->getPost('body')) < 10){
				$this->flash->error('Please enter iPrihatin body');
			} else {
			    
			    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
    			$body = filter_input(INPUT_POST, 'body', FILTER_SANITIZE_SPECIAL_CHARS);
				$post = new Iprihatin();
				$post->title = $title;
				$post->body = $body;
				$post->created = date('Y-m-d H:i:s');
				$post->slug = $this->slug($title.'-'.date('Y-m-d-H-i-s'));
				$post->type = 0;
				$post->amount = 0.00;
				$post->pic = $auth['id'];
				if (!$post->save()) {
		            foreach ($post->getMessages() as $message) {
		                $this->flash->error((string) $message);
		            }
		
		        } else {
		            $this->response->redirect('gghadmin/iprihatin/steptwo/'.$post->id);
		        }  
			}
		}
	}
	
	public function steptwoAction() {
		parent::pageProtect();
		$auth = $this->session->get('junauth');
		$this->role($auth['role'], array(3, 4, 6, 7));
		
		$offset = mt_rand(0, 251000);
		$key = 'iprihatin_new_post'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) { 
		    $this->view->setVar('navigations', $this->get_user($auth['id']));  
		    $this->view->setVar('rights', $this->right_post());
		}
		 
		$this->view->cache(array("key" => $key));
		
		$id = $this->dispatcher->getParam('id');
		
		$this->view->urlajax = $this->url->get('gghadmin/iprihatin/ajaxiprihatin'); 
		
		$this->view->setVar('iprihatins', $this->view_step_two($id));
		
		if(isset($_GET['ref'])) {
			if($_GET['ref'] == 'save') {
			    $pos = Iprihatin::findFirst($id);
			    $pos->type = 1;
			    if($pos->save()) {
					$this->flashSession->success('iPrihatin post has been saved');
					return $this->response->redirect('gghadmin/iprihatin/index');	
				} else {
					foreach ($pos->getMessages() as $message) {
		                $this->flash->error((string) $message);
		            }
				}
				
			}
		}
		 
	}
	
	private function view_step_two($id) {
	    $phql = "SELECT * FROM JunMy\Models\Iprihatin WHERE id = '$id' LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql);
		 
		return $rows;
	}
	
	public function editAction() {
		parent::pageProtect();
		$auth = $this->session->get('junauth');
		$this->role($auth['role'], array(3, 4, 6, 7));
		$offset = mt_rand(0, 251000);
		$key = 'iprihatin_edit_'.$this->dispatcher->getParam('slug').$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) { 
			$this->view->setVar('iprihatins', $this->view_post($this->dispatcher->getParam('slug')));
		    $this->view->setVar('navigations', $this->get_user($auth['id'])); 
		    $this->view->setVar('rights', $this->right_post());
		} 
		$this->view->cache(array("key" => $key));
		if($this->request->isPost()) {
		    $slug = $this->dispatcher->getParam('slug');
			$post = Iprihatin::findFirst("slug='$slug'");
			$post->body = $this->request->getPost('body');
			if($post->save()) {
				$this->flashSession->success('iPrihatin has been saved');
				return $this->response->redirect("gghadmin/iprihatin/view/".$slug);
			} else {
				$this->flash->error('Error IP9094, Please contact Azrul');
			}
		}
	}
	
	private function right_post() {
	    $phql = "SELECT title, DATE_FORMAT(created,'%d %b %h:%i %p') AS created, slug, SUBSTRING(body, 1, 70) AS body FROM JunMy\Models\Iprihatin ORDER BY id DESC LIMIT 5";
		$rows = $this->modelsManager->executeQuery($phql);
		 
		return $rows;
	}
	
	/*
	*  Insert new post
	*  Used on addAction
	*/
	private function save_image($id, $img_name) { 		
		$image = new Iprihatinphoto();
		$image->iprihatin_id = $id;
		$image->image_name = $upload->rename;
		if (!$image->save()) {
            foreach ($image->getMessages() as $message) {
                $this->flash->error((string) $message);
            } 
        } else {
            return true; 
        } 
	}	
	
	
	/*
	*  View all post
	*  Return BOOLEAN
	*/	
	private function view_all_post() {
		$records_per_page = 25;
	    $paginations = new Pagination();
        $paginate = (($paginations->get_page() - 1) * $records_per_page);
		$phql = "SELECT
		    id, title, SUBSTRING(body, 1, 120) AS body, DATE_FORMAT(created,'%d %b %h:%i %p') AS created, slug, amount, type, pic
			FROM JunMy\Models\Iprihatin 
			
			ORDER BY id DESC";
		$count = $this->modelsManager->executeQuery($phql);	
		if(count($count) > 0) {
			$paginations->records(count($count));
	        $rows = $this->modelsManager->executeQuery($phql." LIMIT $paginate , $records_per_page");	
	        // records per page
	        $paginations->records_per_page($records_per_page);
			$this->paginationUrl = $paginations->render();
	        
			return $rows;	
		} else {
			$this->flash->error('Tiada rekod dalam iPrihatin');
		}
        
	}
	
	/*
	*  View each post, used on viewAction
	*  Return BOOLEAN
	*/	
	private function view_post($slug) {
	    $phql = "SELECT 
			i.title AS title, i.body AS body, DATE_FORMAT(i.created,'%d %b %h:%i %p') AS created, i.slug AS slug, 
			i.amount AS amount, i.type AS type, i.pic AS pic,
			p.image_name AS image
		FROM JunMy\Models\Iprihatin AS i
		LEFT JOIN JunMy\Models\Iprihatinphoto AS p on(p.iprihatin_id = i.id) 
		WHERE i.slug LIKE '$slug' LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql);
	 
		return $rows;
	}
	
	/*
	*  View MY PROFILE
	*  Return BOOLEAN
	*/	
	private function get_user($id) {
	    $phql = "SELECT * FROM JunMy\Models\Users WHERE id = :id: LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql, array('id' => $id));
		 
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
	
	public function ajaxiprihatinAction() {
	    $this->view->disable();
		$request = new \Phalcon\Http\Request();
		if($request->isAjax() == true) {  
		    if($this->request->isPost()) { 
				if(!isset($_FILES['ImageFile']) || !is_uploaded_file($_FILES['ImageFile']['tmp_name'])) {
					$this->flash->error('Error on upload files, something is missing. Please try again.');
				} elseif(!is_numeric($this->request->getPost('post_id'))) {
					$this->flash->error('Not valid post id. Please try again.');
				} else {
					############ Edit settings ##############
					$ThumbSquareSize 		= 100; //Thumbnail will be 200x200
					$BigImageMaxSize 		= 680; //Image Maximum height or width
					$ThumbPrefix			= ""; //Normal thumb Prefix
					$DestinationThumbDirectory = 'uploads/iprihatins/thumbs/'; 
					$DestinationDirectory	= 'uploads/iprihatins/'; //specify upload directory ends with / (slash)
					$Quality 				= 90; //jpeg quality
					$post_id = $this->request->getPost('post_id');
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
						 
						$image = new Iprihatinphoto();
						$image->iprihatin_id = $post_id;
						$image->image_name = $NewImageName;
						if (!$image->save()) {
						    foreach ($image->getMessages() as $message) {
						        $this->flash->error((string) $message);
						    } 
						} else {
						    echo '<img src="'.$this->iprihatin_thumb_dir().$NewImageName.'" 
							class="img-responsive img-thumbnail pull-center">'; 
						} 
				
						/*
						// Insert info into database table!
						mysql_query("INSERT INTO myImageTable (ImageName, ThumbName, ImgPath)
						VALUES ($DestRandImageName, $thumb_DestRandImageName, 'uploads/')");
						*/
				
					} else {
						die('Resize Error'); //output error
					} 	
				}
		    }
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