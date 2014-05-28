<?php

namespace JunMy\Models;

class Withdrawals extends \Phalcon\Mvc\Model
{
    public $id, $user_id, $amount, $bank, $account, $created, $status;
    
	public function getSource()
	{
		return 'withdrawals';
	}

	

}
