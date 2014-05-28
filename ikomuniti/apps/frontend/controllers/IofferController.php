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
		parent::pageProtect();
	    $this->flashSession->output();
	    // Get session in array
	    $auth = $this->session->get('jun_user_auth');
	    $this->view->role = $auth['role'];
	    $offset = mt_rand(0, 1000);
		$key = 'ioffer_index_'.$auth['id'].'_'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) {  
		    $this->view->setVar('navigations', $this->get_user($auth['id']));  
		} 
		$this->view->cache(array("key" => $key));
		$this->view->paginationUrl = $this->paginationUrl;
		$this->view->ioffer_thumb_dir = $this->ioffer_thumb_dir();
		$this->view->setVar('posts', $this->view_listings());
	}
	
	public function viewAction() {
		parent::pageProtect(); 
		$auth = $this->session->get('jun_user_auth');
		
		$this->view->ajaxCartUrl = $this->url->get('ajax/ajaxaddtocart'); 
	     
		// Session token to prevent CSRF
		$_SESSION['XMPLC'] = $this->passwordHash(date('YmdHis'));
		$_SESSION['XMPLV'] = $this->passwordHash(date('mdHis'));
		$this->view->field_name = $_SESSION['XMPLC'];
		$this->view->field_value = $_SESSION['XMPLV'];
		
		
		$id = $this->dispatcher->getParam('slug');
		$offset = mt_rand(0, 21000);  
		$key = 'ioffer_view_'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) {
		    $this->view->setVar('navigations', $this->get_user($auth['id']));
		     
		}
		$this->view->cache(array("key" => $key));
		 
	    if(count($this->select_ad($id)) != 1) {
			$this->flashSession->error('Product not found');
			return $this->response->redirect('ioffer/index');
		} else { 
		 
			
			$this->view->urlajax = $this->url->get('ajax/ajaxioffer'); 
			// Preview ad
			$this->view->setVar('posts', $this->view_ad($id));
			
			// Get iPoint balance
			$this->view->setVar('ipoints', $this->ipoint($auth['id']));
			
			// Check if image > 1 then show thumb by set thumbnail == 1;
			foreach($this->view_ad($id) as $row) {
				if(count($this->thumbnails($row['id'])) > 1) {
					$this->view->thumbnail = 1;
				} else {
					$this->view->thumbnail = 0;
				}
				
				$this->view->ioffer_thumb_dir = $this->ioffer_thumb_dir();
				// View thumbnails
				$this->view->setVar('thumbs', $this->thumbnails($row['id']));	
			}
			
		}
		
		if($this->request->isPost()) {
		    $post_id = $this->request->getPost('id'); 
			$title = $this->request->getPost('title'); 
			$price = $this->request->getPost('price'); 
			$quantity = $this->request->getPost('quantity'); 
			
			$this->add($post_id, $title, $price, $quantity);
		}
		//echo count($_SESSION['cart'][0]);
	    
	    // If session cart is exist, view cart
		if($this->session->has('cart')) {
			$cart = $this->session->get('cart'); 
			$this->view->viewCart = $this->view_cart($this->sum_index($cart, 'product_quantity'), $this->sum_index($cart, 'product_price')); 
		} else {
			$this->view->viewCart = $this->view_cart(0, 0.00); 
		}
	}
	
	public function viewcartAction() {
		parent::pageProtect(); 
		$auth = $this->session->get('jun_user_auth');
		
		// View ipoint balance
		$this->view->setVar('ipoints', $this->ipoint($auth['id'])); 
		
		$id = $this->dispatcher->getParam('slug');
		$offset = mt_rand(0, 21000);  
		$key = 'ioffer_viewcart_'.$auth['id'].'_'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) {
		    $this->view->setVar('navigations', $this->get_user($auth['id']));
		     
		}
		$this->view->cache(array("key" => $key)); 
		if(isset($_GET['utility'])) {
			if($_GET['utility'] == 'clear') {
			    // Check token
				if(ctype_alnum($_GET[$_SESSION['XMLPN']]) && ctype_alnum($_SESSION['XMLPV']) && $_GET[$_SESSION['XMLPN']] == $_SESSION['XMLPV']) {
					// Clear cart
					$this->session->remove('cart');
					$this->session->remove('XMLPN');
					$this->session->remove('XMLPV');
					$this->flashSession->success('Your shopping cart is empty.');
					return $this->response->redirect('ioffer/index');
				} else {
					$this->flashSession->error('Not valid token.');
					return $this->response->redirect('ioffer/index');
				}
			} else {
				$this->flashSession->error('Not valid request.');
				return $this->response->redirect('ioffer/index');
			}
		} else {
			// Generate session key to prevent CSRF attack 	 
			$_SESSION['XMLPN'] = $this->passwordHash(date('YmdHis'));
			$_SESSION['XMLPV'] = $this->passwordHash(date('mdHis'));
			$this->view->field_name = $_SESSION['XMLPN'];
			$this->view->field_value = $_SESSION['XMLPV'];
		
		}
		// Check session cart is exist
		if($this->session->has('cart')) {
			$cart = $this->session->get('cart');
			
			// Check item in cart
			if(count($cart) > 0) {
				// Display cart 
				// Set view or hide 
				
			    $this->view->view_item = 1;
			    $this->view->setVar('products', $cart); 
			    $this->view->grand_total = $this->sum_index($cart, 'product_price');
			} else {
			    // Set view or hide
				$this->view->view_item = 0; 
			}
		} else {
		    // Set view or hide
			$this->view->view_item = 0; 
		}
		
		
	}
	
	public function checkoutAction() {
		parent::pageProtect(); 
		$auth = $this->session->get('jun_user_auth');
		 
		$id = $this->dispatcher->getParam('slug');
		$offset = mt_rand(0, 21000);  
		$key = 'ioffer_checkout_'.$auth['id'].'_'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) {
		    $this->view->setVar('navigations', $this->get_user($auth['id']));
		     
		}
		$this->view->cache(array("key" => $key)); 
		// Prevent undefine view
		$this->view->view_success = 0; 
		if($this->request->isPost()) {
			if($this->request->getPost('submit') == 'Proceed To Checkout') {
				
				// Validate
				if(!$this->request->getPost($_SESSION['XMLPN'])) {
					$this->flashSession->error('Not valid request.');
					return $this->response->redirect('ioffer/index');
				} elseif($this->request->getPost($_SESSION['XMLPN']) != $_SESSION['XMLPV']) {
					$this->flashSession->error('Not valid request.');
					return $this->response->redirect('ioffer/index');
				} elseif(strlen($this->request->getPost('name')) < 5 || strlen($this->request->getPost('name')) > 64) {
					$this->flash->error('Name must be 5 to 64 character. Please back to reenter valid name.');
				} elseif(!is_numeric($this->request->getPost('phone'))) {
					$this->flash->error('Phone number must in numeric format (ie: 0121234567).');
				} elseif(strlen($this->request->getPost('phone')) < 10 || strlen($this->request->getPost('phone')) > 13) {
					$this->flash->error('Not valid phone number.');
				} elseif(strlen($this->request->getPost('address_one')) < 5 || strlen($this->request->getPost('address_one')) > 64) {
					$this->flash->error('Address line 1 must be 5 to 64 character.');
				} elseif(strlen($this->request->getPost('postcode')) < 4 || strlen($this->request->getPost('postcode')) > 6) {
					$this->flash->error('Postcode must be 4 to 6 character.');
				} elseif(!is_numeric($this->request->getPost('postcode'))) {
					$this->flash->error('Please enter valid postcode.');
				} elseif(strlen($this->request->getPost('city')) < 3 || strlen($this->request->getPost('city')) > 64) {
					$this->flash->error('Please enter valid city.');
				} elseif($this->request->getPost('region') == '0') {
					$this->flash->error('Please select region.');
				} elseif($this->request->getPost('payment_method') == '0') {
					$this->flash->error('Please select payment method.');
				} else {
				    $cart = $this->session->get('cart');
				    $payment_method = $this->request->getPost('payment_method'); 
				    $grand_total = $this->sum_index($cart, 'product_price');
				    $phone = $this->request->getPost('phone');
				    $webcash = $this->request->getPost('amount_to_pay');
					// Calculate service charge if pay via webcash or credit card
					if($payment_method == 1) {
						$total = $grand_total;
					} elseif($payment_method == 2) {
						$total = ($webcash / 100 * 2) + $webcash;
					} elseif($payment_method == 3) {
						$total = ($webcash / 100 * 4) + $webcash;
					}
					// Round 2 decimal ie: 99.999 to 100 / 56.1111 to 56.11
					$total = round($total, 2);
					// Proceed to insert
					 
					$product_id = implode(', ', array_map(function ($product) {
					  return $product['product_id'];
					}, $cart));
					
					$product_quantity = implode(', ', array_map(function ($product) {
					  return $product['product_quantity'];
					}, $cart));
					
					$po = new Companyproductorders();  
					$po->company_product_id = $product_id; 
					$po->user_id = $auth['id']; 
					$po->username = $auth['username']; 
					$po->address = $this->request->getPost('address_one').' '.$this->request->getPost('address_two').' '.$this->request->getPost('region'); 
					$po->created = date('Y-m-d H:i:s'); 
					$po->postcode = $this->request->getPost('postcode'); 
					$po->phone = $phone; 
					$po->tracking_code = 'NA'; 
					$po->total_product = $product_quantity; 
					$po->amount = $grand_total;
					$po->real_amount = $webcash; // Amount before fee, that will add to ipoint
					$po->paid_amount =  $total; // Amount after fee
					$po->status = 0; 
					$po->payment = 0; 
					$po->merchant_ref = 0;
					$po->payment_method = $payment_method;
					if($po->save()) { 
						$this->view->view_success = 1;
						$this->view->order_id = $po->id;
						$this->view->payment_method = $payment_method;  
						$this->view->date = date('Y-m-d H:i:s');
						$this->view->phone = $phone;
						$this->view->host = $this->host();
						
						// iPoint balance
						$this->view->setVar('ipoints', $this->ipoint($auth['id']));
						$this->view->grand_amount = $grand_total;
						$this->view->amount_to_pay = $total;
						// Remove session to prevent duplicate request 
						$this->session->remove('XMLPN');
						$this->session->remove('XMLPV');
						
						// Set new session for payment verification token
						$_SESSION['IOPKN'] = $this->passwordHash($po->id);
						$_SESSION['IOPKV'] = $this->passwordHash($total);
						// Set view for return url from webcash
						$this->view->return_name = $_SESSION['IOPKN'];
						$this->view->return_value = $_SESSION['IOPKV'];
					} else {
						$this->flash->error('Error ESPCO241. Process has been stop, please contact administrator.');
					}
				}
			} else {
				// Redirect to index with error message
				$this->flashSession->error('Not valid request.');
				return $this->response->redirect('ioffer/index');
			}
		} else {
			// Redirect to index with error message
			$this->flashSession->error('Not valid request.');
			return $this->response->redirect('ioffer/index');
		}
		
		
		
	}
	
	public function verificationAction() {
		parent::pageProtect(); 
		$auth = $this->session->get('jun_user_auth'); 
		$this->view->disable();
		//print_r($_REQUEST);
		$id = $this->dispatcher->getParam('id');
		if(!is_numeric($id)) { 
			$this->flashSession->error('Not valid request.');
			return $this->response->redirect('ioffer/index');
		} elseif(!$this->session->has('IOPKN') && !$this->session->has('IOPKV')) {
			$this->flashSession->error('Not valid request.');
			return $this->response->redirect('ioffer/index');
		} else {
		    // Check if session token is exist
			if($this->request->hasQuery($this->session->get('IOPKN'))) {
			    // Check if session token is match
				if($_GET[$this->session->get('IOPKN')] == $this->session->get('IOPKV')) {
					// Check return value from webcash
					if(isset($_REQUEST['returncode'])) {  
					    if(ctype_alnum($_REQUEST['returncode']) && $_REQUEST['returncode'] == 1) { //CHANGE TO 1
							if(count($this->get_order($id, $auth['id'], $auth['username'])) == 1) {
								// Update payment
								$order = Companyproductorders::findFirst($id);
								
								// If user choose credit card
								if($order->payment_method == 3) {
								    // if they pay using online banking instead
								    if($_REQUEST['ord_famt'] < $order->paid_amount) {
									     
										$amount = $order->real_amount;
										// Insert history, add ipoint
										if($this->add_wallet($auth['id'], $amount)) {
											if($this->history($auth['id'], 'Deposit Via WebCash', $amount, 'WCD'.date('YmdHis').$auth['id'], 7)) {
											    // Remove session token
											    unset($_SESSION['IOPKN']);
												unset($_SESSION['IOPKV']);
												$this->flashSession->warning('You have add '.$amount.' to iPoint. Item purchase has been failed.');
												return $this->response->redirect('ioffer/index');
											}
										}	
									} elseif($_REQUEST['ord_famt'] == $order->paid_amount) { 
										$amount = $order->real_amount;
										// Insert history, add ipoint
										if($this->add_wallet($auth['id'], $amount)) {
											if($this->history($auth['id'], 'Deposit Via Credit Card', $amount, 'WCC'.date('YmdHis').$auth['id'], 7)) {
												// Remove session token  
												return $this->response->redirect('payment/ioffer/'.$id.'?id='.$id.'&type=3');
											}
										}
									}
								
								// if choose online payment	
								} elseif($order->payment_method == 2) {
									$amount = $order->real_amount;
									// Insert history, add ipoint
									if($this->add_wallet($auth['id'], $amount)) {
										if($this->history($auth['id'], 'Deposit Via WebCash', $amount, 'WCD'.date('YmdHis').$auth['id'], 7)) {
										    // Remove session token 
											return $this->response->redirect('payment/ioffer/'.$id.'?id='.$id.'&type=2');
										}
									}
								}
								
							} else {
								$this->flashSession->error('Not valid request.');
								return $this->response->redirect('ioffer/index');
							}
						} else {
							$this->flashSession->error('Payment was unsuccessful.');
							return $this->response->redirect('ioffer/index');
						}
					} else {
						$this->flashSession->error('Not valid request.');
						return $this->response->redirect('ioffer/index');
					}
				} else {
					$this->flashSession->error('Not valid request.');
					return $this->response->redirect('ioffer/index');
				}
			} else {
				$this->flashSession->error('Not valid request.');
				return $this->response->redirect('ioffer/index');
			}
		}
	}
	
	/*
	*  Add iPoint via webcash
	*/
	private function add_wallet($id, $amount) {
		$phql = "UPDATE JunMy\Models\Wallets SET 
				amount = amount + '$amount' WHERE user_id = :id:";
		$update = $this->modelsManager->executeQuery($phql, array('id' => $id));
		return $update;
	}
	/* 
	*  Transaction history
	*/
	private function history($user_id, $title, $amount, $ref, $type) {
	    $addhist = new Transactions();  
		$addhist->user_id = $user_id; 
		$addhist->title = $title;
		$addhist->amount = $amount; 
		$addhist->created = date('Y-m-d H:i:s'); 
		$addhist->reference = $ref; //'IOD'.date('YmdHis').$auth['id']; 
		$addhist->type = $type;
		$addhist->pic = $user_id;
		return $addhist->save();	
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
	
	private function ipoint($user_id) {
		$phql = "SELECT
		    amount
			FROM JunMy\Models\Wallets 
			WHERE user_id = :id:
			LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql, array('id' => $user_id));
		return $rows;
	}
	
	private function get_order($id, $user_id, $username) {
		$phql = "SELECT
		    amount
			FROM JunMy\Models\Companyproductorders 
			WHERE id = :id: AND user_id = :user_id: AND username = :username: AND payment = :payment: AND status = :status:
			LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql, array('id' => $id, 'user_id' => $user_id, 'username' => $username, 'payment' => 0, 'status' => 0));
		return $rows;
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