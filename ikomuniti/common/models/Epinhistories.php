<?php

namespace JunMy\Models;

class Epinhistories extends \Phalcon\Mvc\Model
{
    public $epin_id, $user_id, $epin, $created, $to_user_id;
	
	public function getSource()
	{
		return 'epin_histories';
	}

}