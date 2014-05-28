<?php

namespace JunMy\Frontend\Controllers;

use JunMy\Models\Users;
use JunMy\Models\Postmessages; 
use JunMy\Models\Notifications; 

class AjaxController extends ControllerBase {
	
 
	/*
	*  Check valid username for registration form
	*/
	public function sponsorusernameAction() {
		$this->view->disable();
		$request = new \Phalcon\Http\Request();
		if($request->isAjax() == true) {
			if($request->isPost() == true) {
			    if(!ctype_alnum($this->request->getPost('username_sponsor'))) {
					$this->flash->error('Id penaja tidak sah');
				} elseif(strlen($this->request->getPost('username_sponsor')) < 5 || strlen($request->getPost('username_sponsor')) > 18) {
					$this->flash->error('Id penaja tidak sah');
				} else {
				    $username = $this->request->getPost('username_sponsor');
					$user = Users::find("username = '$username' LIMIT 1");
					if(count($user) != 1) {
						die('Id penaja tidak wujud');
					} else {
						//die("$username is available");
						//echo $user->name .' Phone: '. $user->telephone;
						$phql = "SELECT username, name, telephone FROM JunMy\Models\Users WHERE username = '$username' AND role != '0' LIMIT 1";
						$rows = $this->modelsManager->executeQuery($phql);
						foreach($rows as $row) {
							echo $row['name'] . ' - '. $row['telephone'];
						}
					}
				}
			}
		}
	}
	
	/*
	*  Check valid username for registration form
	*/
	public function ajaxusernameAction() {
		$this->view->disable();
		$request = new \Phalcon\Http\Request();
		if($request->isAjax() == true) {
			if($request->isPost() == true) {
			    if(!ctype_alnum($this->request->getPost('username'))) {
					$this->flash->error('Id tidak sah');
				} elseif(strlen($this->request->getPost('username')) < 5 || strlen($request->getPost('username')) > 18) {
					$this->flash->error('Id tidak sah');
				} else {
				    $username = $this->request->getPost('username');
					$user = Users::find("username = '$username' LIMIT 1");
					if(count($user) == 1) {
						die('Username telah digunakan');
					} else {
						die("$username is available");
					}
				}
			}
		}
	}
	
	/*
	*  Ajax image thumbnail on imall
	*/
	public function ajaximallAction() {
		$this->view->disable();
		$request = new \Phalcon\Http\Request();
		if($request->isAjax() == true) {
			if($request->isPost() == true) {
			    $image = $_POST['id'];
				echo '<div class="loadimage"><img src="'.$this->imall_image_dir().$image.'" alt="" title="" /></div>';
			}
		}
	}
	
	/*
	*  Ajax image thumbnail on imall
	*/
	public function ajaxiofferAction() {
		$this->view->disable();
		$request = new \Phalcon\Http\Request();
		if($request->isAjax() == true) {
			if($request->isPost() == true) {
			    $image = $_POST['id'];
				echo '<div class="loadimage"><img src="'.$this->ioffer_image_dir().$image.'" alt="" title="" /></div>';
			}
		}
	}

}