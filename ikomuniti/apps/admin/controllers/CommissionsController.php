<?php

namespace JunMy\Admin\Controllers;
use JunMy\Models\Users;
use JunMy\Models\Wallets;
use JunMy\Models\Notifications;
use JunMy\Models\Transactions;

	
class CommissionsController extends ControllerBase {
 
    
    public function initialize()
    {
        //Set the document title
        $this->tag->setTitle('Insurance Managements');
        parent::initialize();
    }

	public function payoutAction() {
		parent::pageProtect();
		$auth = $this->session->get('junauth');
		$this->role($auth['role'], array(7, 8, 9));
		 
		 
	   	if(isset($_GET['user_id']) && isset($_GET['ins_amount']) && isset($_GET['role']) && isset($_GET['token'])) {
	   	    if(!$_SESSION['COMMISSION_TOKEN']) {
				$this->flashSession->error('Direct access are not allowed!');
				return $this->response->redirect('gghadmin/insuran/manage');
			} elseif($_SESSION['COMMISSION_TOKEN'] != $_GET['token']) {
				$this->flashSession->error('Not valid security token. Please try again.');
				return $this->response->redirect('gghadmin/insuran/manage');
			} else {
				$user_id = filter_input(INPUT_GET, 'user_id', FILTER_VALIDATE_INT);
		   	    $ins_amount = $_GET['ins_amount'];
		   	    $role = $_GET['role'];
		   	    // Pay commision 4 level  
				$this->for_level($user_id, $ins_amount, $auth['id'], $role); 
				
				// Remove session token
				unset($_SESSION['COMMISSION_TOKEN']);
				
				$this->flashSession->success('Insurance has been renew');
				return $this->response->redirect('gghadmin/insuran/manage');	
			}
	   	      
			 
		} else {
			$this->flash->error('Not valid url or token');
		}  
	}
	
	private function for_level($user_id, $amount, $pic, $role) {
	 
	    // If role >= 4, is iKomuniti. 
	    if($role >= 4) {
			if($amount >= 500) {
				$level_1 = 15;
				$level_2 = 10;
				$level_3 = 5;
				$level_4 = 10;
			} elseif($amount < 500) {
				// Jika insuran bawah 500
				$level_1 = 5;
				$level_2 = 3;
				$level_3 = 2;
				$level_4 = 5;
			}	
			$is_1 = $level_1;
			$is_2 = $level_2;
			$is_3 = $level_3;
			$is_4 = $level_4;
		} else {
			if($amount >= 500) {
				$level_1 = 7.5;
				$level_2 = 5;
				$level_3 = 2.5;
				$level_4 = 5;
			} elseif($amount < 500) {
				// Jika insuran bawah 500
				$level_1 = 2.5;
				$level_2 = 1.5;
				$level_3 = 1;
				$level_4 = 2.5;
			}
			$is_1 = $level_1;
			$is_2 = $level_2;
			$is_3 = $level_3;
			$is_4 = $level_4;
		}
		
			
			//Select join 4 level, retrieve phone for SMS and 
		$phql = "SELECT root.username AS renewal_username, root.role AS user_role,
						one.id AS one_id, one.sms_setting AS one_sms, one.telephone AS one_phone, 
		                two.id AS two_id, two.sms_setting AS two_sms, two.telephone AS two_phone, 
						tree.id AS tree_id, tree.sms_setting AS tree_sms, tree.telephone AS tree_phone, 
						four.id AS four_id, four.sms_setting AS four_sms, four.telephone AS four_phone  
				FROM JunMy\Models\Users AS root		
				LEFT JOIN JunMy\Models\Users AS one ON(one.username = root.username_sponsor)
				LEFT JOIN JunMy\Models\Users AS two ON(two.username = one.username_sponsor)
				LEFT JOIN JunMy\Models\Users AS tree ON(tree.username = two.username_sponsor)
				LEFT JOIN JunMy\Models\Users AS four ON(four.username = tree.username_sponsor)
				WHERE root.id = '$user_id' LIMIT 4";
		$rows = $this->modelsManager->executeQuery($phql);
		foreach($rows as $row) { 
		 
		} 		 
		$this->update_wallet($row['one_id'], $is_1, $pic, $row['one_sms'], $row['one_phone'], $row['renewal_username'], $role);
		$this->update_wallet($row['two_id'], $is_2, $pic, $row['two_sms'], $row['two_phone'], $row['renewal_username'], $role);
		$this->update_wallet($row['tree_id'], $is_3, $pic, $row['tree_sms'], $row['tree_phone'], $row['renewal_username'], $role);
		$this->update_wallet($row['four_id'], $is_4, $pic, $row['four_sms'], $row['four_phone'], $row['renewal_username'], $role);	
	}
	
	/**
	* UPDATE EWALLET BALANCE amount = amount + $amount
	*/
	private function update_wallet($id, $amount, $pic, $sms_setting, $phone, $username, $role) {
	    
	    $user = Users::findFirst($id);
	    $receiver = $user->username;
	    
	    
	    
		$phql = "UPDATE JunMy\Models\Wallets SET 
				amount = amount + '$amount' WHERE user_id = '$id'";
		$update = $this->modelsManager->executeQuery($phql);
		if($update) { 
		 
		    // Add transaction history
			$this->transaction_history($id, $amount, $pic, $username, $role);
			
			// If enabled SMS
			if($sms_setting == 1) { 
				
				// Sms payout on transaction history
				$this->deduct_sms($id, $pic);
				
				// Deduct wallet for SMS
				$this->deduct_wallet_sms($id);
				
				$wallet = Wallets::findFirst("user_id = '$id'");
	            $balance = $wallet->amount;
	            
	            // Send detail SMS renewal commission
				$this->send_sms($amount, $username, $phone, $receiver, $balance, $role);
			}
		} else {
			$this->flash->error("Error: private function update_wallet");
		}	
		 
	}
	
	private function deduct_wallet_sms($id) {
		$date = date('Y-m-d H:i:s');
		$phql = "UPDATE JunMy\Models\Wallets SET 
				amount = amount - '0.20' WHERE user_id = '$id'";
		$update = $this->modelsManager->executeQuery($phql);
		return $update;
	}

	/**
	* Insert transaction history
	*/
	private function transaction_history($user_id, $amount, $pic, $username, $role) {
	    if($role >= 4) {
			$status = 'iKomuniti';
		} elseif($role <= 3) {
			$status = 'iSahabat';
		}
		$hist = new Transactions();
		$hist->user_id = $user_id;
		$hist->title = 'Renewal Commission '.$username. ' ('.$status.')'; 
		$hist->amount = "$amount";
		$hist->created = date('Y-m-d H:i:s'); 
		$hist->reference = 'RC'.date('YmdHis').$user_id;
		$hist->type = 6; 
		$hist->pic = $pic;
		// 1 RENEW, 2 BUY IMALL, 3 TRANSFER TO OTHER USER, 4 DONATE, 5 WITHDRAW, 6 COMMISSION, 7 ADD FUND, 8 DEDUCT SMS 0.20, 9 SELL ON IMALL, 10 RECEIVE FROM OTHER USER, 11 BUY COMPANY ITEMS, 12 BUY E PINS,
		if($hist->save()) {
			$this->notification($user_id, $amount, $username, $role);
		}
	}
	
	private function deduct_sms($user_id, $pic) {
		$hist = new Transactions();
		$hist->user_id = $user_id;
		$hist->title = 'SMS Payout'; 
		$hist->amount = 0.20;
		$hist->created = date('Y-m-d H:i:s'); 
		$hist->reference = 'SMSD'.date('YmdHis').$user_id;
		$hist->type = 8; 
		$hist->pic = $pic;
		// 1 RENEW, 2 BUY IMALL, 3 TRANSFER TO OTHER USER, 4 DONATE, 5 WITHDRAW, 6 COMMISSION, 7 ADD FUND, 8 DEDUCT SMS 0.20, 9 SELL ON IMALL, 10 RECEIVE FROM OTHER USER, 11 BUY COMPANY ITEMS, 12 BUY E PINS,
		if($hist->save()) {
			return true;
		}
	}
	
	/*
	*  Send notification after success renew, used on renewAction
	*/
    private function notification($user_id, $amount, $username, $role) {
        if($role >= 4) {
			$status = 'iKomuniti';
		} elseif($role <= 3) {
			$status = 'iSahabat';
		}
		$note = new Notifications();
	    $note->user_id = $user_id;
	    $note->body = 'Congratulations!. RM'.number_format($amount).' has been credited to your iPoint Acc. from '.$username.' ('.$status.') Takaful Renewal. Thank you very much for your priceless support!';
	    $note->created = date('Y-m-d H:i:s');
	    $note->read = 0;
	    $note->type = 6;
	    return $note->save();
	}

	/**
	* If sms_setting = 1, send sms every get commission
	*/  
	private function send_sms($amount, $username, $telephone, $receiver, $balance, $role) { 
	    $sms_username = "ishare.com.my";
        $sms_password = "rahsiajun.228";
		$sms_dstno = $telephone;
		if($role >= 4) {
			$status = 'iKomuniti';
		} elseif($role <= 3) {
			$status = 'iSahabat';
		}
        $sms_msg = 'Congratulations!. RM'.number_format($amount).' has been credited to '.$receiver. ' iPoint Acc. from '.$username.' ('.$status.') Takaful Renewal. Total iPoint amount is RM'.$balance.'. Please visit www.ishare.com.my or Like! www.facebook.com/ishare.com.my for iShare latest news. Thank you very much for your priceless support!';

        $sms_type = 1;
        $sms_senderid = 1;
        $sms_sendlink = "http://www.isms.com.my/isms_send.php?un=".urlencode($sms_username)."&pwd=".urlencode($sms_password)."&dstno=".$sms_dstno."&msg=".urlencode($sms_msg)."&type=".$sms_type."&sendid=".$sms_senderid; 
        fopen($sms_sendlink, "r");
	}
	
}

