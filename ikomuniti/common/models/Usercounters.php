<?php

namespace JunMy\Models;

class Usercounters extends \Phalcon\Mvc\Model
{
    public $user_id, $is_one, $status, $isahabat_one;
    
	public function getSource()
	{
		return 'user_counters';
	}

	

}