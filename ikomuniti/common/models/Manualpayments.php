<?php

namespace JunMy\Models;

class Manualpayments extends \Phalcon\Mvc\Model
{
    public $id, $user_id, $amount, $payment_date, $payment_time, $remark, $created, $status, $from_acc;
	
	public function getSource()
	{
		return 'manual_payments';
	}

}