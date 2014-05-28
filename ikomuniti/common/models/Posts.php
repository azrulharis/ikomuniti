<?php

namespace JunMy\Models;

use Phalcon\Mvc\Model\Validator\Email as EmailValidator,
    Phalcon\Mvc\Model\Validator\Numericality as NumericalityValidator;

class Posts extends \Phalcon\Mvc\Model
{   
    public $id, $title, $description, $price, $stock, $category_id, $region_id, $created, $user_id, $url, $status, $note, $hit;


	public function getSource()
	{
		return 'posts';
	}
 

}
