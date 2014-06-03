<?php

namespace JunMy\Frontend\Controllers;

use JunMy\Models\Users;
use JunMy\Models\Withdrawals;
use JunMy\Models\Wallets;
use JunMy\Models\Wallettransferrequest;
use JunMy\Models\Transactions;
use JunMy\Models\Manualpayments;
use JunMy\Models\Notifications;

use JunMy\Components\Pagination\Pagination;

class WalletsController extends ControllerBase {
 
	public $salt_length = 9;
	
	public $wallet, $paginationUrl;
	
	public function initialize() {
		$this->tag->setTitle('iWallet Managements');
		parent::initialize();
	}
	
	public function indexAction() {
		parent::pageProtect(); 
		
		$auth = $this->session->get('jun_user_auth');
		$this->flashSession->output();
		
		if($this->request->isPost()) {
		    if($this->request->getPost('token') != $_SESSION['IPTOPADD']) {
				$this->flash->error('Invalid token. Request aborted.');
			} elseif(!$this->isValidDate($this->request->getPost('payment_date'))) {
				$this->flash->error('Please enter valid date format');
			} elseif($this->request->getPost('payment_time') == '') {
				$this->flash->error('Please enter payment time');
			} elseif(!is_numeric($this->request->getPost('amount'))) {
				$this->flash->error('Please enter valid amount');
			} else {
				$paid = new Manualpayments();
				$paid->user_id = $auth['id']; 
				$paid->amount = $this->request->getPost('amount'); 
				$paid->payment_date = $this->request->getPost('payment_date'); 
				$paid->payment_time = $this->request->getPost('payment_time'); 
				$paid->remark = $this->request->getPost('remark'); 
				$paid->created = date('Y-m-d H:i:s'); 
				$paid->status = 0;
				$paid->from_acc = $this->request->getPost('from_acc'); 
				if($paid->save()) {
				    if($this->update_notification($auth['username'], $this->request->getPost('amount'), 538)) {
				        $this->update_notification($auth['username'], $this->request->getPost('amount'), 165);
				        $this->update_notification($auth['username'], $this->request->getPost('amount'), 8);
						unset($_SESSION['IPTOPADD']);
						$this->flashSession->success('Your payment request has been saved. Please wait our staff to verify this transaction.');
						return $this->response->redirect('wallets/index');	
					}
				    
				}
			} 
		}
	
		
		$this->flashSession->output();	
		$offset = mt_rand(0, 958695);
		$key = 'wallet_index_'.$auth['id'].'_'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) {
		    
			$this->view->setVar('users', $this->get_user($auth['id']));
			$this->view->setVar('navigations', $this->get_user($auth['id']));
			$this->view->wallet = $this->get_wallet($auth['id']);
			
		}
		if(isset($_GET['amount'])) {
		    $amount = $_GET['amount'];
			if(is_numeric($amount)) {
				$amt = $amount;
			} else {
				$amt = '';
			}
		} else {
			$amt = '';
		}
		$this->view->amount = $amt;
		$this->view->cache(array("key" => $key));
	    $_SESSION['IPTOPADD'] = $this->passwordHash(date('YmdHis'));
	    $this->view->token = $_SESSION['IPTOPADD'];
	}
	
	/*
	*  Send notification after UPDATEw, used on updateAction
	*/
	private function update_notification($username, $amount, $id) {
		//Send SMS	& notification
	    $note = new Notifications();
	    $note->user_id = $id; // Miza
	    $note->body = "$username has bank in RM$amount to GGHSB. Please review this request on iAccount > iPoint > Request. URGENT!";
	    $note->created = date('Y-m-d H:i:s');
	    $note->read = 0;
	    $note->type = 17;
	    return $note->save();
	}
	
	public function addAction() {
		/*parent::pageProtect(); 
		$auth = $this->session->get('jun_user_auth');
			
		$offset = mt_rand(0, 958695);
		$key = 'wallet_add_'.$auth['id'].'_'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) {
		    $this->view->setVar('navigations', $this->get_user($auth['id']));
		}
		
		$this->view->cache(array("key" => $key));
		
		if($this->request->isGet()) {
			
			if(number_format($this->request->get('add_amount'), 2)) {
			    if($this->request->get('type') == 'manual') {
					// Do form aproval here
					$method = 1;
					$ord_delcharges = 0;
				} elseif($this->request->get('type') == 'auto') {
					// Do form aproval here
					$method = 2;
					$ord_delcharges = ($this->request->get('add_amount') / 100) * 2.5;
				} elseif($this->request->get('type') == 'cc') {
					// Do form aproval here
					$method = 2;
					$ord_delcharges = ($this->request->get('add_amount') / 100) * 4;
					
				} else {
				    $this->flash->error('Please select valid Payment Type');
					return $this->response->redirect('wallets/index');
				}
				$ord_mercref = rand(9098762356062, 1235450984694590);
				 
				$total = $this->request->get('add_amount') + $ord_delcharges;
				
				if($method == 1) {
					echo '';
				} else {
				    $_SESSION['IPTOPADD'] = $this->passwordHash(date('YmdHis'));
					echo '<label><h4>Amount RM<b>'.number_format($total, 2).'</b></h4><form action="https://webcash.com.my/wcgatewayinit.php" method="post"> 
	                <input type="hidden" name="ord_date" value="'.date('Y-m-d H:i:s').'"> 
	                <input type="hidden" name="ord_totalamt" value="'.number_format($total, 2).'"/>
	                <input type="hidden" name="ord_shipname" value="'.$auth['id'].'">
	                <input type="hidden" name="ord_shipcountry" value="Malaysia"> 
	                <input type="hidden" name="ord_mercref" value="'.$auth['id'].'1610'.time().'"> 
	                <input type="hidden" name="ord_telephone" value="60122865228"> 
	                <input type="hidden" name="ord_email" value="'.$auth['username'].'@ishare.com.my"> 
	                <input type="hidden" name="ord_delcharges" value="0.00"> 
	                <input type="hidden" name="ord_svccharges" value="0.00"> 
	                <input type="hidden" name="ord_mercID" value="80000706">
	                <input type="hidden" name="ord_returnURL" value="'.$this->host().'ipoint/index?id='.$auth['id'].'&key='.$_SESSION['IPTOPADD'].'"> 
	                <input type="submit" name="submit" value="Pay with Webcash" class="btn btn-primary">
	                </form></label>';	
				}
				
				
			} else {
			    $this->flash->error('Please valid Amount');
				return $this->response->redirect('wallets/index');
			}
		} */
	}
	
	public function historiesAction() {
		parent::pageProtect(); 
		$auth = $this->session->get('jun_user_auth');
			
		$offset = mt_rand(0, 95897695);
		$key = 'wallet_history_'.$auth['id'].'_'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) { 
		    $this->view->setVar('navigations', $this->get_user($auth['id']));
		    $this->view->setVar('views', $this->view_histories($auth['id']));
		    $this->view->paginationUrl = $this->paginationUrl;
		}
		
		$this->view->cache(array("key" => $key));
	}
	
	public function transferAction() {
		parent::pageProtect(); 
		$this->flashSession->output();
		$auth = $this->session->get('jun_user_auth');
		$this->role($auth['role'], array(4, 5, 6, 7, 8, 9));
		$this->view->setVar('navigations', $this->get_user($auth['id'])); 
		if($this->request->isPost()) {
			if(strlen($this->request->getPost('recipient_username')) < 5 || strlen($this->request->getPost('recipient_username')) > 18) {
				$this->flash->error('Recipient Username too short or too long.');
			} elseif(!ctype_alnum($this->request->getPost('recipient_username'))) {
				$this->flash->error('Error, Not valid Recipient Username.');
			} elseif(count($this->get_recipient($this->request->getPost('recipient_username'))) < 1) {
				$this->flash->error('iKomuniti not found.');
			} elseif(strlen($this->request->getPost('remark')) > 24) {
				$this->flash->error('Error, Remark too long. Maximum 24 character.');
			} elseif(strlen($this->request->getPost('password')) < 5 || strlen($this->request->getPost('password')) > 18) {
				$this->flash->error('Please enter your Valid Password');
			} elseif(strlen($this->request->getPost('transaction_password')) < 5 || strlen($this->request->getPost('transaction_password')) > 18) {
				$this->flash->error('Please enter Valid Transaction Password');
			} elseif($this->request->getPost('DB8R4HAW4XB7Y8LMP6') == '') {
				$this->flash->error('Ops... Something goin wrong. Please try again later.');
			} elseif($this->request->getPost('DB8R4HAW4XB7Y8LMP6') != $_SESSION['T5FK2Z3JAW4XB7Y8LMP6']) {
				$this->flash->error('Ops... Something goin wrong. Please try again later.');
			} else {
			    $recipient_username = $this->request->getPost('recipient_username');
			    $password = $this->request->getPost('password');
				$master_key = $this->request->getPost('transaction_password');
				$amount = $this->request->getPost('amount');
				$remark = $this->request->getPost('remark');
				// Second validate, Check balance
				$balance = Wallets::findFirst($auth['id']);
				$wallet_balance = $balance->amount - 0.20;
				if($wallet_balance < $amount) {
					$this->flash->error('Insufficient iPoint balance.');
				} else {
				    // Third validation for password
					$user = Users::findFirst($auth['id']);
					if($user->password == md5($password)) {
						if($user->master_key == $master_key) {
						    $generate = $this->generate($length = 6);
							// Proceed
							$trans = new Wallettransferrequest();
							$trans->user_id = $auth['id'];
							$trans->recipient_username = $recipient_username;
							$trans->amount = $amount; 
							$trans->sms_code = $generate; 
							$trans->remark = $remark; 
							$trans->created = date('Y-m-d H:i:s'); 
							$trans->type = 1; // 1 transfer, 2 buy imall; 
							$trans->status = 0; // 0 pending approval;
							if($trans->save()) {
							    $this->send_sms($auth['id'], $generate, $recipient_username);
								$this->session->set('xlcdrcp', array(
						            'mquist' => $trans->id,
									'rcp' => $recipient_username,
									'ams' => $amount,
									'gxst' => time()
						        ));
						        unset($_SESSION['T5FK2Z3JAW4XB7Y8LMP6']);
								return $this->response->redirect('wallets/steptwo');
							} else {
								$this->flash->error('Ops!. Something going wrong, please try again later.');
							}
						} else {
							$this->flash->error('Your Transaction Password not match');
						}
					} else {
						$this->flash->error('Your Password not match');
					} 	
				} 
			}
		} else {
			// If not submit, set token to prevent CSRF Attack
			$_SESSION['T5FK2Z3JAW4XB7Y8LMP6'] = $this->passwordHash($this->generate());
		}
		
		$this->view->csrfToken = $_SESSION['T5FK2Z3JAW4XB7Y8LMP6'];
	}
	 
	
	// 1 RENEW, 2 BUY IMALL, 3 TRANSFER TO OTHER USER, 4 DONATE, 5 WITHDRAW, 6 COMMISSION, 7 ADD FUND, 8 DEDUCT SMS 0.20, 9 SELL ON IMALL, 10 RECEIVE FROM OTHER USER, 11 BUY COMPANY ITEMS, 12 BUY E PINS, 13 
	public function steptwoAction() {
		parent::pageProtect(); 
		$auth = $this->session->get('jun_user_auth');
		$token = $this->session->get('xlcdrcp');
		$this->view->setVar('navigations', $this->get_user($auth['id']));
		
		// If not empty session transfer 
		if($token['mquist'] != '') {
			$this->view->setVar('recipients', $this->get_recipient($token['rcp']));
			$this->view->amount = number_format($token['ams'], 2);
			if($this->request->isPost()) {
			    // Cancel and deduct for sms
				if($this->request->getPost('submit') == 'Cancel') {
					if($this->deduct_wallet($auth['id'], 0.20)) {
						$this->session->remove('xlcdrcp');
				        $this->flashSession->success('Your transaction has been canceled.');
						return $this->response->redirect('wallets/transfer');	
					}
					
				} elseif($this->request->getPost('submit') == 'Submit') {
				    // Error and deduct for sms
					if(!is_numeric($this->request->getPost('tac'))) {
						if($this->deduct_wallet($auth['id'], 0.20)) {
							$this->session->remove('xlcdrcp');
							$this->transaction_history($auth['id'], 'SMS Transfer Charge', 0.20, 3, 'STC'.date('YmdHis').$auth['id']);
					        $this->flashSession->error('Your transaction has been canceled, Not valid TAC.');
							return $this->response->redirect('wallets/transfer');
						}
					} elseif(strlen($this->request->getPost('tac')) < 6 || strlen($this->request->getPost('tac')) > 6) {
						if($this->deduct_wallet($auth['id'], 0.20)) {
							$this->session->remove('xlcdrcp');
							$this->transaction_history($auth['id'], 'SMS Transfer Charge', 0.20, 3, 'STC'.date('YmdHis').$auth['id']);
					        $this->flashSession->error('Your transaction has been canceled, Not valid TAC.');
							return $this->response->redirect('wallets/transfer');
						}
					} else {
						$phql = "SELECT
						    w.amount AS amount, w.sms_code AS sms_code, w.recipient_username AS recipient_username,
						    u.id AS uid
							FROM JunMy\Models\Wallettransferrequest AS w
							INNER JOIN JunMy\Models\Users AS u ON(u.username = w.recipient_username)
							WHERE w.user_id = :user_id: AND w.id = :id:
							ORDER BY w.id ASC LIMIT 1";
						$rows = $this->modelsManager->executeQuery($phql, array('user_id' => $auth['id'], 'id' => $token['mquist']));	
						foreach($rows as $row) {
						    if($this->request->getPost('tac') == $row['sms_code']) {
						        // Deduct wallet 
								if($this->deduct_wallet($auth['id'], $row['amount'])) {
								$this->transaction_history($auth['id'], 'Transfer to '.$row['recipient_username'], $row['amount'], 3, 'WTR'.date('YmdHis').$auth['id']);
								$this->add_wallet($row['uid'], $row['amount']);
								$this->transaction_history($row['uid'], 'Receive from '.$auth['username'], $row['amount'], 3, 'WTR'.date('YmdHis').$auth['id']);
								
								// Deduct SMS caj for sender
								$this->deduct_wallet($auth['id'], 0.20);
								$this->transaction_history($auth['id'], 'Transfer Caj ', 0.20, 3, 'STC'.date('YmdHis').$auth['id']);
								
								$this->session->remove('xlcdrcp');
						        $this->flashSession->success('Your transaction has been success.');
								return $this->response->redirect('wallets/transfer');	
								} else {
									$this->flashSession->error('Insufficient iPoint balance. Your transaction has been canceled.');
								    return $this->response->redirect('wallets/transfer');
								}
								
								
							} else {
								$this->flash->error('TAC not match, please try again.');
							}	
						}
					}
				}
			}
		} else {
			$this->flashSession->error('Error! Invalid token.');
			return $this->response->redirect('wallets/transfer');
		}
	}
	
	private function deduct_wallet($user_id, $amount) {
		$wallet = Wallets::findFirst($user_id);
		$total = $amount + 0.20;
		
		if($wallet->amount >= $total) {
			$wallet->amount -= $amount; 
			return $wallet->save();	
		} else {
			return false;
		}
		
	}
	
	private function add_wallet($user_id, $amount) {
		$wallet = Wallets::findFirst($user_id);
		$deduct = $wallet->amount + $amount;
		$wallet->amount = $deduct;
		return $wallet->save();
	}

    private function transaction_history($user_id, $title, $amount, $type, $ref) {
		$trans = new Transactions();
		$trans->user_id = $user_id;
		$trans->title = $title;
		$trans->amount = $amount;
		$trans->created = date('Y-m-d H:i:s');
		$trans->reference = $ref;
		$trans->type = $type;
		$trans->pic = $user_id;
		return $trans->save();
	}
	
	public function statusAction() {
		parent::pageProtect(); 
		$auth = $this->session->get('jun_user_auth');
		$this->role($auth['role'], array(1, 2, 3, 4, 5, 6, 7, 8));
		$offset = mt_rand(0, 95897695);
		$key = 'wallet_redeem_'.$auth['id'].'_'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) { 
		    $this->view->setVar('navigations', $this->get_user($auth['id']));  
		}
		$this->view->cache(array("key" => $key));
		$this->view->setVar('status', $this->withdrawal_status($auth['id']));
		$this->view->paginationUrl = $this->paginationUrl;
	}
	
	public function redeemAction() {
		parent::pageProtect(); 
		$this->flashSession->output();
		// Secure from csrf
		$this->view->token_value = $this->security->getToken();
		$this->view->token_name = $this->security->getTokenKey(); 
		
		$auth = $this->session->get('jun_user_auth');
		$this->role($auth['role'], array(1, 2, 3, 4, 5, 6, 7, 8));
			
		$offset = mt_rand(0, 95897695);
		$key = 'wallet_redeem_'.$auth['id'].'_'.$offset;
		$exists = $this->view->getCache()->exists($key);
		if (!$exists) { 
		    $this->view->setVar('navigations', $this->get_user($auth['id'])); 
		    $this->view->setVar('users', $this->get_user($auth['id']));
		}
		$this->view->cache(array("key" => $key));
		if($this->request->isPost()) {
		    // Check token first
			echo $_SESSION['T5FK2Z3JAW4XB7Y8LMP6'] . '=' .$this->request->getPost('DB8R4HAW4XB7Y8LMP6');
			if(strlen($this->request->getPost('bank_name')) < 4 || strlen($this->request->getPost('bank_name')) > 32) {
				$this->flash->error('Please enter valid Bank Name');
			} elseif(strlen($this->request->getPost('account_number')) < 6 || strlen($this->request->getPost('account_number')) > 18) {
				$this->flash->error('Please enter valid Account Number');
			} elseif(!is_numeric($this->request->getPost('account_number'))) {
				$this->flash->error('Please enter valid Account Number (0-9)');
			} elseif($this->request->getPost('amount') < 50) {
				$this->flash->error('Minimum withdrawal is 50 iPoint');
			} elseif(!is_numeric($this->request->getPost('amount'))) {
				$this->flash->error('Please enter valid iPoint');
			} elseif(strlen($this->request->getPost('password')) < 5 || strlen($this->request->getPost('password')) > 18) {
				$this->flash->error('Please enter your Valid Password');
			} elseif(strlen($this->request->getPost('transaction_password')) < 5 || strlen($this->request->getPost('transaction_password')) > 18) {
				$this->flash->error('Please enter Valid Transaction Password');
			} elseif($this->request->getPost('DB8R4HAW4XB7Y8LMP6') == '') {
				$this->flash->error('Ops... Something goin wrong. Please try again later.');
			} elseif($this->request->getPost('DB8R4HAW4XB7Y8LMP6') != $_SESSION['T5FK2Z3JAW4XB7Y8LMP6']) {
				$this->flash->error('Ops... Something goin wrong. Please try again later.');
			} else {
			    
				$password = $this->request->getPost('password');
				$master_key = $this->request->getPost('transaction_password');
				$amount = $this->request->getPost('amount');
				// Second validate, Check balance
				$balance = Wallets::findFirst($auth['id']);
				if($balance->amount < $amount) {
					$this->flash->error('Insufficient iPoint balance.');
				} else {
				    // Third validation for password
					$user = Users::findFirst($auth['id']);
					if($user->password === $this->passwordHash($password,substr($user->password, 0, 9))) {
						if($user->master_key == $master_key) {
							// Proceed
							$redeem = new Withdrawals();
							$redeem->user_id = $auth['id'];
							$redeem->bank = $this->request->getPost('bank_name');
							$redeem->account = $this->request->getPost('account_number');
							$redeem->created = date('Y-m-d H:i:s');
							$redeem->ip_address = $this->get_ip();
							$redeem->status = 0;
							$redeem->amount = number_format($this->request->getPost('amount'));
							if($redeem->save()) {
							    unset($_SESSION['T5FK2Z3JAW4XB7Y8LMP6']);
								$this->flashSession->success('Your request has been save, please wait approval from administrator');
							    return $this->response->redirect('wallets/redeem');
							} else {
								$this->flash->error('Your Transaction Password not match');
							}
						} else {
							$this->flash->error('Your Transaction Password not match');
						}
					} else {
						$this->flash->error('Your Password not match');
					} 	
				}
				
				
					
			}
		 
		} else {
			// If not submit, set token to prevent CSRF Attack
			$_SESSION['T5FK2Z3JAW4XB7Y8LMP6'] = $this->passwordHash($this->generate());
		}
		
		$this->view->csrfToken = $_SESSION['T5FK2Z3JAW4XB7Y8LMP6'];
	}
	
	public function get_ip() {
		$ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
 
        return $ipaddress;
	} 
	
	private function get_recipient($username) {
		$phql = "SELECT
		    id, username, name, telephone, email, reg_number 
			FROM JunMy\Models\Users 
			WHERE username = '$username' AND role > '3'
			LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql);	
		return $rows;
	}

	private function send_sms($user_id, $tac, $username) {
	    $user = Users::findFirst($user_id);
	    $sms_username = "ishare.com.my";
        $sms_password = "rahsiajun.228";
		$sms_dstno = $user->telephone;
        $sms_msg = 'iPoint transfer to '.$username.' TAC Id: '.$tac.'. Not made any transfer? Call 03 8922 2277. TQ';

        $sms_type = 1;
        $sms_senderid = 1;
        $sms_sendlink = "http://www.isms.com.my/isms_send.php?un=".urlencode($sms_username)."&pwd=".urlencode($sms_password)."&dstno=".$sms_dstno."&msg=".urlencode($sms_msg)."&type=".$sms_type."&sendid=".$sms_senderid; 
        fopen($sms_sendlink, "r");
	}
	
	private function view_histories($id) {
		
	    $records_per_page = 30;
	    $paginations = new Pagination();
        $paginate = (($paginations->get_page() - 1) * $records_per_page);
		$phql = "SELECT
		    id, user_id, title, amount, DATE_FORMAT(created,'%d %b %Y %h:%i %p') AS created, reference, type 
			FROM JunMy\Models\Transactions 
			WHERE user_id = :id: ".$this->search_option()."
			ORDER BY DATE(created) DESC";
		$count = $this->modelsManager->executeQuery($phql, array('id' => $id));	
        $paginations->records(count($count));
        $rows = $this->modelsManager->executeQuery($phql." LIMIT $paginate , $records_per_page", array('id' => $id));	
        // records per page
        $paginations->records_per_page($records_per_page);
		$this->paginationUrl = $paginations->render();

		return $rows;
	
	}
	
	/*
	*  Search option for phql date
	*  Return STRING
	*/	
	private function search_option() {
		if(isset($_GET['date_from']) && isset($_GET['date_to'])) {
		    $start = $_GET['date_from'];
		    $end = $_GET['date_to'];
			if($this->isValidDate($start) && $this->isValidDate($end)) {
		    	return " AND created >= '$start' AND created <= '$end'"; 
			} 
		}
	}
	
	private function isValidDate($date) {
		if(preg_match("/^(\d{4})-(\d{2})-(\d{2})$/", $date, $matches)) {
			if(checkdate($matches[2], $matches[3], $matches[1])) {
				return true;
			}
		}
	}
	
	private function withdrawal_status($id) {
		
	    $records_per_page = 30;
	    $paginations = new Pagination();
        $paginate = (($paginations->get_page() - 1) * $records_per_page);
		$phql = "SELECT
		    bank, account, amount, DATE_FORMAT(created,'%d %b %Y %h:%i %p') AS created, status, reason
			FROM JunMy\Models\Withdrawals 
			WHERE user_id = '$id'
			ORDER BY id DESC";
		$count = $this->modelsManager->executeQuery($phql);	
        $paginations->records(count($count));
        $rows = $this->modelsManager->executeQuery($phql." LIMIT $paginate , $records_per_page");	
        // records per page
        $paginations->records_per_page($records_per_page);
		$this->paginationUrl = $paginations->render();

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
	
	private function get_user($id) {
	    $phql = "SELECT * FROM JunMy\Models\Users WHERE id = '$id' LIMIT 1";
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
	
	private function generate($length = 6) {
		$password = "";
		$possible = "1234567890";  
		$i = 0; 
		while ($i < $length) { 
			$char = substr($possible, mt_rand(0, strlen($possible)-1), 1); 
			if (!strstr($password, $char)) { 
			  $password .= $char;
			  $i++;
			} 
		} 
		return $password; 
	}

	
	
}