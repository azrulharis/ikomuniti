<?php

namespace JunMy\Models;

class Postmessages extends \Phalcon\Mvc\Model {

    public $post_id, $slug, $user_id, $name, $email, $phone, $ip_address, $created, $is_read, $body;
    
    public function getSource() {
		return 'post_messages';
	}
}