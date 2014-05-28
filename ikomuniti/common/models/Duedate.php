<?php

namespace JunMy\Models;

class Duedate extends \Phalcon\Mvc\Models {
 
    public $user_id, $due_date, $created, $status;
    
	public function getSource()
	{
		return 'due_date_request';
	}
}