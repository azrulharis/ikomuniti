<?php echo $this->partial('partials/navigation'); ?> 
<div class="row">
	<div class="col-lg-12">  
  		<div class="panel-body">
		    <?php echo $this->tag->linkTo(array('ipartner/index', '<i class="fa fa-plus"></i> My iPartner', 'class' => 'btn btn-primary')); ?>  
			<?php echo $this->tag->linkTo(array('ipartner/add', '<i class="fa fa-plus"></i> Post New iPartner', 'class' => 'btn btn-success')); ?> 
	    </div>
	</div>
</div>
    <div class="row">
        <div class="col-lg-12">
          <div class="panel panel-primary"> 
	         <div class="panel-body">       
				  <?php echo $this->getContent(); ?>
			<?php $v1637592481iterated = false; ?><?php foreach ($posts as $post) { ?><?php $v1637592481iterated = true; ?>
               <div class="row">
	              <div class="clearfix"></div>
	              <a href="/ikomuniti/ipartner/view/<?php echo $post->slug; ?>">
				  <div class="col-md-2 text-center">
				  <?php if ($post->image != '') { ?>
				  	<img src="<?php echo $ipartner_thumb_dir . $post->image; ?>" class="img-responsive img-thumbnail pull-center">
				  <?php } else { ?>
				    <img src="<?php echo $ipartner_thumb_dir; ?>no_photo.jpg" class="img-responsive img-thumbnail pull-center">
				  <?php } ?>
				  </div>
	              <div class="col-md-7 text-left">
				  <h4><b><?php echo $this->escaper->escapeHtml($post->title); ?></b></h4>
				  </div>
				  </a> 
				  <div class="col-md-3 text-left">
				   <i class="fa fa-clock-o"></i> <?php echo $post->created; ?><br/>
				   
				   <i class="fa fa-home"></i> <?php echo $post->category; ?>
				  </div> 
				  <div class="col-md-7 text-left"> 
				    <p><?php echo $this->escaper->escapeHtml($post->body); ?>...</p>
					<i class="fa fa-tags"></i> Discount <?php echo $this->escaper->escapeHtml($post->discount); ?><br/>
				  </div>
				  <div class="col-md-2 text-left">
				     <p>&nbsp;</p>
				  </div>
				  <div class="col-md-7 text-left" style="margin-top: 10px;">
				     
				  </div> 
				  <div class="col-md-3 text-left" style="margin-top: 10px;">
				    
				  </div> 
				   
				  <div class="clearfix"></div>
	               
	              <hr>
              </div>
              <?php } if (!$v1637592481iterated) { ?>
              <div class="col-lg-12">
    <div class="alert alert-dismissable alert-danger">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <p>You have no post on iPartner yet.</p>
    </div>
  </div>
              <?php } ?> 
              </div>
        </div>
    </div>
</div> 
<?php echo $this->partial('partials/footer'); ?>