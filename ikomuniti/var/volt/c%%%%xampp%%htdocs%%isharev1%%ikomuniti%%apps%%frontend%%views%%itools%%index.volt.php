<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=473945646001405&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<?php echo $this->partial('partials/navigation'); ?>
<div class="row">
	<div class="col-lg-12"> 
		<?php echo $this->tag->linkTo(array('itools/index', 'class' => 'btn btn-primary', '<i class="fa fa-bullhorn"></i> iTool Home')); ?>
		<?php echo $this->tag->linkTo(array('itools/view', 'class' => 'btn btn-success', '<i class="fa fa-bar-chart-o"></i> iTool Statistic')); ?>   
	</div>
</div> <!--/.row -->
<div class="row">        
      <?php echo $this->getContent(); ?> 
	<div class="col-lg-12">   
	   
		<div class="panel panel-primary">
			<div class="panel-heading">
			  <h3 class="panel-title">iTools</h3>
			</div>
			<div class="panel-body">
		      <h4>What is iTool?</h4>
		      <p>iTool is marketing tools develop for iShare community to share referral link on the most popular social network sites like Facebook, Google etc.</p>
		      <div class="form-group">
		        <textarea class="form-control">Jom ketahui rahsia bagaimana mendapatkan Insuran & Cukai Jalan PERCUMA seumur hidup hanya dengan beberapa langkah mudah. http://ishare.com.my/<?php echo $username; ?>
				</textarea>
		      </div>
		      <div class="form-group">
		      <div class="fb-share-button" data-href="http://ishare.com.my/<?php echo $username; ?>" data-type="box_count"></div>
		      </div>
		      
		      <div class="form-group">
		        <textarea class="form-control">Jom ketahui rahsia bagaimana mendapatkan Insuran & Cukai Jalan PERCUMA seumur hidup dan menjana PENDAPATAN PASIF melebihi RM100K hanya dengan beberapa langkah mudah. Layari http://ishare.com.my/<?php echo $username; ?>
				</textarea>
		      </div>
		      <div class="form-group">
		      <div class="fb-share-button" data-href="http://ishare.com.my/<?php echo $username; ?>" data-type="box_count"></div>
		      </div>
			</div>
		</div>
	</div>

	<div class="col-lg-12"> 
		<div class="panel panel-primary">
			<div class="panel-heading">
			  <h3 class="panel-title">Web Tools</h3>
			</div>
			<div class="panel-body"> 
			  <div class="clearfix"></div>
			  <h4>Html Banner</h4>
			  <div class="form-group">
			    <div class="col-lg-4"> 
			    <?php echo $this->tag->image(array('/images/itools/banner_2.jpg', 'class' => 'text-center image-responsive', 'height' => '140')); ?>
			    </div>
			    <div class="col-lg-8"> 
			    <textarea class="form-control"><a href="http://ishare.com.my/<?php echo $username; ?>" target="_blank"><img src="<?php echo $host; ?>images/itools/banner_2.jpg" width="200"></a></textarea>
			    </div> 
			  </div>
			  
			  <div class="clearfix"></div>
			  <h4>Html Banner</h4>
			  <div class="form-group"> 
			    <div class="col-lg-4"> 
			    <?php echo $this->tag->image(array('/images/itools/banner_3.jpg', 'class' => 'text-center image-responsive', 'height' => '140')); ?>
			    </div>
			    <div class="col-lg-8"> 
			    <textarea class="form-control"><a href="http://ishare.com.my/<?php echo $username; ?>" target="_blank"><img src="<?php echo $host; ?>images/itools/banner_3.jpg" width="200"></a></textarea></div> 
			  </div>
			  
			  <div class="clearfix"></div>
			  <h4>Html Banner</h4>
			  <div class="form-group"> 
			    <div class="col-lg-4"> 
			    <?php echo $this->tag->image(array('/images/itools/banner_4.jpg', 'class' => 'text-center image-responsive', 'height' => '140')); ?> 
			    </div> <div class="col-lg-8"> 
			    <textarea class="form-control"><a href="http://ishare.com.my/<?php echo $username; ?>" target="_blank"><img src="<?php echo $host; ?>images/itools/banner_4.jpg" width="200"></a></textarea></div> 
			  </div>
			</div>
		</div>
	</div>
</div>   
<?php echo $this->partial('partials/footer'); ?>