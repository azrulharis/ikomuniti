<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="iShare Komuniti Area">
    <meta name="author" content="Azrul Haris">
    <link rel="shortcut icon" href="http://ishare.com.my/ico/favicon.ico">

    {{ get_title() }}
    {{ stylesheet_link("css/bootstrap.css") }}   
    {{ stylesheet_link("font-awesome/css/font-awesome.min.css") }}
	{{ stylesheet_link("css/jquery-ui.css") }}  
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	{{ javascript_include("js/jquery-1.10.2.js") }} 
	{{ stylesheet_link("css/sb-admin.css") }}
	{{ stylesheet_link("css/jquery-ui.css") }}  
	<script>
	  $(function() {
		$( "#datepicker" ).datepicker({changeMonth: true,
      changeYear: true, dateFormat: "yy-mm-dd", stepMonths: 12});
		});
	</script>
  </head>
  <body>
    
    {{ content() }} 
	{{ javascript_include("js/jquery-ui.js") }}  
    {{ javascript_include("js/bootstrap.js") }} 
    {{ javascript_include("js/raphael-min.js") }}  
  </body>
</html>