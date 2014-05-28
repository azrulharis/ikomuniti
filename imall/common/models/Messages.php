<?php

namespace JunMy\Models;

class Messages extends \Phalcon\Mvc\Model
{
    public $id, $from_user_id, $to_user_id, $body, $created, $is_read, $message_id, $token;
    
	public function getSource()
	{
		return 'Messages';
	}

	

}
