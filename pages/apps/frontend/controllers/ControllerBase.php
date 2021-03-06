<?php

namespace JunMy\Frontend\Controllers;

use Phalcon\Tag;

class ControllerBase extends \Phalcon\Mvc\Controller
{
    public function initialize()
    {
        //Prepend the application name to the title
        $this->tag->prependTitle('iShare.com.my | ');
        $this->view->web_host = '/isharev1/';
    }
    
     
    
    public function iprihatin_image_dir() {
		return '/isharev1/ikomuniti/uploads/iprihatins/';
	}
	
	public function iprihatin_thumb_dir() {
		return '/isharev1/ikomuniti/uploads/iprihatins/';
	}
	
	public function thumb_image_dir() {
		return '/isharev1/ikomuniti/uploads/imall/thumbnails/';
	}
	
	public function ipartner_thumb_image_dir() {
		return '/isharev1/ikomuniti/uploads/ipartners/thumbnails/';
	}
	
	public function ipartner_image_dir() {
		return '/isharev1/ikomuniti/uploads/ipartners/images/';
	}
	
	public function imall_image_dir() {
		return '/isharev1/ikomuniti/uploads/imall/images/';
	}
	
	public function imall_thumb_image_dir() {
		return '/isharev1/ikomuniti/uploads/imall/thumbnails/';
	}
	
	public function imall_dir() {
		return '/isharev1/imall';
	}
	
	public function host() {
		return '/isharev1/';
	}
	
	public function profile_image_dir() {
		return '/isharev1/ikomuniti/uploads/profiles/large/';
	}
	
	public function path() {
		return '/isharev1/pages/';
	}
	
	public function role($user_role, $allow_role) {
		if(!in_array($user_role, $allow_role)) {
			return $this->response->redirect('isahabat/index');
		}  
	}
	
	public function ioffer_image_dir() {
		return '/isharev1/ikomuniti/uploads/ioffers/images/';
	}
	
	public function ioffer_thumb_dir() {
		return '/isharev1/ikomuniti/uploads/ioffers/thumbnails/';
	}
	
}