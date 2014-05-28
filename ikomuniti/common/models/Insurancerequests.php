<?php

namespace JunMy\Models;

class Insurancerequests extends \Phalcon\Mvc\Model {
    
    public $user_id, $windscreen, $crp, $additional_driver, $created, $status;
    
	public function getSource()
	{
		return 'insurance_requests';
	}



}