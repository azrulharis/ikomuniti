<?php

namespace JunMy\Models;

class Iresellers extends \Phalcon\Mvc\Model
{

	public $id, 
		$user_id, 
		$name, 
		$location, 
		$phone, 
		$username, 
		$created, 
		$profile_image;
    
	public function getSource()
	{
		return 'iresellers';
	}

 
}





