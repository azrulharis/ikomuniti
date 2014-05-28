<?php

namespace JunMy\Models;

class Ipartner extends \Phalcon\Mvc\Model
{
	public $id, 
	$title, 
	$description, 
	$address_one, 
	$address_two,  
	$city,  
	$postcode, 
	$discount, 
	$category_id,  
	$region_id, 
	$created, 
	$user_id,  
	$url,  
	$type,
	$status, 
	$note;  
	public function getSource()
	{
		return 'ipartner';
	}

	

}



