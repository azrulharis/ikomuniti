<?php echo $this->partial('partials/navigation'); ?> 
<div class="row">
	<div class="col-sm-12">
    	<div class="panel panel-primary"> 
   			<div class="panel-body">
   			    <?php echo $this->getContent(); ?> 
			   <?php foreach ($posts as $post) { ?>
               <div class="row">
	              <div class="clearfix"></div>
	              <a href="/ikomuniti/ioffer/view/<?php echo $post->slug; ?>">
				  <div class="col-md-2 text-center">
				  <img src="<?php echo $ioffer_thumb_dir . $post->image; ?>" class="img-responsive img-thumbnail pull-center">
				  </div>
	              <div class="col-md-6 text-left">
				  <h4><?php echo $post->title; ?></h4>
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
				  <div class="col-md-7 text-left">
				    <i class="fa fa-tags"></i>  <b>RM<?php echo $post->price; ?></b><span style="color: #FF0000; text-decoration:line-through"> <b><?php echo $post->market_price; ?></b></span> 
				  </div> 
				  <div class="col-md-3 text-left">
				     <i class="fa fa-star"></i> Stock <b><?php echo $post->stock; ?></b>
				  </div>
				   
				  <div class="clearfix"></div>
	               
	              <hr>
              </div>
              <?php } ?>
            </div> 
    	</div> 
	</div>
</div>
<?php echo $this->partial('partials/footer'); ?>