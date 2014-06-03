<?php echo $this->partial('partials/navigation'); ?>
<div class="row">         
 
  <div class="col-lg-12">
    <div class="bs-example wgreen">
      <div class="list-group">
        <a href="/ikomuniti/notifications/index" class="list-group-item active">
          <i class="fa fa-warning"></i> Notifications
        </a>
        <?php foreach ($notifications as $notification) { ?>
        <a href="/ikomuniti/notifications/view/<?php echo $notification->id; ?>" class="list-group-item"> 
		<p class="list-group-item-text"><?php echo $notification->body; ?></p>
		<span class="fa fa-time"></span> On <?php echo $notification->created; ?>
		</a> 
        <?php } ?>
        <a href="/ikomuniti/notifications/index" class="list-group-item"> Back 
              <i class="fa fa-arrow-circle-right"></i> 
      </a>
      </div>
    </div> 
  </div>
  
</div> 
<?php echo $this->partial('partials/footer'); ?>