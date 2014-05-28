<?php

namespace JunMy\Models;

class Iprihatinphoto extends \Phalcon\Mvc\Model
{ 
	public $iprihatin_id, $image_name;
	public function getSource()
	{
		return 'iprihatin_photo';
	}

}
