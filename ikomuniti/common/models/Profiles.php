<?php

namespace JunMy\Models;

class Profiles extends \Phalcon\Mvc\Model { 

	public $id, $user_id, $display_name, $about, $website, $location, $hometown, $job, $company, $college, $high_school, $dob, $created;
	
	public function getSource() {
		return 'profiles';
	} 
}	