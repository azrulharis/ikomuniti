<script>
setInterval(function(){
        $("#blink").toggleClass("backgroundRed");
     },160)
</script>
<style>
.backgroundRed {
	color: #E03636;
}
</style>
<?php echo $this->partial('partials/navigation'); ?>
<?php foreach ($informations as $info) { ?>
  <?php foreach ($users as $user) { ?>
<div class="row" style="margin-bottom: 10px;">
<?php if ($my_profile == 0) { ?>
  <div class="col-lg-12">
    <div class="alert alert-dismissable alert-danger">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <p>You have not completed your profile information yet, please fill your information by clicking <b><?php echo $this->tag->linkTo(array('settings/profile', 'here')); ?></b>.</p>
    </div>
  </div>
<?php } ?>
  <div class="col-lg-4 col-xs-12">
    <h3><i class="fa fa-trophy"></i> Achievement: <?php echo $event; ?></h3>
  </div>
  <div class="col-lg-4 col-xs-12"> 
	<h4 style="padding-top: 14px;">Status: 
	  <?php if ($user->role == 0) { ?> iSahabat 
	  <?php } elseif ($user->role == 1) { ?> iKomuniti
	  <?php } elseif ($user->role == 2) { ?> iReseller
	  <?php } elseif ($user->role == 4) { ?> iCreator
	  <?php } elseif ($user->role == 5) { ?> iAccount 
	  <?php } elseif ($user->role == 6) { ?> iManager
	  <?php } elseif ($user->role == 7) { ?> iDeveloper
	  <?php } ?>
	</h4> 
  </div>
   
  <div class="col-lg-4 pull-right text-right">
<?php if ($user->role >= 1) { ?>    
<?php echo $this->tag->linkTo(array('itakaful/index', '<button type="button" class="btn btn-primary btn-lg right-button">
  <i class="fa fa-umbrella"></i> iTakaful
</button>')); ?>

<?php echo $this->tag->linkTo(array('imall/add', '<button type="button" class="btn btn-success btn-lg right-button">
  <i class="fa fa-plus-circle"></i> Post On iMall
</button>')); ?>
<?php } ?>
<?php if ($user->role == 0) { ?>
<?php echo $this->tag->linkTo(array('isahabat/index', '<button type="button" class="btn btn-primary btn-lg right-button">
  <i class="glyphicon glyphicon-new-window"></i> Compare
</button>')); ?>

<?php echo $this->tag->linkTo(array('isahabat/upgrade', '<button type="button" class="btn btn-success btn-lg right-button">
  <i class="glyphicon glyphicon-new-window"></i> Upgrade To iKomuniti
</button>')); ?>
<?php } ?>
  </div>
  <hr>
</div><!-- /.row -->
        
<?php if ($user->role == 0) { ?> 
    <?php echo $this->partial('partials/isahabat_dashboard_box'); ?>
<?php } else { ?>
    <?php echo $this->partial('partials/ikomuniti_dashboard_box'); ?>
<?php } ?>
        
        <div class="row">
          
          <div class="col-lg-4">
            <div class="bs-example">
              <div class="list-group">
                <a href="#" class="list-group-item active">
                  <i class="fa fa-wheelchair"></i> iPrihatin
                </a>
                <?php foreach ($iprihatins as $iprihatin) { ?>
                <a href="/ikomuniti/iprihatin/view/<?php echo $iprihatin->slug; ?>" class="list-group-item"><?php echo $iprihatin->title; ?>
				<p class="list-group-item-text"><?php echo $iprihatin->body; ?>... </p>
				<span class="fa fa-clock-o"></span> On <?php echo $iprihatin->created; ?>
				</a> 
                <?php } ?>
                <a href="/ikomuniti/iprihatin/index" class="list-group-item"> View All 
                      <i class="fa fa-arrow-circle-right"></i> 
              </a>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="bs-example wgreen">
              <div class="list-group">
                <a href="/ikomuniti/news/index" class="list-group-item active">
                  <i class="fa fa-bullhorn"></i>  iNews
                </a>
                <?php foreach ($news as $inews) { ?>
                <a href="/ikomuniti/news/view/<?php echo $inews->slug; ?>" class="list-group-item"><?php echo $inews->title; ?>
				<p class="list-group-item-text"><?php echo $inews->body; ?>...</p>
				<span class="fa fa-clock-o"></span> <?php echo $inews->created; ?>
				</a> 
                <?php } ?>
                <a href="/ikomuniti/news/index" class="list-group-item"> View All 
                      <i class="fa fa-arrow-circle-right"></i> 
              </a>
              </div>
            </div> 
          </div>
          <div class="col-md-4 col-sm-6">
    	<div class="panel panel-primary">
           <a href="/ikomuniti/ioffer/index" class="list-group-item active">
                  <i class="fa fa-tags"></i>  iOffer
                </a>
   			  <div class="panel-body">
              <?php foreach ($offers as $offer) { ?>
              <div class="clearfix"></div>
              <div class="col-xs-4 text-center">
              <?php echo $this->tag->image(array('uploads/ioffers/thumbnails/' . $offer->image, 'class' => 'img-responsive img-thumbnail pull-center')); ?>
			  </div>
              <p style="margin-left: 3px;"><b><?php echo $this->tag->linkTo(array('ioffer/view/' . $offer->slug, $offer->title)); ?>...</b></p>
              <span class="fa fa-clock-o"></span> <?php echo $offer->created; ?>
              <div class="clearfix"></div>
              <hr>
              <?php } ?>
              
            </div>
         </div> 
    </div><!--/articles-->
    </div>
    
        </div> 

 
        <?php } ?>
<?php } ?>
<?php echo $this->partial('partials/footer'); ?>