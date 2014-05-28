<?php

namespace JunMy\Models;

class Companyproductorders extends \Phalcon\Mvc\Model
{
    public $id, $company_product_id, $user_id, $username, $address, 
	$created, $postcode, $phone, $tracking_code, $total_product, 
	$amount, $real_amount, $paid_amount, $status, $payment, $merchant_ref, $payment_method;
	
	public function getSource()
	{
		return 'company_product_orders';
	}

}
