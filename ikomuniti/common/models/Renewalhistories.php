<?php

namespace JunMy\Models;

class Renewalhistories extends \Phalcon\Mvc\Model
{
 
	public $id,
		$user_id,
		$insurance,
		$wind_screen,
		$second_driver,
		$road_tax,
		$cover,
		$service_charge,
		$total,
		$next_renewal,
		$created,
		$pic,
		$type,
		$tracking_code,
		$delivery_method,
		$crp,
		$pa;
		
	public function getSource()
	{
		return 'renewal_histories';
	}

	

}
