<?php

namespace JunMy\Models; 

class Users extends \Phalcon\Mvc\Model
{

	public $id, $username, $password, $name, $email, $created_at, $active, $profile_image, 
	$phone, $business_name, $address, $company_info, $nric, $city, $role, $master_key;

	public function getSource()
	{
		return 'users';
	}
 
	
	 

}
