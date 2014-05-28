<?php

namespace JunMy\Admin\Controllers;

use JunMy\Models\Users;
use JunMy\Models\Wallets;
use JunMy\Models\Transactions;
use JunMy\Models\Manualpayments;
use JunMy\Components\Pagination\Pagination;

class WalletsController extends ControllerBase {
	
	public $wallet;
	
	public $salt_length = 9;
	
	public $paginationUrl;
	
	public function initialize() {
		$this->tag->setTitle('iPoint');
		parent::initialize();
	}
	
	public function indexAction() {
		parent::pageProtect(); 
		// Show form on volt
		//get user session
		$auth = $this->session->get('junauth');
		
		//set admin role
		$this->role($auth['role'], array(3, 6, 7));
		
		$this->view->hideform = 0;
		$hash = $this->passwordHash(date('YmdHis'));
		$this->view->hash = $hash;
		
		$this->view->setVar('navigations', $this->get_user($auth['id']));
		//$this->view->setVar('wallets', $this->get_wallet($_SESSION['jun_user_auth']['id']));
		$this->view->wallet = $this->get_wallet($auth ['id']);
		
		if(isset($_GET['submit']) && isset($_GET['username']) && isset($_GET['amount'])) {
		    
		    $amount = filter_input(INPUT_GET, 'amount', FILTER_SANITIZE_STRING); 
		    $username = filter_input(INPUT_GET, 'username', FILTER_SANITIZE_STRING); 
		    
			if(empty($amount)) {  
				$this->flash->error('Please enter amount');
			} elseif(!number_format($amount, 2)) {
				$this->flash->error('Not valid amount');
			} elseif(strlen($username)< 5 || strlen($username) > 32) {
				$this->flash->error('Username not valid');
			} elseif(count($this->get_username($username)) < 1) {
				$this->flash->error('Username not exist');
			} else {
			    $this->view->hideform = 1;
			    $users = Users::findFirst("username='$username'");
			    $wallet = Wallets::findfirst("user_id='$users->id'");
				// Retreive user profile for preview
				$this->flash->notice('Are you sure?');
				
				echo '<ul class="list-group"><form action="" method="get">'; 
				echo '<input type="hidden" name="ref" value="'.$hash.'">';
			    echo '<input type="hidden" name="status" value="'.$users->id.'">';
			    echo '<input type="hidden" name="nt" value="'.$amount.'">';
				echo '<li class="list-group-item"><p>Username:<span class="pull-right">'.$users->username.'</span></p></li>';
				echo '<li class="list-group-item"><p>Full Name:<span class="pull-right">'.$users->name.'</span></p></li>';
				echo '<li class="list-group-item"><p>Reg Number:<span class="pull-right">'.$users->reg_number.'</span></p></li>';
				echo '<li class="list-group-item"><p>Mobile Phone: <span class="pull-right">'.$users->telephone.'</span></p></li>';
				echo '<li class="list-group-item"><p>iPoint Balance: <span class="pull-right">RM'.$wallet->amount.'</span></p></li>';
				echo '<li class="list-group-item"><p>iPoint Amount: <span class="pull-right">RM'.number_format($amount, 2).'</span></p></li></ul>';
			    echo '<a href="index" class="btn btn-danger">Cancel</a>&nbsp;&nbsp;&nbsp;
				<span class="pull-right"><input type="submit" name="proceed" value="Proceed" class="btn btn-success"></span>';
				echo '</form>';
			}
		}
		
		$this->view->ajaxurl = $this->url->get('gghadmin/ajax/ajaxusername');
		
		if(isset($_GET['ref']) && isset($_GET['status']) && isset($_GET['nt']) && isset($_GET['proceed']) == 'Proceed') {
		
			$ref = $_GET['ref'];
			$to_user_id = $_GET['status'];
			$wallet_amount = $_GET['nt'];
			
			if(!is_numeric($to_user_id)) {
				$this->flash->error('Id tidak sah');
			} elseif(!is_numeric($wallet_amount)) {
				$this->flash->error('Amaun tidak sah');
			} elseif(strlen($ref) > 80) {
				$this->flash->error('Referal tidak sah');
			} else {
			    $wallet_amount = $wallet_amount;
			    
			    // Add to iWallet
				if($this->add_wallet($to_user_id, $wallet_amount)) {
					if($this->transaction_history('ADC', 'Credited By Administrator', $to_user_id, $wallet_amount, 13, $_SESSION['junauth']['id'])) {
						$this->flash->success('Transaksi telah berjaya');
					} else {
						$this->flash->error('ERROR TR895');
					}
				} else {
					$this->flash->error('ERROR W7895');
				}
			} 
		} 
	}

	
	public function deductAction() {
		parent::pageProtect();  
		//get user session
		$auth = $this->session->get('junauth'); 
		
		$this->flashSession->output();
		//set admin role
		$this->role($auth['role'], array(3, 6, 7));
		$this->view->setVar('navigations', $this->get_user($auth['id']));
		$this->view->ajaxurl = $this->url->get('ajax/ajaxusername');
		
		$this->view->wallet = $this->get_wallet($auth ['id']);
		$this->view->hideform = 0;
		$hash = $this->passwordHash(date('YmdHis'));
		$this->view->hash = $hash;
		if(isset($_GET['submit']) && isset($_GET['username']) && isset($_GET['amount'])) {
		    
		    $amount = filter_input(INPUT_GET, 'amount', FILTER_SANITIZE_STRING); 
		    $username = filter_input(INPUT_GET, 'username', FILTER_SANITIZE_STRING); 
		    
			if(empty($amount)) {  
				$this->flash->error('Please enter amount');
			} elseif(!number_format($amount, 2)) {
				$this->flash->error('Not valid amount');
			} elseif(strlen($username)< 5 || strlen($username) > 32) {
				$this->flash->error('Username not valid');
			} elseif(count($this->get_username($username)) < 1) {
				$this->flash->error('Username not exist');
			} else {
			    $this->view->hideform = 1;
			    $users = Users::findFirst("username='$username'");
			    $wallet = Wallets::findfirst("user_id='$users->id'");
				// Retreive user profile for preview
				if($wallet->amount < $amount) {
					$this->flash->error($username.' not enough iPoint balance to deduct.');
				} else {
					$this->flash->notice('Are you sure?');
					
					echo '<ul class="list-group"><form action="" method="get">'; 
					echo '<input type="hidden" name="ref" value="'.$hash.'">';
				    echo '<input type="hidden" name="status" value="'.$users->id.'">';
				    echo '<input type="hidden" name="nt" value="'.$amount.'">';
					echo '<li class="list-group-item"><p>Username:'.$users->username.'</p></li>';
					echo '<li class="list-group-item"><p>Full Name: '.$users->name.'</p></li>';
					echo '<li class="list-group-item"><p>Reg Number: '.$users->reg_number.'</p></li>';
					echo '<li class="list-group-item"><p>Phone: '.$users->telephone.'</p></li>';
					echo '<li class="list-group-item"><p>iPoint Balance: RM'.$wallet->amount.'</p></li>';
					echo '<li class="list-group-item"><p>Deduct Amount RM'.number_format($amount, 2).'</p></li></ul>';
				    echo '<p>&nbsp;</p><input type="submit" name="proceed" value="Cancel" class="btn btn-danger"> 
					<input type="submit" name="proceed" value="Proceed" class="btn btn-success">';
					echo '</form>';	
				}
				
			}
		}
		
		$this->view->ajaxurl = $this->url->get('ajax/ajaxusername');
		
		if(isset($_GET['ref']) && isset($_GET['status']) && isset($_GET['nt']) && isset($_GET['proceed']) == 'Proceed') {
		
			$ref = $_GET['ref'];
			$to_user_id = $_GET['status'];
			$wallet_amount = $_GET['nt'];
			
			if(!is_numeric($to_user_id)) {
				$this->flash->error('Not valid user id, Please try again.');
			} elseif(!is_numeric($wallet_amount)) {
				$this->flash->error('Not valid amount, Please try again.');
			} elseif(strlen($ref) > 80) {
				$this->flash->error('Error, Not valid referral.');
			} else {
			    $wallet_amount = $wallet_amount; 
			    // deduct ipoint
				if($this->deduct_wallet($to_user_id, $wallet_amount)) {
					if($this->transaction_history('DBA', 'Deduct By Administrator', $to_user_id, $wallet_amount, 14, $auth['id'])) {
						$this->flashSession->success('Wallet has been deducted.');
						return $this->response->redirect('gghadmin/wallets/deduct');
					} else {
						$this->flash->error('ERROR DD895');
					}
				} else {
					$this->flash->error('ERROR WD7895');
				}
			} 
		} 
	}
		
	public function adminAction() {
		parent::pageProtect();  
		//get user session
		$auth = $this->session->get('junauth'); 
		//set admin role
		$this->role($auth['role'], array(3, 6, 7));
		$this->flashSession->output();
		if(isset($_GET['id'])) {
			$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
			$del = Manualpayments::findFirst("id = '$id' AND status ='0'"); 
			$del->status = 1;
			if($del->save()) {
				$this->flashSession->success('Payment request has been delete.');
				return $this->response->redirect('gghadmin/wallets/admin');
			} 
		}
		
		$this->view->setVar('navigations', $this->get_user($auth['id']));
		
		$this->view->setVar('requests', $this->topup_request());
		
		$this->view->paginationUrl = $this->paginationUrl;
	}
	
	private function topup_request() {
		$records_per_page = 30;
	    $paginations = new Pagination();
        $paginate = (($paginations->get_page() - 1) * $records_per_page);
		$phql = "SELECT
		    m.id AS mid, m.amount AS amount, m.payment_date AS date, m.payment_time AS time, m.remark AS remark, 
			m.created AS created, m.status AS status, m.from_acc AS from_acc,
			u.username AS username
			FROM JunMy\Models\Manualpayments AS m
			LEFT JOIN JunMy\Models\Users AS u ON(u.id = m.user_id)
			WHERE u.status = '0' ORDER BY m.id DESC";
		$count = $this->modelsManager->executeQuery($phql);	
        $paginations->records(count($count));
        $rows = $this->modelsManager->executeQuery($phql." LIMIT $paginate , $records_per_page");	
        // records per page
        $paginations->records_per_page($records_per_page);
		$this->paginationUrl = $paginations->render();

		return $rows;
	}
	
	public function viewAction() {
		parent::pageProtect();  
		//get user session
		$auth = $this->session->get('junauth'); 
		//set admin role
		$this->role($auth['role'], array(3, 6, 7));
		$this->view->setVar('navigations', $this->get_user($auth['id']));
		$this->view->ajaxurl = $this->url->get('ajax/ajaxusername');
		
		if(isset($_GET['username']) && isset($_GET['submit']) == 'View') {
		    $this->view->view_hist = 1;
			$username = filter_input(INPUT_GET, 'username', FILTER_SANITIZE_STRING);
			$this->view->setVar('hists', $this->get_history($username));
			$this->view->setVar('wallets', $this->wallet_balance($username));
			$this->view->paginationUrl = $this->paginationUrl;
		} else {
			$this->view->view_hist = 0;
		}
	}
	
	/*
	*  View user transaction history
	*/
	private function wallet_balance($username) {
		$phql = "SELECT u.id AS u_id, w.amount AS amount 
		         FROM JunMy\Models\Users AS u
				 INNER JOIN JunMy\Models\Wallets AS w ON(w.user_id = u.id)
				 WHERE u.username = :username: LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql, array('username' => $username));
		return $rows;
	}
	/*
	*  View user transaction history
	*/
	private function get_history($username) {
		$records_per_page = 30;
	    $paginations = new Pagination();
        $paginate = (($paginations->get_page() - 1) * $records_per_page);
		$phql = "SELECT
		    u.id AS user_id,  
			t.title AS title,
			t.amount AS amount,
			t.created AS created,
			t.reference AS ref,
			t.type AS type, 
			p.username AS pic_username
			FROM JunMy\Models\Transactions AS t
			INNER JOIN JunMy\Models\Users AS u ON(u.id = t.user_id)
			LEFT JOIN JunMy\Models\Users AS p ON(p.id = t.pic)
			WHERE u.username = '$username' ORDER BY t.created DESC";
		$count = $this->modelsManager->executeQuery($phql);	
        $paginations->records(count($count));
        $rows = $this->modelsManager->executeQuery($phql." LIMIT $paginate , $records_per_page");	
        // records per page
        $paginations->records_per_page($records_per_page);
		$this->paginationUrl = $paginations->render();

		return $rows;
	}
 
	
	/*
	*  Add iWallet, used on renewAction
	*/
	private function add_wallet($user_id, $amount) {
		$phql = "UPDATE JunMy\Models\Wallets SET 
				amount = amount + '$amount' WHERE user_id = '$user_id'";
		$update = $this->modelsManager->executeQuery($phql);
		if($update) {
		    return true;
		} else {
			return false;
		}
	}
	
	/*
	*  Deduct iWallet, deduct for some reason
	*/
	private function deduct_wallet($user_id, $amount) {
		$phql = "UPDATE JunMy\Models\Wallets SET 
				amount = amount - '$amount' WHERE user_id = '$user_id'";
		$update = $this->modelsManager->executeQuery($phql);
		if($update) {
		    return true;
		} else {
			return false;
		}
	}
	
	/*
	*  Add transaction history used on update and renew action
	*/
	private function transaction_history($ref, $title, $user_id, $amount, $type, $pic) {
		$hist = new Transactions();
		$hist->user_id = $user_id;
		$hist->title = $title; 
		$hist->amount = $amount;
		$hist->created = date('Y-m-d H:i:s'); 
		$hist->reference = $ref.date('YmdHis').$user_id;
		$hist->type = $type;
		$hist->pic = $pic; // 1 RENEW, 2 BUY IMALL, 3 TRANSFER TO OTHER USER, 4 DONATE, 5 WITHDRAW, 6 COMMISSION, 7 ADD FUND, 8 DEDUCT SMS 0.20, 9 SELL ON IMALL, 10 RECEIVE FROM OTHER USER, 11 BUY COMPANY ITEMS, 12 BUY E PINS, 13 ADMIN CREDIT
		return $hist->save();
	}
	
	private function passwordHash($pwd, $salt = null) {
        if ($salt === null)     {
            $salt = substr(md5(uniqid(rand(), true)), 0, $this->salt_length);
        } else {
            $salt = substr($salt, 0, $this->salt_length);
        }
        return $salt . sha1($pwd . $salt);
    }
	
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
	
	public function addAction() {
		if(!$this->session->get('junauth')) {
	        $this->flash->error('Please login to access members area');
			return $this->response->redirect('users/login');
		} else {
			session_regenerate_id();
			
			$offset = mt_rand(0, 958695);
			$key = 'transfer_wallet'.$offset;
			$exists = $this->view->getCache()->exists($key);
			if (!$exists) {
			    $this->view->setVar('users', $this->get_user($_SESSION['junauth']['id']));
				if($this->request->isGet()) {
					
					if(number_format($this->request->get('add_amount'), 2)) {
					    if($this->request->get('type') == 'manual') {
							// Do form aproval here
							$ord_delcharges = 0;
						} elseif($this->request->get('type') == 'auto') {
							// Do form aproval here
							$ord_delcharges = ($this->request->get('add_amount') / 100) * 2.5;
						} elseif($this->request->get('type') == 'cc') {
							// Do form aproval here
							
							$ord_delcharges = ($this->request->get('add_amount') / 100) * 4;
							
						} else {
						    $this->flash->error('Please select valid Payment Type');
							return $this->response->redirect('wallets/index');
						}
						$ord_mercref = rand(9098762356062, 1235450984694590);
						 
						$total = $this->request->get('add_amount') + $ord_delcharges;
						echo '<label><h4>Amount RM<b>'.number_format($total, 2).'</b></h4><form action="https://webcash.com.my/wcgatewayinit.php" method="post"> 
		                <input type="hidden" name="ord_date" value="'.date('Y-m-d H:i:s').'"> 
		                <input type="hidden" name="ord_totalamt" value="'.number_format($total, 2).'"/>
		                <input type="hidden" name="ord_shipname" value="'.$_SESSION['jun_user_auth']['id'].'">
		                <input type="hidden" name="ord_shipcountry" value="Malaysia"> 
		                <input type="hidden" name="ord_mercref" value="'.$_SESSION['jun_user_auth']['id'].'1610'.time().'"> 
		                <input type="hidden" name="ord_telephone" value="60122865228"> 
		                <input type="hidden" name="ord_email" value="'.$_SESSION['jun_user_auth']['name'].'@ishare.com.my"> 
		                <input type="hidden" name="ord_delcharges" value="0.00"> 
		                <input type="hidden" name="ord_svccharges" value="0.00"> 
		                <input type="hidden" name="ord_mercID" value="80000706">
		                <input type="hidden" name="ord_returnURL" value="http://ishare.com.my"> 
		                <input type="submit" name="submit" value="Pay with Webcash">
		                </form></label>';
					} else {
					    $this->flash->error('Please valid Amount');
						return $this->response->redirect('wallets/index');
					}
				}
				
			}
			
			$this->view->cache(array("key" => $key));
		}
	}
	
	private function get_user($id) {
	    $phql = "SELECT * FROM JunMy\Models\Users WHERE id = '$id' LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql);
		//$this->view->since = date('j F, Y', strtotime($rows['users']['created']));
		
		return $rows;
	}
	
	private function get_username($username) {
	    $phql = "SELECT * FROM JunMy\Models\Users WHERE username = '$username' LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql);
		//$this->view->since = date('j F, Y', strtotime($rows['users']['created']));
		
		return $rows;
	}
	
	private function get_wallet($id) {
	    $phql = "SELECT amount FROM JunMy\Models\Wallets WHERE user_id = '$id' LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql);
		//$this->view->since = date('j F, Y', strtotime($rows['users']['created']));
		foreach($rows as $row) {
			return number_format($row['amount'], 2);
		}
	
	}
	

	
	
}