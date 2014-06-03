<?php

namespace JunMy\Models;

class Isahabatepins extends \Phalcon\Mvc\Model
{
    public $id, $user_id, $epin, $created, $status, $used_user_id, $last_owner, $token;
	
	public function getSource()
	{
		return 'isahabat_epins';
	}

}
