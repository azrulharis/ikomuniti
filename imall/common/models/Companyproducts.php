<?php

namespace JunMy\Models;

class Companyproducts extends \Phalcon\Mvc\Model
{
    public $id, $title, $price, $market_price, $body, $created, $stock, $slug, $status, $counter, $commission;
	
	public function getSource()
	{
		return 'company_products';
	}

}
