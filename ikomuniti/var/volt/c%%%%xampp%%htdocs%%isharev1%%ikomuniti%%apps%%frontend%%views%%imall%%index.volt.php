<?php echo $this->partial('partials/navigation'); ?> 
<div class="row">
	<div class="col-lg-12">  
  		<div class="panel-body">
		    <?php echo $this->tag->linkTo(array('imall/index', '<i class="fa fa-plus"></i> My Ads', 'class' => 'btn btn-primary')); ?>  
			<?php echo $this->tag->linkTo(array('imall/add', '<i class="fa fa-plus"></i> Post On iMall', 'class' => 'btn btn-success')); ?> 
	    </div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">  
	  <div class="panel panel-primary"> 
  		<div class="panel-body">  
  		     
		     <?php $v20376898181iterated = false; ?><?php foreach ($posts as $post) { ?><?php $v20376898181iterated = true; ?>
               <div class="row">
	              <div class="clearfix"></div>
	              <a href="/ikomuniti/imall/view/<?php echo $post->slug; ?>">
				  <div class="col-md-2 text-center">
				  <?php if ($post->image != '') { ?>
				  	<img src="<?php echo $imall_thumb_image_dir . $post->image; ?>" class="img-responsive img-thumbnail pull-center" width="140">
				  <?php } else { ?>
				    <img src="<?php echo $imall_thumb_image_dir; ?>no_photo.jpg" class="img-responsive img-thumbnail pull-center" width="140">
				  <?php } ?>
				  </div>
	              <div class="col-md-6 text-left">
				  <h4><b><?php echo $post->title; ?></b></h4>
				  </div>
				  </a>
				  <div class="col-md-1 text-left">
				  <h4></h4> 
				  </div>
				  <div class="col-md-3 text-left">
				  <h4><i class="fa fa-clock-o"></i> <?php echo $post->created; ?></h4> 
				  </div> 
				  <div class="col-md-7 text-left">
				    <p><?php echo $post->body; ?>...</p>
				  </div>
				  <div class="col-md-2 text-left">
				     <p>&nbsp;</p>
				  </div>
				  <div class="col-md-5 text-left" style="margin-top: 10px;">
				    <i class="fa fa-bars"></i> <?php echo $post->category; ?>
				  </div>  
				  <div class="col-md-2 text-left" style="margin-top: 10px;">
				    <i class="fa fa-eye"></i> <?php echo $post->hit; ?> Views
				  </div> 
				  <div class="col-md-3 text-left" style="margin-top: 10px;">
				    <?php if ($post->price != 0) { ?><i class="fa fa-tag"></i> <b>RM<?php echo $post->price; ?></b><?php } ?>
				  </div> 
				   
				  <div class="clearfix"></div>
	               
	              <hr>
              </div>
              <?php } if (!$v20376898181iterated) { ?>
              <div class="col-lg-12">
    <div class="alert alert-dismissable alert-danger">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <p>You have no post on iMall yet.</p>
    </div>
  </div>
              <?php } ?> 
	    </div>
	    <?php echo $paginationUrl; ?>
	    </div>
	</div>
</div>

<?php echo $this->partial('partials/footer'); ?>