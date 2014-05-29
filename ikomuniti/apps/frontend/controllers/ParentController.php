<?php

namespace JunMy\Frontend\Controllers;

use JunMy\Models\Users; 

class ParentController extends ControllerBase {
	
	public function initialize() { 
		$this->tag->setTitle('iShare Parent Child');
		parent::initialize();
	}
	
	public function indexAction() {
		parent::pageProtect();
		
		// Get session in array
	    $auth = $this->session->get('jun_user_auth');
	    $this->display_children('fazly', 1);
	    
	}
	
	private function parent($username) {
		$phql = "SELECT username, username_sponsor, role FROM JunMy\Models\Users WHERE username = '$username' LIMIT 100";
		$rows = $this->modelsManager->executeQuery($phql);
		foreach($rows as $row) {
			if($row['role'] == 1) {
				$this->parent($row['username_sponsor']);
			} 
		}
		echo $row['username'];
	}
	
	// DO this function for 4 level IE: display_child_one and so on... find where role is ikomuniti
	private function display_children($username, $level) {
	    // retrieve all children
	    $phql = "SELECT username, username_sponsor, role FROM JunMy\Models\Users WHERE username = '$username' AND id != '1' LIMIT 1";
		$rows = $this->modelsManager->executeQuery($phql); 
	    // display each child
	    foreach ($rows as $row) {
	        // indent and display the title of this child
	        // if you want to save the hierarchy, replace the following line with your code
		    if($row['role'] != 2) {
				// call this function again to display this child's children
	        	$this->display_children($row['username_sponsor'], $level+1);
			} else {
			    $this->display_children($row['username_sponsor'], $level+1);
				echo str_repeat(' ',$level) . $row['username'] . "<br/>";
			} 
	        
	    }
	}
}



/*
List file to chabge for iKomuniti Compress


Tree

Activation

Admin Commission

Role

0 = pre register
1 = 
2
3 = iShahabat
4 = iKomuniti
5 = iReseller
6 = Admin
7 = Takaful
8 = Account
9 = Developer

Add 1 more column for user parent child

Split table user

*/