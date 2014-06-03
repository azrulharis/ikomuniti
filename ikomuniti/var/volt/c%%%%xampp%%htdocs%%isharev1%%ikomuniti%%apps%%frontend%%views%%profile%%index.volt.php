<?php if ($is_login == 1) { ?>
    <?php echo $this->partial('partials/profile_nav_protect'); ?>
<?php } else { ?>
    <?php echo $this->partial('partials/profile_nav_public'); ?>
<?php } ?>

<?php foreach ($profiles as $profile) { ?> 
<div class="row"> 
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="cover">  
			<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 profile_image">
				<img class="img-responsive img-thumbnail pull-center" src="<?php echo $profile_path . $profile->profile_image; ?>" alt="<?php echo $this->escaper->escapeHtml($profile->username); ?>" title="<?php echo $this->escaper->escapeHtml($profile->username); ?>"/>
			</div>
    		<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 profile_name">
	        <h4><?php if ($has_profile == 1) { ?><?php echo $this->escaper->escapeHtml($profile->display_name); ?><?php } else { ?><?php echo $this->escaper->escapeHtml($profile->username); ?><?php } ?></h4>
	        <p><i class="fa fa-clock-o"></i> Join since <?php echo $profile->created; ?></p>
	        <?php if ($is_login == 1) { ?>
				<?php if ($my_username != $this->escaper->escapeHtml($profile->username)) { ?>
				    <?php echo $this->tag->linkTo(array('messages/index?ref=' . $this->escaper->escapeHtml($profile->username), '<i class="fa fa-envelope-o"></i> Send Message', 'class' => 'btn btn-default')); ?>
				<?php } ?>
	        <?php } ?>
	         
    		</div>	
    		<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 profile_image">
			   <h3 class="pull-center"> 
				"<?php if ($has_profile == 1) { ?>
				  <?php echo $this->escaper->escapeHtml($profile->quote); ?><?php } else { ?>Lets join iShare socialpreneur program and get free Roadtax and Insurance every year!.
				<?php } ?>"            
				</h3>
			</div>
		</div>
    </div> 
</div><!-- end row --> 
<div class="row"> 
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="profile-nav">  
            
		</div>
    </div> 
</div><!-- end row --> 

<div class="row">
    <?php echo $this->getContent(); ?>
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 profile-left">
		<div class="panel-profile left-panel">
            <div class="profile-header">
              <h4><i class="fa fa-tags"></i> Info</h4>
            </div>
		    <div class="panel-body">
		    <?php if ($has_profile == 1) { ?>
				<p><i class="fa fa-suitcase"></i> <span><?php echo $profile->job; ?></span> at <span><?php echo $this->escaper->escapeHtml($profile->company); ?></span></p><hr> 
				<p><i class="fa fa-home"></i> Live in <span><?php echo $this->escaper->escapeHtml($profile->location); ?></span></p><hr>
				<p><i class="fa fa-map-marker"></i> From <span><?php echo $this->escaper->escapeHtml($profile->hometown); ?></span></p><hr>
				<p><i class="fa fa-certificate"></i> Went to <span><?php echo $this->escaper->escapeHtml($profile->school); ?></span></p><hr>
				<?php if ($profile->college != '') { ?><p><i class="fa fa-flask"></i> High Education <span><?php echo $this->escaper->escapeHtml($profile->college); ?></span></p><hr><?php } ?>
				<p><i class="fa fa-gift"></i> Born on <span><?php echo $profile->dob; ?></span></p><hr>
				<?php if ($profile->website != '') { ?><p><i class="fa fa-desktop"></i> Website <span><a href="http://<?php echo $profile->website; ?>" target="_blank"><?php echo $profile->website; ?></a></span></p><?php } ?> 
		    <?php } else { ?>	
			    <p><i class="fa fa-times"></i> <span><?php echo $this->escaper->escapeHtml($profile->username); ?></span> has nothing to share</p>	
			<?php } ?>
			</div>
         </div> 
         
         <div class="panel-profile left-panel">
            <div class="profile-header">
              <h4><i class="fa fa-shopping-cart"></i> <?php if ($has_profile == 1) { ?><?php echo $this->escaper->escapeHtml($profile->display_name); ?><?php } else { ?><?php echo $this->escaper->escapeHtml($profile->username); ?><?php } ?> iMall</h4>
            </div>
		    <div class="panel-body ads"> 
		      <?php $v9755411482iterated = false; ?><?php foreach ($ads as $ad) { ?><?php $v9755411482iterated = true; ?>
		        <?php if ($ad->image != '') { ?>
	                <li class="col-md-6 col-lg-6 col-xs-12">
					    <img class="img-responsive" src="<?php echo $thumb_dir . $ad->image; ?>" alt="<?php echo $this->escaper->escapeHtml($ad->title); ?>" title="<?php echo $this->escaper->escapeHtml($ad->title); ?>"/>
					</li>
	            <?php } else { ?>
	                <li class="col-md-6 col-lg-6 col-xs-12">
					    <img class="img-responsive" src="<?php echo $thumb_dir; ?>no_photo.jpg" alt="<?php echo $this->escaper->escapeHtml($ad->title); ?>" title="<?php echo $this->escaper->escapeHtml($ad->title); ?>"/>
					</li>
	            <?php } ?> 
		      <?php } if (!$v9755411482iterated) { ?> 
		          <p><i class="fa fa-times"></i> <span>
				  <?php if ($has_profile == 1) { ?>
				    <?php echo $this->escaper->escapeHtml($profile->display_name); ?>
				  <?php } else { ?>
				    <?php echo $this->escaper->escapeHtml($profile->username); ?>
				  <?php } ?>
				  </span> has no ads</p>
		      <?php } ?>
			</div>
         </div> 
         
    </div>
    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
	    <div class="panel-profile">
            
		    <div class="panel-body"> 
                
                <?php foreach ($walls as $wall) { ?> 
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 wall">
                   <p><?php if ($profile->profile_image != '') { ?>
	                    <img class="img-responsive pull-left" src="<?php echo $profile_path . $profile->profile_image; ?>" width="50px"/> 
	            	<?php } else { ?> 
					    <img class="img-responsive pull-left" src="<?php echo $profile_path; ?>nophoto.jpg"  width="50px"/> 
					<?php } ?>
					<span><?php if ($has_profile == 1) { ?><?php echo $this->escaper->escapeHtml($profile->display_name); ?><?php } else { ?><?php echo $this->escaper->escapeHtml($profile->username); ?><?php } ?></span> 
					<i class="fa fa-clock-o"></i> On <?php echo $wall->created; ?><br/>
					<?php if ($wall->type == 6) { ?> 
					  Has receive renewal commission.
					<?php } elseif ($wall->type == 1) { ?>
					  Has renew insurance and roadtax with iShare.
					<?php } ?>
					</p>
				</div>
				<div class="clearfix"></div>
				<hr>
	            <?php } ?> 
            </div>
        </div> 
    </div>  
    
    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
	    <div class="panel-profile"> 
	        <div class="profile-header">
                <h4><i class="fa fa-bullhorn"></i> Sponsor Ads</h4>
            </div>
		    <div class="panel-body"> 
                <!-- nuffnang -->
<script type="text/javascript">
        nuffnang_bid = "f20bae427dae947f35ce14e4f2dbfc72";
        document.write( "<div id='nuffnang_ss'></div>" );
        (function() {	
                var nn = document.createElement('script'); nn.type = 'text/javascript';    
                nn.src = 'http://synad2.nuffnang.com.my/ss.js';    
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(nn, s.nextSibling);
        })();
</script>
<!-- nuffnang-->
                        
            </div>
        </div> 
    </div> 
</div>
 
 
<?php } ?> 
<?php echo $this->partial('partials/footer_profile'); ?>