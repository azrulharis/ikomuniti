 
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Azrul Haris">
    <link rel="shortcut icon" href="http://ishare.com.my/ico/favicon.ico">

    {{ get_title() }}

    <!-- Bootstrap core CSS -->
    {{ stylesheet_link("css/bootstrap.css") }}  
    <link href='http://fonts.googleapis.com/css?family=Dancing+Script' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Questrial' rel='stylesheet' type='text/css'> 

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Custom styles for this template -->
    {{ stylesheet_link("css/carousel.css") }}  
    {{ stylesheet_link("font-awesome/css/font-awesome.min.css") }}  
    <!-- Least -->
    {{ stylesheet_link("css/least.min.css") }} 
    {{ javascript_include("js/jquery-1.10.2.js") }}
    {{ stylesheet_link("css/jquery-ui.css") }}
    {{ javascript_include("js/jquery-ui.js") }}
 
    <script>
  $(function() {
		$( "#datepicker1" ).datepicker({changeMonth: true,
      changeYear: true, dateFormat: "yy-mm-dd", stepMonths: 12});
		});
  </script>
  <script>
  $(function() {
		$( "#datepicker2" ).datepicker({changeMonth: true,
      changeYear: true, dateFormat: "yy-mm-dd", stepMonths: 12});
		});
  </script>
  <script>
  $(function() {
		$( "#datepicker3" ).datepicker({changeMonth: true,
      changeYear: true, dateFormat: "yy-mm-dd", stepMonths: 12});
		});
  </script>
	<script type="text/javascript">
        $(function() {
            $('#no_engin').click(function() {
	        $('.no_engin').toggle();
	        return false;
            });
            $('#no_chasis').click(function() {
	        $('.no_chasis').toggle();
	        return false;
            });
            $('#no_siri').click(function() {
	        $('.no_siri').toggle();
	        return false;
            });
            $('#pra_daftar').click(function() {
	        $('.pra_daftar').toggle();
	        return false;
            });
            $('#e_pin').click(function() {
	        $('.e_pin').toggle();
	        return false;
            });
            $('#online_banking').click(function() {
	        $('.online_banking').toggle();
	        return false;
            });
        });
        
    </script>
  </head>
<!-- NAVBAR
================================================== -->
  <body>
       <!-- Fixed navbar -->
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">{{ image('img/logo.png')}}</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="http://ishare.com.my/index.html"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="http://ishare.com.my/mengenai.html"><i class="fa fa-question-circle"></i> Mengenai iShare</a></li>
            <li><a href="http://ishare.com.my/pages/ireseller"><i class="fa fa-thumb-tack"></i> iReseller</a></li> 
            <li><a href="http://ishare.com.my/hubungi.html"><i class="fa fa-phone"></i> Hubungi iShare</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">iShare <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="http://ishare.com.my/imall"><i class="fa fa-shopping-cart"></i> iMall</a></li>
                <li><a href="http://ishare.com.my/pages/ioffer"><i class="fa fa-tag"></i> iOffer</a></li>
				<li><a href="http://ishare.com.my/pages/igaleri"><i class="fa fa-camera"></i> iGaleri</a></li> 
	            <li><a href="http://ishare.com.my/pages/iprihatin"><i class="fa fa-gift"></i> iPrihatin</a></li>
	            <li><a href="http://ishare.com.my/pages/ipartner"><i class="fa fa-map-marker"></i> iPartner</a></li> 
              </ul>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="http://ishare.com.my/kelebihan.html"><i class="fa fa-plus"></i> Kelebihan iShare</a></li>
            <li class="active"><a href="http://ishare.com.my/pages/register"><i class="fa fa-edit"></i> Daftar</a></li>
            <li><a href="http://ishare.com.my/ikomuniti"><i class="fa fa-lock"></i> iKomuniti</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>  
    {{ content() }}    
 <!-- FOOTER -->
      <footer> 
        <div class="container">
          <div class="col-lg-3 col-xs-12 col-md-3 col-sm-6">
              <ul>
                  <h3><i class="fa fa-home"></i> Utama</h3>
                  <li><a href="http://ishare.com.my/index.html">Home</a></li>
                  <li><a href="http://ishare.com.my/mengenai.html">Mengenai iShare</a></li>
                  <li><a href="http://ishare.com.my/kelebihan.html">Kelebihan iShare</a></li>
                  <li><a href="http://ishare.com.my/igaleri.html">Galeri</a></li>
                  <li><a href="http://ishare.com.my/hubungi.html">Hubungi</a></li>
              </ul>
          </div>
          <div class="col-lg-2 col-xs-12 col-md-3 col-sm-6">
              <ul>
                  <h3><i class="fa fa-info"></i> iShare</h3>
                  <li><a href="http://ishare.com.my/pages/iprihatin">iPrihatin</a></li> 
                  <li><a href="http://ishare.com.my/imall">iMall</a></li>
                  <li><a href="http://ishare.com.my/pages/ireseller">iReseller</a></li>
                  <li><a href="https://ishare.com.my/ikomuniti">iKomuniti</a></li>
                  <li><a href="http://ishare.com.my/pages/register">Daftar</a></li>
              </ul>
          </div>
          <div class="col-lg-4 col-xs-12 col-md-3 col-sm-6">
          	  <ul>
          	      <h3><i class="fa fa-briefcase"></i> Partner</h3>
                  <li><a href="http://gmn.com.my">Global Medic Network Sdn Bhd</a></li>
				  <li><a href="http://tourismnetwork.com.my/v1">Global Tourism Network Sdn Bhd</a></li>
				  <li><a href="http://fairpark.com.my">Fairpark Corporation Sdn Bhd</a></li>
				  <li><a href="http://synergyrider.com">Fairpark Synergy Sdn Bhd</a></li>
				  <li><a href="http://wardrobe2u.com">Wardrobe2u Boutique</a></li>
              </ul>
          </div>
          <div class="col-lg-3 col-xs-12 col-md-3 col-sm-6">
              <ul>
                  <h3><i class="fa fa-external-link"></i>  Pautan</h3>
                  <li><a href="http://www.takaful-ikhlas.com.my" target="_blank">Takaful Ikhlas</a></li>
                  <li><a href="http://www.crp.com.my" target="_blank">Car Replacement Program</a></li>
                  <li><a href="https://www.touchngo.com.my/" target="_blank">Touch n Go</a></li>
                  <li><a href="http://www.jpj.gov.my/pertanyaan-saman-notis" target="_blank">Semak Saman JPJ</a></li>
				  <li><a href="https://www.rilek.com.my/webapps/pdrm/csform.php" target="_blank">Semak Saman Polis</a></li>
              </ul>
          </div> 
          <div class="col-lg-12">
              <p>Copyright &copy; 2014 Global Group Holdings Sdn Bhd</p>
          </div>
        </div>
      </footer> 
   {{ javascript_include("js/bootstrap.min.js") }} 
  </body>
</html>


