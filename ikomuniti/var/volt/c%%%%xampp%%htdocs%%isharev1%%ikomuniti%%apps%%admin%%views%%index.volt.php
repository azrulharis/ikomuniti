<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="http://ishare.com.my/ico/favicon.ico">
    <?php echo $this->tag->getTitle(); ?>
    <?php echo $this->tag->stylesheetLink('css/bootstrap.css'); ?> 
    <?php echo $this->tag->stylesheetLink('css/sb-admin.css'); ?>
    <?php echo $this->tag->stylesheetLink('font-awesome/css/font-awesome.min.css'); ?>
	<?php echo $this->tag->stylesheetLink('css/jquery-ui.css'); ?>  
	<?php echo $this->tag->javascriptInclude('js/jquery-1.10.2.js'); ?>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	
	  
	<script>
		$(function() {
		$( "#datepicker_from" ).datepicker({changeMonth: true,
      changeYear: true, dateFormat: "yy-mm-dd", stepMonths: 12});
		});
		$(function() {
		$( "#datepicker_to" ).datepicker({changeMonth: true,
      changeYear: true, dateFormat: "yy-mm-dd", stepMonths: 12});
		});
	</script>
  </head>
  <body>
    
    <?php echo $this->getContent(); ?>
    <!-- JavaScript -->
	
    
    <?php echo $this->tag->javascriptInclude('js/thumbimage.js'); ?>
	<?php echo $this->tag->javascriptInclude('js/jquery-ui.js'); ?>  
    <?php echo $this->tag->javascriptInclude('js/bootstrap.min.js'); ?>
    <!-- Page Specific Plugins -->
    
    <?php echo $this->tag->javascriptInclude('js/raphael-min.js'); ?>
     
  </body>
</html>