<?php

namespace JunMy\Frontend\Controllers;
use JunMy\Models\Users;
use JunMy\Models\Posts;
use JunMy\Models\Wallets;
use JunMy\Models\Categories;
use JunMy\Models\Postimages; 
	
class ImallController extends ControllerBase {
 
     
	
	public $salt_length = 9;
	
	public function initialize() {
		$this->tag->setTitle('iMall');
		parent::initialize();
	}
	
	public function viewcartAction() { 
		$auth = $this->session->get('jun_user_auth');
		
		// View ipoint balance
		$this->view->setVar('ipoints', $this->ipoint($auth['id'])); 
		
		$id = $this->dispatcher->getParam('slug'); 
		
		$this->view->setVar('navigations', $this->get_user($auth['id']));
		
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
				// Ikomuniti dashboard
			    $this->view->ikomuniti_dir = $this->ikomuniti_dir();
			    
			    $this->view->register = 'http://ishare.com.my/daftar.html';
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
	
	private function get_user($id) {
	    $phql = "SELECT id, username ,name, email, postcode, telephone FROM JunMy\Models\Users WHERE id = :id: LIMIT 1";
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