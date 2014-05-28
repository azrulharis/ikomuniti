<?php
require_once('app/dbc.php');
page_protect();

class DB { 
         
    protected static $instance; 

    protected function __construct() {} 
         
    public static function getInstance() { 
        
		if(empty(self::$instance)) { 
                         
            $db_info = array( 
                            "db_host" => "localhost", 
                            "db_port" => "3306", 
                            "db_user" => "noralest_nora", 
                            "db_pass" => "rahsiajun.228", 
                            "db_name" => "noralest_norales", 
                            "db_charset" => "UTF-8"); 
                        try {                           
                            self::$instance = new PDO("mysql:host=".$db_info['db_host'].';port='.$db_info['db_port'].';dbname='.$db_info['db_name'], $db_info['db_user'], $db_info['db_pass']);
                            self::$instance->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT );   
                            self::$instance->query('SET NAMES utf8'); 
                            self::$instance->query('SET CHARACTER SET utf8'); 

                        } catch(PDOException $e) {   
                            echo $e->getMessage();   
                        }                           
                         
                } 
                 
                return self::$instance; 
         
    } 
    
}
    

class Hierarchy extends DB {
 
    private $db;
	
	public function __construct() {
		//database connection
		$this->db = DB::getInstance(); 
	}
	
	public function do_count($id) {
		$query = $this->db->prepare("SELECT COUNT(id) FROM users WHERE referral_id = $id")->fetchColumn();
		return count($query);
	}
	
	
	
	
	public function generate($id) {
		$query = $this->db->prepare("SELECT * FROM users WHERE referral_id = ? ORDER BY place ASC LIMIT 4");
		$query->bindParam(1, $id, PDO::PARAM_INT);
		$query->execute();
		$query->setFetchMode(PDO::FETCH_ASSOC); //FETCH_ROW 
		
		while($row = $query->fetch()) {   
            echo '<div class="generate"><a href="hierarchy.php?id='. $row['id'] .'">'  . $row['user_name'] . '</a></div>';  
			
        } 
	}
	
	public function first_level($id) {
		$query = $this->db->prepare("SELECT * FROM users WHERE id = ? ORDER BY place ASC LIMIT 1");
		$query->bindParam(1, $id, PDO::PARAM_INT);
		$query->execute();
		$query->setFetchMode(PDO::FETCH_ASSOC); //FETCH_ROW  
        $row = $query->fetch(); 
        echo '<div class="first"><a href="hierarchy.php?id='. $row['id'] .'">'  . $row['user_name'] . '<br/><img src="images/user.png"></a></div>'; 
        
        $query2 = $this->db->prepare("SELECT * FROM users WHERE referral_id = ? AND id != 1 ORDER BY place ASC ".$limit =($id != 1) ? "LIMIT 4" : "");
		$query2->bindParam(1, $row['id'], PDO::PARAM_INT);
		$query2->execute();
		$query2->setFetchMode(PDO::FETCH_ASSOC); //FETCH_ROW 
		
        echo '<table align="center"><tr>';		
		while($row2 = $query2->fetch()) {   
            echo '<td><div class="v_line"></div><div class="generate">';
			
			echo '<a title="'.$row2['user_name'].'"  href="hierarchy.php?id='. $row2['id'] .'">'  . $row2['user_name'] . '<br/><img src="images/user.png"></a>';
			
			if($id != 1) {
				$query3 = $this->db->prepare("SELECT * FROM users WHERE referral_id = ? ORDER BY place ASC LIMIT 4");
				$query3->bindParam(1, $row2['id'], PDO::PARAM_INT);
				$query3->execute();
				$query3->setFetchMode(PDO::FETCH_ASSOC); //FETCH_ROW  
				echo '<table align="center"><tr>';
		        while($row3 = $query3->fetch()) {   
		            echo '<td><div class="third"><a title="'.$row3['user_name'].'" href="hierarchy.php?id='. $row3['id'] .'">'  . substr($row3['user_name'],0,5). '
					<br/><img src="images/user.png"></a></div></td>';    
		        } 	
		       echo '</tr></table>';
			}
				
		   echo	'</div></td>';  
           
 	
			
        } 
        echo '</tr></table>'; 
        
        
	}
	
	public function second_level($id) {
		$query3 = $this->db->prepare("SELECT * FROM users WHERE referral_id = ? ORDER BY place ASC LIMIT 4");
		$query3->bindParam(1, $id, PDO::PARAM_INT);
		$query3->execute();
		$query3->setFetchMode(PDO::FETCH_ASSOC); //FETCH_ROW  
		echo '<table align="center"><tr>';
        while($row3 = $query->fetch()) {   
            echo '<td><div class="generate"><a href="hierarchy.php?id='. $row3['id'] .'">'  . $row3['user_name'] . '</a></div></td>';    
        } 	
		echo '</tr></table>';	
	}
	

	
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <title>NoraLestari Resources - Admin panel</title>
    <meta name="author" content="Azrul Haris">
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/reset.css" type="text/css" media="screen">
    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen">
    <link rel="stylesheet" href="css/layout.css" type="text/css" media="screen">
    <link href='http://fonts.googleapis.com/css?family=Adamina' rel='stylesheet' type='text/css'>   
    <script src="js/jquery-1.6.3.min.js" type="text/javascript"></script>
    <script src="js/cufon-yui.js" type="text/javascript"></script>
    <script src="js/cufon-replace.js" type="text/javascript"></script>
    <script src="js/Lobster_13_400.font.js" type="text/javascript"></script>
    <script src="js/NewsGoth_BT_400.font.js" type="text/javascript"></script>
    <script src="js/FF-cash.js" type="text/javascript"></script>
    <script src="js/easyTooltip.js" type="text/javascript"></script>
	<script src="js/script.js" type="text/javascript"></script>
    <script src="js/bgSlider.js" type="text/javascript"></script>
	<!--[if lt IE 7]>
    <div style=' clear: both; text-align:center; position: relative;'>
        <a href="http://windows.microsoft.com/en-US/internet-explorer/products/ie/home?ocid=ie6_countdown_bannercode">
        	<img src="http://storage.ie6countdown.com/assets/100/images/banners/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today." />
        </a>
    </div>
	<![endif]-->
    <!--[if lt IE 9]>
   		<script type="text/javascript" src="js/html5.js"></script>
        <link rel="stylesheet" href="css/ie.css" type="text/css" media="screen">
	<![endif]-->
	
	<style>


td {
	float: left;
}

table {
	
}

table td{
	float: left;
}

.third {
	margin-top: 20px;
	width: 100%;
}
/*
.v_line {
	border-left: 1px solid #000;
	width: 2px;
	margin-left: 108px;
	height: 25px;
}
*/
.generate {
    border: 1px solid #FF7FD4;
	width: 225px;
	float: left;
	height: 160px;	
	text-align: center;
	margin-top: 10px;
	/*background:url(images/user.png) center top no-repeat;*/
	
	overflow: hidden;
}

.generate img, .first img {
	width: 30px;
	text-align: center;
	margin-top: -8px;
}

.generate a {
	/*background:url(images/user.png) center top no-repeat;*/
	text-align: center;
}

.first a {
	/*background:url(images/user.png) center top no-repeat;*/
	text-align: center;
}

.first img {
	/*background:url(images/user.png) center top no-repeat;*/
	text-align: center;
	width: 30px;
}

.first {
	width: 670px;
	text-align: center;
	height: 60px;
	/*background:url(images/user.png) center top no-repeat;*/
	margin-left: auto;
	margin-right: auto;
	/*border-bottom: 1px solid #000;*/
}

.last {
	width: 15%;
	float: left;
	height: 100px;	
}

</style>
</head>
<body id="pageadmin">
	<div id="bgSlider"></div>
    <div class="bg_spinner"></div>
	<div class="extra">
        <!--==============================header=================================-->
        <header>
        	<div class="top-row">
            	<div class="main">
                	<div class="wrapper">
                        <h1><a href="index.html"></a></h1>
                        <ul class="pagination">
                            <li class="current"><a href="images/bg-img2-2.jpg"></a></li>
                        </ul>
                        <strong class="bg-text"></strong>
                    </div>
                </div>
            </div>
            <div class="menu-row">
            	<div class="menu-border">
                	<div class="main">
                        <nav>
                            <ul class="menu">
                                <li><a href="index.php">Main</a></li>
                              
                                <li><a href="admin_index.php">Dashboard</a></li>
                                <li><a href="admin_view_members.php">View Members</a></li>
                                <li><a class="active" href="hierarchy.php?id=1">Hierarchy</a></li>
                        
                                <li><a href="calendar.php">Calendar</a></li>
                                <li class="last"><a href="contacts.php">Contacts</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
			<div class="ic">More Website Templates @ TemplateMonster.com - September 26, 2011!</div>
        </header>
        <!--==============================content================================-->
        <div class="inner">
            <div class="main">
                <section id="content">
                    <div class="indent">
                    	<div class="wrapper">
                        	<article class="col-1">
                                <div class="bg">
                                    <div class="" id="tableDesign">
                                        <?php
                                        $show = new Hierarchy();
                                        if($show->do_count(filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT)) > 0) {
											$show->first_level(filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT));
										} else {
											echo '<h2>There no downline under this user</h2>';
										}
                                        
                                        ?>



                                    </div>
                                </div>
                            </article>
                            
                        </div>
                    </div>
                </section>
                <div class="block"></div>
            </div>
        </div>
    </div>
	<!--==============================footer=================================-->
    <footer>
    	<div class="padding">
        	<div class="main">
                <div class="wrapper">
                	<div class="fleft footer-text">
                    	<span>Nora</span> Lestari
                        <strong>&copy; <?=date("Y")?><a rel="nofollow" class="link" target="_blank" href="http://www.noralestari.com.my/"> Nora Lestari Resources</a></strong>
                        <!-- {%FOOTER_LINK} -->
                    </div>
                    <ul class="list-services">
                    	<li>Link to Us:</li>
                    	<li><a class="tooltips" title="facebook" href="https://www.facebook.com/mkay.nora"></a></li>
                        
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <script type="text/javascript"> Cufon.now(); </script>
</body>
</html>