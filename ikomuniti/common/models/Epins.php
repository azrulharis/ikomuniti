<?php

namespace JunMy\Models;

class Epins extends \Phalcon\Mvc\Model
{
    public $id, $user_id, $epin, $created, $status, $used_user_id, $last_owner, $token;
	
	public function getSource()
	{
		return 'epins';
	}

}
