<?php

namespace JunMy\Models;

class Companyproductimages extends \Phalcon\Mvc\Model
{
    public $company_product_id, $image_name, $default_image;
	
	public function getSource()
	{
		return 'company_product_images';
	}

}
