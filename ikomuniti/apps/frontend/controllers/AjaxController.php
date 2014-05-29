<?php

namespace JunMy\Frontend\Controllers;

use JunMy\Models\Users;  
use JunMy\Models\Messages; 
use JunMy\Models\Postimages;

class AjaxController extends ControllerBase {
	
	/*
	*  Ajax username auto suggest
	*/
	public function ajaxusernameAction() {
		 
		$this->view->disable();
		$request = new \Phalcon\Http\Request();
		if($request->isAjax() == true) {
			$term=$_GET["term"];
			
			$phql = "SELECT username FROM JunMy\Models\Users WHERE username like '%$term%' GROUP BY username LIMIT 15";
			$rows = $this->modelsManager->executeQuery($phql);
			//$this->view->since = date('j F, Y', strtotime($rows['users']['created']));
			$json = '[';
	        $first = true;
			foreach($rows as $row) {
				if (!$first) { 
				    $json .=  ','; } else { $first = false; 
				}
	            $json .= '{"value":"'.$row['username'].'"}';
			}  
			$json .= ']';
	        echo $json;
	    }
	}
	
	/*
	*  Ajax user id auto suggest
	*  Return user id
	*/
	public function ajaxuseridAction() {
		$this->view->disable();
		$request = new \Phalcon\Http\Request();
		if($request->isAjax() == true) {
			$term=$_GET["term"];
			
			$phql = "SELECT id FROM JunMy\Models\Users WHERE username like '%$term%' GROUP BY username LIMIT 15";
			$rows = $this->modelsManager->executeQuery($phql);
			//$this->view->since = date('j F, Y', strtotime($rows['users']['created']));
			$json = '[';
	        $first = true;
			foreach($rows as $row) {
				if (!$first) { 
				    $json .=  ','; 
				} else { 
				    $first = false; 
				}
	            $json .= '{"value":"'.$row['id'].'"}';
			}  
			$json .= ']';
	        echo $json;	
		} 
	}
	
	/*
	*  Ajax image thumbnail on imall
	*/
	public function ajaximallAction() {
		$this->view->disable();
		$request = new \Phalcon\Http\Request();
		if($request->isAjax() == true) {
			if($request->isPost() == true) {
			    $image = $_POST['id'];
				echo '<div class="loadimage"><img src="'.$this->imall_image_dir().$image.'" alt="" title="" /></div>';
			}
		}
	}
	
	/*
	*  Ajax image thumbnail on imall
	*/
	public function ajaxiofferAction() {
		$this->view->disable();
		$request = new \Phalcon\Http\Request();
		if($request->isAjax() == true) {
			if($request->isPost() == true) {
			    $image = $_POST['id'];
				echo '<div class="loadimage"><img src="'.$this->ioffer_image_dir().$image.'" alt="" title="" /></div>';
			}
		}
	}
	
	/*
	*  Ajax image thumbnail on imall
	*/
	public function ajaxaddtocartAction() {
		$this->view->disable(); 
		$request = new \Phalcon\Http\Request();
		if($request->isAjax() == true) {
		    //print_r($_POST);
		    if($this->request->isPost()) {
		     
		        // Check user role to prevent iSahabat buy on iOffer
		        $auth = $this->session->get('jun_user_auth');
		        if($auth['role'] < 4) {
					$this->flash->error('Please upgrade your account to iKomuniti.');
				} elseif($this->request->getPost('post_token') == '') {
					$this->flash->error('Invalid token');
				} elseif($this->request->getPost('post_token') != $_SESSION['XMPLV']) {
					$this->flash->error('Error token');
				} elseif(!is_numeric($this->request->getPost('post_ioffer_quantity'))) {
					$this->flash->error('Invalid quantity');
				} elseif(!is_numeric($this->request->getPost('post_ioffer_id'))) {
					$this->flash->error('Invalid product id');
				} elseif(!is_numeric($this->request->getPost('post_ioffer_price'))) {
					$this->flash->error('Invalid product price');
				} else {
					$post_id = $this->request->getPost('post_ioffer_id'); 
					$title = $this->request->getPost('post_ioffer_title'); 
					$price = $this->request->getPost('post_ioffer_price'); 
					$quantity = $this->request->getPost('post_ioffer_quantity'); 
					
					if($quantity > $this->check_stock($post_id)) {
		                $this->flash->error('Not enough stock balance.'); 
					} else {
						$this->add($post_id, $title, $price, $quantity);
					    $cart = $this->session->get('cart');
						 
						echo $this->view_cart($this->sum_index($cart, 'product_quantity'), $this->sum_index($cart, 'product_price'));
					}
				    
					 
				}
			    
		    }
		}
	}
	
	public function ajaxuploadprofileAction() {
	    $this->view->disable();
		$request = new \Phalcon\Http\Request();
		if($request->isAjax() == true) {
		    $auth = $this->session->get('jun_user_auth');  
		    if($this->request->isPost()) { 
				if(!$this->request->getPost($_SESSION['upload_token_name'])) {
					$this->flash->error('Not valid image token');
				} elseif($this->request->getPost($_SESSION['upload_token_name']) == '') {
					$this->flash->error('Not valid image token');
				} elseif($this->request->getPost($_SESSION['upload_token_name']) != $_SESSION['upload_token']) {
					$this->flash->error('Not valid image token');
				} elseif(!isset($_FILES['ImageFile']) || !is_uploaded_file($_FILES['ImageFile']['tmp_name'])) {
					$this->flash->error('Error on upload files, something is missing. Please try again.');
				} elseif(!is_numeric($this->request->getPost('user_id'))) {
					$this->flash->error('Not valid post id. Please try again.');
				} else {
					############ Edit settings ##############
					$ThumbSquareSize 		= 100; //Thumbnail will be 200x200
					$BigImageMaxSize 		= 400; //Image Maximum height or width
					$ThumbPrefix			= ""; //Normal thumb Prefix
					$DestinationThumbDirectory = 'uploads/profiles/'; 
					$DestinationDirectory	= 'uploads/profiles/large/'; //specify upload directory ends with / (slash)
					$Quality 				= 90; //jpeg quality
					$user_id = $this->request->getPost('user_id');
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
						$user = Users::findFirst($user_id); 
						$user->profile_image = $NewImageName;
						if($user->save()) {
							echo '<img src="'.$this->profile_image_dir().$NewImageName.'" 
							class="img-responsive img-thumbnail pull-center">'; 
						} else {
							die('Error IMU222, Please contact administrator.');
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
		
	public function ajaxuploadAction() {
	    $this->view->disable();
		$request = new \Phalcon\Http\Request();
		if($request->isAjax() == true) {
		    $auth = $this->session->get('jun_user_auth');  
		    if($this->request->isPost()) { 
				if(!$this->request->getPost($_SESSION['upload_token_name'])) {
					$this->flash->error('Not valid image token');
				} elseif($this->request->getPost($_SESSION['upload_token_name']) == '') {
					$this->flash->error('Not valid image token');
				} elseif($this->request->getPost($_SESSION['upload_token_name']) != $_SESSION['upload_token']) {
					$this->flash->error('Not valid image token');
				} elseif(!isset($_FILES['ImageFile']) || !is_uploaded_file($_FILES['ImageFile']['tmp_name'])) {
					$this->flash->error('Error on upload files, something is missing. Please try again.');
				} elseif(!is_numeric($this->request->getPost('post_id'))) {
					$this->flash->error('Not valid post id. Please try again.');
				} else {
					############ Edit settings ##############
					$ThumbSquareSize 		= 160; //Thumbnail will be 200x200
					$BigImageMaxSize 		= 700; //Image Maximum height or width
					$ThumbPrefix			= ""; //Normal thumb Prefix
					$DestinationThumbDirectory = 'uploads/imall/thumbnails/'; 
					$DestinationDirectory	= 'uploads/imall/images/'; //specify upload directory ends with / (slash)
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
						$phql = "SELECT post_id FROM JunMy\Models\Postimages WHERE post_id = :id: LIMIT 4";
						$rows = $this->modelsManager->executeQuery($phql, array('id' => $post_id));
						if(count($rows) <= 4) {
							if($this->insert_image($post_id, $NewImageName)) {
								echo '<img src="'.$this->imall_thumb_image_dir().$ThumbPrefix.$NewImageName.'" 
								class="img-responsive img-thumbnail pull-center" width="140">'; 
							} else {
								die('Error IMU222, Please contact administrator.');
							}
						} else {
							die('You are not allow to upload more than 4 image.');
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
	
	public function ajaxreplyAction() { 
		$request = new \Phalcon\Http\Request();
		if($request->isAjax() == true) {
		    $auth = $this->session->get('jun_user_auth'); 
		    $this->view->success = 0; 
		    if($this->request->isPost()) { 
		        if($this->request->getPost('post_token') != $_SESSION['RMTV']) {
					$this->flash->error('Invalid token, please try again.');
				} elseif($this->request->getPost('post_message_id') == '') {
					$this->flash->error('Invalid message, please try again.');
				} elseif($this->request->getPost('post_message_to_id') == '') {
					$this->flash->error('Invalid recipient, please try again.');
				} elseif($this->request->getPost('post_message_from_id') != $auth['id']) {
					$this->flash->error('Invalid sender id, please try again.');
				} elseif($this->request->getPost('post_message') == '') {
					$this->flash->error('Please enter your message.');
				} else {
					// Proceed to insert and retreive from database
					$token = $this->request->getPost('post_token');
					$message_id = $this->request->getPost('post_message_id');
					$to = $this->request->getPost('post_message_to_id');
					$from = $this->request->getPost('post_message_from_id');
					$message = $this->request->getPost('post_message');
					$message_id = $this->request->getPost('post_message_id');
					if($this->reply_message($from, $to, $message, $message_id, $token)) {
						// Select conversation
						$this->view->success = 1;
						$this->view->setVar('replys', $this->ajax_conversation($token));
					}
				}
			 
		    }
		}
	}
	
	private function insert_image($id, $image_name) {
		$img = new Postimages();
		$img->post_id = $id;
		$img->image_name = $image_name;
		$img->default_image = 0;
		if($img->save()) {
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
	
	private function ajax_conversation($token) {
	    $phql = "SELECT 	
					m.id AS m_id, m.from_user_id AS from_id, m.to_user_id AS to_id,  m.body AS body, DATE_FORMAT(m.created,'%d %b') AS created, 
			DATE_FORMAT(m.created,'%h:%i %p') AS time, m.is_read AS is_read,
			u.username AS username, u.id AS user_id, u.profile_image AS image
			FROM JunMy\Models\Messages AS m 
			INNER JOIN JunMy\Models\Users AS u ON(m.from_user_id = u.id)
			WHERE token = :token: ORDER BY m.id ASC LIMIT 50";
		$rows = $this->modelsManager->executeQuery($phql, array('token' => $token));
		return $rows;
	}
	
	private function reply_message($from, $to, $message, $message_id, $token) {
		$msg = new Messages();
		$msg->from_user_id = $from; 
		$msg->to_user_id = $to;
		$msg->body = $message;
		$msg->created = date('Y-m-d H:i:s');
		$msg->is_read = 0; 
		$msg->message_id = $message_id;
		$msg->token = $token;
		return $msg->save();
	}
	
	/*
	*  Sum speciefic column name ie: price or quantity
	*/
	private function sum_index($array, $column){ 
		$sum = 0; 
		foreach ($array as $item) {
	        $sum += $item[$column];
	    }	
		return $sum;  
	}
	
	/*
	*  Update quantity and price if product already in cart
	*/
	private function add_quantity($post_id, $price, $quantity) {
	    if($this->session->has('cart')) {
	        // Check product to prevent add same product > stock
	        if($this->check_stock($post_id) >= $_SESSION['cart'][$post_id]['product_quantity']) {
				$_SESSION['cart'][$post_id]['product_price'] += $this->calculator($price, $quantity);
				$_SESSION['cart'][$post_id]['product_quantity'] += $quantity;	
			} else {
				$this->flash->error('Invalid stock balance.');
			}
			
		}
	}
	
	private function view_cart($quantity, $price) {
		return '<li class="list-group-item">Item In Cart<span class="pull-right">'.$quantity.'</span></li>
		<li class="list-group-item">Total<span class="pull-right">RM'.$price.'</span></li>';
	}
	
	private function set_session($post_id, $title, $price, $quantity) {
	     
        $data = array( 
	            'product_id' => $post_id,
	            'product_name' => $title,
	            'product_quantity' => $quantity,
	            'product_unit_price' => $price, 
	            'product_price' => $this->calculator($price, $quantity)
	        );
	    $_SESSION['cart'][$post_id] = $data;
    }
	
	public function add($post_id, $title, $price, $quantity) {
		if(!is_numeric($post_id)) {
			return false;
		} elseif(!is_numeric($price)) {
			return false;
		} else {
			if($this->session->has('cart')) {
				$cart = $this->session->get('cart');
				// If product already in cart
				if(count($cart[$post_id]) >= 1) {
					// Update price & qty
					if($cart[$post_id]['product_quantity'] == $this->check_stock($post_id)) {
						$this->flash->error('Invalid stock balance.');
					} else {
					    $this->add_quantity($post_id, $price, $quantity);
						 
					}  
					 
				} else {
				    if($cart[$post_id]['product_quantity'] == $this->check_stock($post_id)) {
						$this->flash->error('Invalid stock balance.');
					} else {
					    $this->set_session($post_id, $title, $price, $quantity);
					}
				}   
			} else {
				// Set session new product
				$this->set_session($post_id, $title, $price, $quantity);
				
			}
			
		}
	}
	
	private function calculator($post_price, $post_quantity) {
	     
		if($post_quantity == 1) {
			$total = $post_price;
		} elseif($post_quantity > 1) {
			$total = $post_price * $post_quantity;
		}
		return $total;
	}
	
	private function check_stock($id) { 
		$phql = "SELECT
		    stock 
			FROM JunMy\Models\Companyproducts   
			WHERE id = :id: AND status = :status:
			LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql, array('id' => $id, 'status' => 1));
		foreach($rows as $row) {
			return $row['stock'];
		}
	}
 
}