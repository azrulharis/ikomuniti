<?php echo $this->partial('partials/navigation'); ?> 
<?php foreach ($iprihatins as $iprihatin) { ?>
<div class="row">
	<div class="col-lg-8"> 
		<?php echo $this->getContent(); ?>
		
		<div class="panel panel-success">
			<div class="panel-heading">
			<h3 class="panel-title"><?php echo $this->tag->linkTo(array('iprihatin/index', 'iPrihatin')); ?></h3>
			</div>
			<div class="panel-body">
			
			<h4><?php echo $iprihatin->title; ?></h4>
			 
			<p>
			<span class="fa fa-clock-o"></span> Posted on <?php echo $iprihatin->created; ?></p>
			<hr>
			
			<div class="row">
			 <div class="col-xs-12">
			  <div id="jun_images" class="col-lg-8">
				<?php if (!(empty($iprihatin->image))) { ?>
				    <img src="<?php echo $iprihatin_upload_dir; ?><?php echo $iprihatin->image; ?>" class="img-responsive imall_image">
				<?php } else { ?>
					<img src="<?php echo $iprihatin_upload_dir; ?>no_photo.jpg" class="img-responsive imall_image">
				<?php } ?>
			  </div>
			 </div>
			</div>
			
			<div class="jun_post_body">
			    <pre><?php echo $iprihatin->body; ?></pre> 
		    </div>
			</div>
		</div>
		 
	</div>
 
	<div class="col-lg-4"> 
	 <div class="panel panel-success">
		<div class="panel-heading">
		  <h3 class="panel-title">iPrihatin Donation</h3>
		</div>
		<div class="panel-body text-justify">
		  <h4>iPoint Balance: <?php echo $mywallet; ?></h4>
		  <?php echo $this->tag->image(array('images/sedekah.jpg', 'class' => 'img-responsive')); ?>
		  <p class="text-justify">Dari Abu Hurairah : Sesungguhnya Rasulullah s.a.w bersabda “Tidaklah harta menjadi berkurang kerana sedekah, dan tidaklah seseorang yang memberi maaf kepada orang lain, melainkan Allah akan menambah kehormatan kepada dirinya; dan seseorang tiada bersikap merendah diri kerana Allah , melainkan ia akan diangkat darjatnya oleh Allah.”
( HR Muslim dan Tirmidzi )</p>
		  <form action="" method="post">
		  <div class="form-group">
		    <label>Amount</label>
		    <input type="text" name="donate_amount" placeholder="0.00" class="form-control">
		    <input type="hidden" name="iprihatin_id" value="<?php echo $iprihatin->id; ?>">
		  </div>
		  <div class="form-group"> 
		    <input type="submit" name="submit" value="Donate" class="btn btn-success" onclick="return confirm('Are you sure?')">
		  </div>
		</div>
	  </div> 
	</div>
</div>
<?php } ?>  
<?php echo $this->partial('partials/footer'); ?>