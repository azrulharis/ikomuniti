<?php

namespace JunMy\Frontend\Controllers;
use JunMy\Models\Users;
use JunMy\Models\Profiles;
class ProfileController extends ControllerBase {
	
	public function initialize() { 
		$this->tag->setTitle($this->dispatcher->getParam('username'));
		parent::initialize();
	}
	
	public function indexAction() {
	    $username = $this->dispatcher->getParam('username');
		if(!ctype_alnum($username)) {
			die('Page not found');
		} elseif(count($this->check_username($username)) != 1) {
			die('iKomuniti not found');
		} else {
		    if($this->session->has('jun_user_auth')) {
				$is_login = 1;
				$auth = $this->session->get('jun_user_auth');
				$this->view->setVar('navigations', $this->get_user($auth['id'])); 
				$this->view->my_username = $auth['username'];
			} else {
				$is_login = 0;
				
			}
			
			
			// Set view for login menu
			$this->view->is_login = $is_login;
			
			// Set view for path image
			$this->view->profile_path = $this->profile_image_dir();
			
			// Set view for profiles
			$this->view->setVar('profiles', $this->get_profile($username)); 
			
			$user = Users::findFirst("username = '$username'");
			
			// Set thumb imall dir
			$this->view->thumb_dir = $this->thumb_image_dir();
			
			// Wall hist
			$this->view->setVar('walls', $this->history($user->id));
			// This seller ads
			$this->view->setVar('ads', $this->seller_ads($user->id));
			
			if(count($this->has_profile($user->id)) != 0) {
				$has_profile = 1;
			} else {
				$has_profile = 0;
			}
			
			// Set view for has profile to prevent wall view
			$this->view->has_profile = $has_profile;
		}
	}
	
	/*
	*  Select user WHERE user_id = $_SESSION
	*/
	private function get_user($id) {
	    $phql = "SELECT u.username AS username, u.name AS name, u.telephone AS telephone, u.created AS created, 
		  u.address AS address, u.email AS email, u.insuran_due_date AS insuran_due_date, 
		  u.profile_image AS profile_image, u.reg_number AS reg_number,
	      w.amount AS amount
		  FROM JunMy\Models\Users AS u
		  INNER JOIN JunMy\Models\Wallets AS w ON(u.id = w.user_id) 
		  WHERE u.id = '$id'";
		$rows = $this->modelsManager->executeQuery($phql);
		 
		return $rows;
	}
	
	private function has_profile($id) {
		$phql = "SELECT id
		  FROM JunMy\Models\Profiles  
		  WHERE user_id = '$id' LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql);
		 
		return $rows;
	}
	
	/*
	*  Select user WHERE user_id = $_SESSION
	*/
	private function history($id) {
	    $phql = "SELECT type, DATE_FORMAT(created,'%d %b %Y') AS created
		  FROM JunMy\Models\Transactions  
		  WHERE user_id = '$id' AND type IN(1, 6) ORDER BY created LIMIT 30";
		$rows = $this->modelsManager->executeQuery($phql);
		 
		return $rows;
	}
	
	private function get_profile($username) { 
		$phql = "SELECT u.id AS id,
						u.username_sponsor AS sponsor,
						u.username AS username,
						u.name AS name, 
						u.address AS address,
						u.postcode AS postcode,
						u.telephone AS phone,
						u.email AS email,  
						u.insuran_due_date AS due_date,
						u.reg_number AS reg_no,
						DATE_FORMAT(u.created,'%d %b %Y %h:%i %p') AS created, 
						u.role AS role, 
						u.profile_image AS profile_image,
						p.display_name AS display_name,
						p.about AS quote,
						p.website AS website,
						p.location AS location,
						p.hometown AS hometown,
						p.job AS job,
						p.company AS company,
						p.high_school AS school,
						p.college AS college,
						p.dob AS dob,
						DATE_FORMAT(p.created,'%d %b %Y %h:%i %p') AS last_update
		FROM JunMy\Models\Users u 
		LEFT OUTER JOIN JunMy\Models\Profiles AS p ON(u.id = p.user_id)
		WHERE u.username = :username: LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql, array('username' => $username));
		 
		return $rows;
	}
	
	private function check_username($username) {
		$phql = "SELECT id FROM JunMy\Models\Users WHERE username = :username: LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql, array('username' => $username));
		 
		return $rows;
	}
	
	private function check_imall($id) {
		$phql = "SELECT id FROM JunMy\Models\Posts WHERE user_id = :user_id: LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql, array('user_id' => $id));
		 
		return $rows;
	}
	
		/*
	*  This seller ads, Used on index
	*/
	private function seller_ads($user_id) {
		$phql = "SELECT 
		  p.id AS id, p.title AS title, p.price AS price, 
		  i.image_name AS image  
		  FROM JunMy\Models\Posts AS p 
		  LEFT JOIN JunMy\Models\Postimages AS i ON(p.id = i.post_id)  
		  WHERE p.user_id = :param: GROUP BY p.id ORDER BY RAND() LIMIT 4"; //AND status = :status: 
		$rows = $this->modelsManager->executeQuery($phql, array('param' => $user_id)); 
	 
		return $rows;
	}
	
}