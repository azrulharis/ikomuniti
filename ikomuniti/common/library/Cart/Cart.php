<?php

namespace JunMy\Components\Cart;

class Cart {
	
	public function add($post_id, $title, $price, $quantity, $token) {
		if(!is_numeric($post_id)) {
			return false;
		} elseif(!is_numeric($price)) {
			return false;
		} elseif(!is_numeric($quantity) || $quantity < 1) {
			return false;
		} elseif($token == '') {
			return false;
		} else {
			// Check if product is already in cart
			if($this->check_id($post_id) == 0) {
				$
			}
		}
	}
	
	private function set_session($product) {
        $this->session->set('cart', array(
			$product->id => array(
	            'product_id' => $product->id,
	            'product_name' => $product->name,
	            'product_quantity' => $product->quantity,
	            'product_price' => $product->price
	        )));
    }
	
	private function check_exist($post_id) {
		$cart = $this->session->get('cart');
		return $cart['cart'][$post_id];
	}
}