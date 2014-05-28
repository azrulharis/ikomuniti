<?php

namespace JunMy\Models;

class Wallets extends \Phalcon\Mvc\Model
{   
 
    public $id, $user_id, $amount;

	public function getSource()
	{
		return 'wallets';
	} 

}
