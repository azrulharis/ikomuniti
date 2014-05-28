<?php

namespace JunMy\Models;

class News extends \Phalcon\Mvc\Model
{
    public $id, $title, $created, $body, $slug, $visibility;
	
	public function getSource()
	{
		return 'news';
	}

}
