<?php

namespace JunMy\Models;

class Passwordrequests extends \Phalcon\Mvc\Model
{
    public $id, $user_id, $ip_address, $confirmation, $created, $status, $tac;
    
	public function getSource()
	{
		return 'password_requests';
	} 

}