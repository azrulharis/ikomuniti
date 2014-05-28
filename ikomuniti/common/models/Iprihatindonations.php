<?php

namespace JunMy\Models;

class Iprihatindonations extends \Phalcon\Mvc\Model
{
    public $id, $user_id, $iprihatin_id, $amount, $created;
	
	public function getSource()
	{
		return 'iprihatin_donations';
	}

}
