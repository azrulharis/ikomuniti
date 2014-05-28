<?php

namespace JunMy\Admin\Controllers;

use Phalcon\Tag;

class ControllerBase extends \Phalcon\Mvc\Controller
{
    public function initialize()
    {
        //Prepend the application name to the title
        $this->tag->prependTitle('iShare.com.my | ');
        
        $auth = $this->session->get('junauth');
        $this->view->count_inbox = count($this->nav_get_messages($auth['id']));
        $this->view->setVar('messages_nav', $this->nav_get_messages($auth['id']));
        
        $this->view->setVar('notifications_nav', $this->nav_get_notification($auth['id']));
        $this->view->count_notification = count($this->nav_get_notification($auth['id']));
        
        $this->view->path = $this->path();
        
        $this->view->admin_path = $this->admin_path();
      
       
    }
    
    	/**
     * Register authenticated user into session data
     *
     * @param Users $user
     */
    public function _registerSession($user)
    {
        $this->session->set('junauth', array(
            'id' => $user->id,
            'username' => $user->username,
            'role' => $user->role
        ));
    }
     
	private function nav_get_messages($id=null) {
		$phql = "SELECT
		    m.id AS m_id, 
			m.to_user_id AS to_user_id, SUBSTRING(m.body, 1, 55) AS body, 
			DATE_FORMAT(m.created, '%d %b') AS created, DATE_FORMAT(m.created,'%h:%i %p') AS time,
			m.message_id AS message_id,  
		    u.username AS from_username 
			FROM JunMy\Models\Messages AS m
			INNER JOIN JunMy\Models\Users AS u ON(m.from_user_id = u.id)  
			WHERE m.to_user_id = '$id' AND m.is_read = '0'
			ORDER BY m.id DESC LIMIT 30";
		$rows = $this->modelsManager->executeQuery($phql);
		return $rows;
	}
	
	private function nav_get_notification($id) {
		$phql = "SELECT
		    SUBSTRING(n.body, 1, 29) AS body, DATE_FORMAT(n.created, '%h:%i %p %d %b') AS created
			FROM JunMy\Models\Notifications AS n 
			WHERE n.user_id IN(1, 2, 3, '$id') AND n.read = '0' AND type > '4'
			ORDER BY n.created DESC LIMIT 15";
		$rows = $this->modelsManager->executeQuery($phql);
		return $rows;
	}
	
	public function role($user_role, $allow_role) {
		if(!in_array($user_role, $allow_role)) {
			return $this->response->redirect('gghadmin/error/notallowed');
		}  
	}
    
    public function pageProtect() {
		if(!$this->session->get('junauth')) {
	        $this->flash->error('Please login to access members area');
			return $this->response->redirect('gghadmin/users/login');
		}
		session_regenerate_id();
	}
	
	public function iprihatin_image_dir() {
		return '/ikomuniti/uploads/iprihatins/';
	}
	
	public function iprihatin_thumb_dir() {
		return '/ikomuniti/uploads/iprihatins/thumbs/';
	}
	
	public function thumb_image_dir() {
		return '/ikomuniti/uploads/imall/thumbnails/';
	}
	
	public function imall_image_dir() {
		return '/ikomuniti/uploads/imall/images/';
	}
	
	public function ioffer_image_dir() {
		return '/ikomuniti/uploads/ioffers/images/';
	}
	
	public function ioffer_thumb_dir() {
		return '/ikomuniti/uploads/ioffers/thumbnails/';
	}
	
	public function imall_dir() {
		return '/ishare/imall';
	}
	
	public function host() {
		return 'http://ishare.com.my/';
	}
	
	public function path() {
		return '/ikomuniti/';
	}
	
	public function admin_path() {
		return '/ikomuniti/gghadmin/';
	}
	
	// 23/4/2014 2.35PM LAST DATA
	
	// 1 RENEW, 2 BUY IMALL, 3 TRANSFER TO OTHER USER, 4 DONATE, 5 WITHDRAW, 6 COMMISSION, 7 ADD FUND BY ADMIN FOR RENEW, 8 DEDUCT SMS 0.20, 9 SELL ON IMALL, 10 RECEIVE FROM OTHER USER, 11 BUY COMPANY ITEMS, 12 BUY E PINS, 13 CREDIT BY ADMIN 14 DEDUCT BY ADMIN, 15 IMALL MESSAGE NOTIFICATION
	
}