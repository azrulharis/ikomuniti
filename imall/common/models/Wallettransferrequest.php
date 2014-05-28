<?php

namespace JunMy\Models;

class Wallettransferrequest extends \Phalcon\Mvc\Model
{
    public $id, $user_id, $recipient_username, $amount, $sms_code, $remark, $created, $type, $status;
    
	public function getSource()
	{
		return 'wallet_transfer_requests';
	}

	

}

