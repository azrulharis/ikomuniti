<?php

namespace JunMy\Models;

class Hits extends \Phalcon\Mvc\Model
{

	public $id, $user_id,
			$ref_key,
			$username,
			$http_ref,
			$status,
			$created,
			$downline_id,
			$counter;
    
	public function getSource()
	{
		return 'hits';
	}

 
}