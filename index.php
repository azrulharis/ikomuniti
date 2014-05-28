<?php

function passwordHash($pwd, $salt = null) {
    if ($salt === null) {
        $salt = substr(md5(uniqid(rand(), true)), 0, 9);
    }
    else     {
        $salt = substr($salt, 0, 9);
    }
    return $salt . sha1($pwd . $salt);
}


if(isset($_GET['url'])) {
    $url = $_GET['url']; 
    if(ctype_alnum($url)) {
     
        if(strlen($url) > 4 && strlen($url) < 19) {
            session_start();
            
            define ("DB_HOST", "localhost"); // set database host
			define ("DB_USER", "ishareuser"); // set database user
			define ("DB_PASS","rahsiajun0137831318"); // set database password
			define ("DB_NAME","ishare"); // set database name 
			$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
			$db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");
            
            // Check if user has referrence
            if(isset($_COOKIE['ref_key']) && isset($_COOKIE['referral_username']) && isset($_COOKIE['ref_id'])) {
				// Update counter on hits table
				$update = sprintf("UPDATE `hits` SET counter = counter + 1 WHERE username = '%s' AND ref_key = '%s' AND user_id = '%s'",
				        mysql_real_escape_string($_COOKIE['referral_username']),
						mysql_real_escape_string($_COOKIE['ref_key']),
						mysql_real_escape_string($_COOKIE['ref_id']));
				if(mysql_query($update)) {
					header('location: index.html');
				} else {
					die(mysql_error());
				}
			} else {
				$query = sprintf("SELECT id, username, COUNT(id) AS count FROM users WHERE username = '%s' AND role != '0' LIMIT 1", 
				mysql_real_escape_string($url));
	            $query = mysql_query($query) OR die(mysql_error());
	            $row = mysql_fetch_assoc($query);
	            if($row['count'] == 1) {
					$referral_username = $row['username'];
					$ref_key = passwordHash(date('YmdHis')); 
		            $ref_id = $row['id'];
		            $http = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'Direct Visitor';
		            $date = date('Y-m-d H:i:s');
		            //Calculate 60 days in the future
					//seconds * minutes * hours * days + current time
					$tigaBulan = 60 * 60 * 24 * 90 + time(); 
					setcookie('referral_username', $referral_username, $tigaBulan); 
		            setcookie('ref_key', $ref_key, $tigaBulan);
		            setcookie('ref_id', $ref_id, $tigaBulan);
					
					$insert = "INSERT INTO `hits`(`user_id`, `ref_key`, `username`, `http_ref`, `status`, `created`, `downline_id`, `counter`) 
					VALUES ('$ref_id ','$ref_key','$referral_username','$http','0','$date','0','1')";
					if(mysql_query($insert)) {
						header('location: index.html');
					} else {
						die(mysql_error());
					}
				}else {
					header('location: index.html');
				}	
			}  
		} else {
			header('location: index.html');
		}   
	} else {
		header('location: index.html');
	}
	
} elseif(isset($_COOKIE['ref_key']) && isset($_COOKIE['referral_username']) && isset($_COOKIE['ref_id'])) {
	// Update hits counter
	define ("DB_HOST", "localhost"); // set database host
	define ("DB_USER", "isharephal"); // set database user
	define ("DB_PASS","rahsiajun"); // set database password
	define ("DB_NAME","isharephal"); // set database name 
	$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
	$db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");
			
	$update = sprintf("UPDATE `hits` SET counter = counter + 1 WHERE username = '%s' AND ref_key = '%s' AND user_id = '%s'",
	        mysql_real_escape_string($_COOKIE['referral_username']),
			mysql_real_escape_string($_COOKIE['ref_key']),
			mysql_real_escape_string($_COOKIE['ref_id']));
	if(mysql_query($update)) {
		header('location: index.html');
	} else {
		die(mysql_error());
	}
} else {
	header('location: index.html');
}




