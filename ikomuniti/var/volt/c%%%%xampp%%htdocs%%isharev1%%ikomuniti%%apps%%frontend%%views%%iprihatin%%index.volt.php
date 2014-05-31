<?php echo $this->partial('partials/navigation'); ?> 
<div class="row">
	<div class="col-md-12 col-sm-12">
    	<div class="panel panel-primary">
       		<a href="/ishare/isharephal/ioffer/index" class="list-group-item active">
            	<i class="glyphicon glyphicon-info-sign"></i>  iPrihatin
            </a>
   			<div class="panel-body">
   			    <?php echo $this->getContent(); ?>
				 
			   <?php foreach ($iprihatins as $iprihatin) { ?>
               <div class="row">
	              <div class="clearfix"></div>
	              <a href="view/<?php echo $iprihatin->slug; ?>">
				  <div class="col-md-2 text-center">
				  <?php if ($iprihatin->image != '') { ?>
				  	<img src="<?php echo $iprihatin_thumb_dir . $iprihatin->image; ?>" class="img-responsive img-thumbnail pull-center" width="120">
				  <?php } else { ?>
				  	<img src="<?php echo $iprihatin_thumb_dir; ?>no_photo.jpg" class="img-responsive img-thumbnail pull-center" width="120">
				  <?php } ?>
				  </div>
	              <div class="col-md-6 text-left">
				  <h4><?php echo $iprihatin->title; ?></h4>
				  </div>
				  </a>
				  <div class="col-md-1 text-left">
				  <h4></h4> 
				  </div>
				  <div class="col-md-3 text-left">
				  <h4><i class="fa fa-clock-o"></i> <?php echo $iprihatin->created; ?></h4> 
				  </div> 
				  <div class="col-md-7 text-left">
				    <p><?php echo $iprihatin->body; ?>...</p>
				  </div>
				  <div class="col-md-2 text-left">
				     <p>&nbsp;</p>
				  </div>
				  <div class="col-md-10 text-left">
				     
				  </div> 
				  
				   
				  <div class="clearfix"></div>
	               
	              <hr>
              </div>
              <?php } ?>
                <div class="row">
					<?php echo $paginationUrl; ?>
				</div>
            </div> 
    	</div> 
	</div>
</div>
<?php echo $this->partial('partials/footer'); ?>








