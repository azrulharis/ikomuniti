<?php

namespace JunMy\Models; 

class Users extends \Phalcon\Mvc\Model
{

	public  $id, 
			$username_sponsor, 
			$username, 
			$name, 
			$password, 
			$nric_new, 
			$kin_name, 
			$relation, 
			$kin_phone, 
			$nric_new_kin, 
			$bank_number, 
			$bank_name, 
			$address, 
			$postcode, 
			$telephone, 
			$email, 
			$previous_insuran_company, 
			$cover_note, 
			$insuran_ncb, 
			$road_tax, 
			$insuran_due_date, 
			$reg_number, 
			$owner_name, 
			$owner_nric, 
			$owner_dob, 
			$model, 
			$year_make, 
			$capacity, 
			$engine_number, 
			$chasis_number, 
			$grant_serial_number, 
			$ip_address, 
			$created, 
			$payment, 
			$verified, 
			$role, 
			$ckey, 
			$profile_image, 
			$sms_setting, 
			$master_key;

	public function getSource()
	{
		return 'users';
	}
 
	
	 

}



