<?php 

namespace JunMy\Frontend\Controllers;

use JunMy\Models\Users; 
use JunMy\Models\Companyproductorders;
use JunMy\Models\Transactions; 
use JunMy\Models\Notifications;

class PaymentController extends ControllerBase {
	
	public $paginationUrl; 
	
	public $salt_length = 9;
	
	public function initialize() {
		$this->tag->setTitle('Payment');
		parent::initialize();
	} 
	
	public function successAction() {
	    parent::pageProtect();
	    
	    // Get session in array
	    $auth = $this->session->get('jun_user_auth');
	    $this->view->setVar('navigations', $this->get_user($auth['id']));
	    if(!isset($_SESSION['IOPKN'])) {
			$this->flashSession->error('Not valid request.');
		    return $this->response->redirect('ioffer/index');
		} else {
			unset($_SESSION['IOPKN']);
		    unset($_SESSION['IOPKV']);
		    $this->session->remove('cart');
		}
		$this->flashSession->output();
	}
	
	public function iofferAction() {
		parent::pageProtect();
	    $this->flashSession->output(); 
	    $auth = $this->session->get('jun_user_auth');  
		$id = $this->dispatcher->getParam('id'); 
		if(!is_numeric($id)) {
			$this->flashSession->error('Not valid request E45.');
		    return $this->response->redirect('ioffer/index');
		} elseif(count($this->get_order($id, $auth['id'], 0)) == 0) {
			$this->flashSession->error('Not valid request E48.');
		    return $this->response->redirect('ioffer/index');
		} else {
			// Proceed update order
			$order = Companyproductorders::findFirst($id);
			$order->status = 1;
			$order->payment = 1;
			if($order->save()) {
				// Deduct ipoint
				if($this->deduct_wallet($auth['id'], $order->amount)) {
				    // Add transaction history
					if($this->transaction_history('IOP', $order->id, $auth['id'], $order->amount)) {
						if($this->notification($order->username)) {
							// Success and redirect to succcess payment
							// Deduct stock
							$this->deduct_stock($order->id); 
							$this->flashSession->success('Your payment has been successful, We will proceed your order within 24 (Working day).');
							return $this->response->redirect('payment/success');
						}
					}
				}
			}
		}
	}
	
	public function ipointAction() {
		parent::pageProtect();
	    $this->flashSession->output();
	    // Get session in array
	    $auth = $this->session->get('jun_user_auth'); 
	    $this->view->setVar('navigations', $this->get_user($auth['id']));
	    
	    // Proceed payment fron ioffer by iPoint
	    if($this->request->isPost()) {
	         
			if($this->request->getPost('submit') == 'Pay With iPoint') {
				// Validate session token toprevent CSRF attack
				if($this->request->getPost($_SESSION['IOPKN']) != $_SESSION['IOPKV']) {
					// Unset session and return to index
					unset($_SESSION['IOPKN']);
					unset($_SESSION['IOPKV']);
					$this->flashSession->error('Error IO52, Not valid request.');
					return $this->response->redirect('ioffer/index');
				} elseif($this->request->getPost('ord_totalamt') == 0) {
					// Unset session and return to index
					unset($_SESSION['IOPKN']);
					unset($_SESSION['IOPKV']);
					$this->flashSession->error('Error IO58, Not valid request.');
					return $this->response->redirect('ioffer/index');
				} elseif(!is_numeric($this->request->getPost('ord_mercref'))) {
					// Unset session and return to index
					unset($_SESSION['IOPKN']);
					unset($_SESSION['IOPKV']);
					$this->flashSession->error('Error IO64, Not valid request.');
					return $this->response->redirect('ioffer/index');
				} elseif(count($this->get_order($this->request->getPost('ord_mercref'), $auth['id'], 0)) == 0) {
					// Unset session and return to index
					unset($_SESSION['IOPKN']);
					unset($_SESSION['IOPKV']);
					$this->flashSession->error('Error IO70, Not valid request.');
					return $this->response->redirect('ioffer/index');
				} elseif($this->check_wallet($auth['id']) < $this->request->getPost('ord_totalamt')) {
					// Unset session and return to index because not enough balance
					unset($_SESSION['IOPKN']);
					unset($_SESSION['IOPKV']);
					$this->flashSession->error('You have not enough iPoint balance.');
					return $this->response->redirect('ioffer/index');
				} else {
				    $order_id = $this->request->getPost('ord_mercref');
				    $amount = $this->request->getPost('ord_totalamt');
				    $username = $this->request->getPost('ord_shipname');
					// Proceed payment, add history, deduct ipoint, admin notification
					// 1. Deduct iPoint balance
					if($this->deduct_wallet($auth['id'], $amount)) {
						// 2. Update payment table
						if($this->update_order($auth['id'], $order_id)) {
							// 3. Insert history
							if($this->transaction_history('IOP', $order_id, $auth['id'], $amount)) {
								if($this->notification($username)) {
									// Success and redirect to succcess payment
									// Deduct stock
									$this->deduct_stock($order_id);
									$this->flashSession->success('Your payment has been successful, We will proceed your order within 24 (Working day).');
									return $this->response->redirect('payment/success');
								}
							}
						}
					}
				}
			}
		}
	}
	
	/*
	*  Deduct stock qty after payment success
	*/
	private function deduct_stock($order_id) {
	    $order = Companyproductorders::findFirst("id = '$order_id' AND status = '1' AND payment = '1'");
	    
	    // Explode value into an array
	    $array_id = explode(',', $order->company_product_id);
	    $array_qty = explode(',', $order->total_product); 
	    
	    // Use array_combine to make assosiate array and prevent it return twice :-p
	    foreach(array_combine($array_id, $array_qty) as $id => $qty) { 
			$this->update_stock($id, $qty);
		} 
	}
	
	private function update_stock($id, $total) { 
		$phql = "UPDATE JunMy\Models\Companyproducts SET 
				stock = stock - '$total' WHERE id = :id:";
		$update = $this->modelsManager->executeQuery($phql, array('id' => $id));
		return $update;
	}
	
	/*
	*  Send notification to admin after success
	*/
    private function notification($username) {
		$note = new Notifications();
	    $note->user_id = 1;
	    $note->body = "$username has made purchase on iOffer.";
	    $note->created = date('Y-m-d H:i:s');
	    $note->read = 0;
	    $note->type = 11;
	    return $note->save();
	}
	
	private function update_order($user_id, $order_id) {
		 
		$phql = "UPDATE JunMy\Models\Companyproductorders SET 
				status = '1', payment = '1' WHERE id = :id: AND user_id = :user_id: AND payment_method = :method:";
		$update = $this->modelsManager->executeQuery($phql, array('id' => $order_id, 'user_id' => $user_id, 'method' => 1));
		return $update;
	}
	
	/*
	*  Add transaction history used on update and renew action
	*/
	private function transaction_history($ref, $order_id, $user_id, $amount) {
		$hist = new Transactions();
		$hist->user_id = $user_id;
		$hist->title = 'iOffer Purchase'; 
		$hist->amount = $amount;
		$hist->created = date('Y-m-d H:i:s'); 
		$hist->reference = $ref.$order_id.$user_id;
		$hist->type = 11; 
		$hist->pic = $user_id;
		// 1 RENEW, 2 BUY IMALL, 3 TRANSFER TO OTHER USER, 4 DONATE, 5 WITHDRAW, 6 COMMISSION, 7 ADD FUND, 8 DEDUCT SMS 0.20, 9 SELL ON IMALL, 10 RECEIVE FROM OTHER USER, 11 BUY COMPANY ITEMS, 12 BUY E PINS,
		return $hist->save();
	}
	
	/*
	*  Check ewallet balance, Used on renewAction. 
	*  Return BOOLEAN
	*/
	private function check_wallet($id) {
		$phql = "SELECT amount FROM JunMy\Models\Wallets 
		         WHERE user_id = '$id'";
		$rows = $this->modelsManager->executeQuery($phql);
		foreach($rows as $row) {
			return $row['amount'];
		}
	}
	
	/*
	*  Deduct after success renewal, used on renewAction
	*/
	private function deduct_wallet($id, $amount) {
		$phql = "UPDATE JunMy\Models\Wallets SET 
				amount = amount - '$amount' WHERE user_id = '$id'";
		$update = $this->modelsManager->executeQuery($phql);
		return $update;
	}
	
	/*
	*  Count table product order
	*/
	private function get_order($id, $user_id, $paid) {
	    $phql = "SELECT id FROM JunMy\Models\Companyproductorders WHERE id = :id: AND user_id = :user_id: AND payment = :payment: LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql, array('id' => $id, 'user_id' => $user_id, 'payment' => $paid)); 
		return $rows;
	}
	
	private function get_user($id) {
	    $phql = "SELECT id, username ,name, email, postcode, telephone FROM JunMy\Models\Users WHERE id = :id: LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql, array('id' => $id)); 
		return $rows;
	}
}