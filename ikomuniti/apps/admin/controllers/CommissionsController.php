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
		$this->role($auth['role'], array(5, 6, 7));
		 
	   	if(isset($_GET['user_id']) && isset($_GET['ins_amount'])) {
	   	    
	   	    $user_id = filter_input(INPUT_GET, 'user_id', FILTER_VALIDATE_INT);
	   	    $ins_amount = $_GET['ins_amount'];
	   	    
	   	    // Pay commision 4 level  
			$this->for_level($user_id, $ins_amount, $auth['id']); 
			$this->flashSession->success('Insurance has been renew');
			return $this->response->redirect('gghadmin/insuran/manage');
			 
		} else {
			$this->flash->error('Not valid url');
		}  
	}
	
	private function for_level($user_id, $amount, $pic) {
	    //Select join 4 level, retrieve phone for SMS and 
		$phql = "SELECT root.username AS renewal_username, root.role AS status,
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
		$this->update_wallet($row['one_id'], $level_1, $pic, $row['one_sms'], $row['one_phone'], $row['renewal_username']);
		$this->update_wallet($row['two_id'], $level_2, $pic, $row['two_sms'], $row['two_phone'], $row['renewal_username']);
		$this->update_wallet($row['tree_id'], $level_3, $pic, $row['tree_sms'], $row['tree_phone'], $row['renewal_username']);
		$this->update_wallet($row['four_id'], $level_4, $pic, $row['four_sms'], $row['four_phone'], $row['renewal_username']);	
	}
	
	/**
	* UPDATE EWALLET BALANCE amount = amount + $amount
	*/
	private function update_wallet($id, $amount, $pic, $sms_setting, $phone, $username) {
	    
	    $user = Users::findFirst($id);
	    $receiver = $user->username;
	    
	    
	    
		$phql = "UPDATE JunMy\Models\Wallets SET 
				amount = amount + '$amount' WHERE user_id = '$id'";
		$update = $this->modelsManager->executeQuery($phql);
		if($update) { 
			$this->transaction_history($id, $amount, $pic, $username);
			if($sms_setting == 1) {
			    $wallet = Wallets::findFirst("user_id = '$id'");
	            $balance = $wallet->amount;
				$this->send_sms($amount, $username, $phone, $receiver, $balance);
				$this->deduct_sms($id, $pic);
				$this->deduct_wallet_sms($id);
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
	private function transaction_history($user_id, $amount, $pic, $username) {
		$hist = new Transactions();
		$hist->user_id = $user_id;
		$hist->title = 'Renewal Commission From '.$username; 
		$hist->amount = "$amount";
		$hist->created = date('Y-m-d H:i:s'); 
		$hist->reference = 'RC'.date('YmdHis').$user_id;
		$hist->type = 6; 
		$hist->pic = $pic;
		// 1 RENEW, 2 BUY IMALL, 3 TRANSFER TO OTHER USER, 4 DONATE, 5 WITHDRAW, 6 COMMISSION, 7 ADD FUND, 8 DEDUCT SMS 0.20, 9 SELL ON IMALL, 10 RECEIVE FROM OTHER USER, 11 BUY COMPANY ITEMS, 12 BUY E PINS,
		if($hist->save()) {
			return true;
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

	/**
	* If sms_setting = 1, send sms every get commission
	*/  
	private function send_sms($amount, $username, $telephone, $receiver, $balance) { 
	    $sms_username = "ishare.com.my";
        $sms_password = "rahsiajun.228";
		$sms_dstno = $telephone;
        $sms_msg = 'Congratulations!. RM'.$amount.' has been credited to '.$receiver. ' iPoint Acc. from '.$username.' Takaful Renewal. Total iPoint amount is RM'.$balance.'. Please visit www.ishare.com.my or Like! www.facebook.com/ishare.com.my for iShare latest news. Thank you very much for your priceless support!';

        $sms_type = 1;
        $sms_senderid = 1;
        $sms_sendlink = "http://www.isms.com.my/isms_send.php?un=".urlencode($sms_username)."&pwd=".urlencode($sms_password)."&dstno=".$sms_dstno."&msg=".urlencode($sms_msg)."&type=".$sms_type."&sendid=".$sms_senderid; 
        fopen($sms_sendlink, "r");
	}
	
}

