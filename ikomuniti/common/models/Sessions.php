<?php

namespace JunMy\Models;

class Sessions extends \Phalcon\Mvc\Model
{   
 
    public $user_id, $user_agent, $ip_address, $created, $is_login, $token;

	public function getSource()
	{
		return 'sessions';
	} 

}
