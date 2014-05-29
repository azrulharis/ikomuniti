<?php

namespace JunMy\Models;


class Userlevels extends \Phalcon\Mvc\Model {
	
	public $user_id, $is_one, $is_two, $is_three, $is_four;
	
	public function getSource() {
		return 'user_levels';
	}
}