<?php echo $this->partial('partials/navigation'); ?>
<div class="row">
    <div class="col-lg-8"> 
    	<div class="panel panel-primary">
           <div class="panel-heading">iPrihatin</div>
   			<div class="panel-body">
   			
			      <?php echo $this->tag->linkTo(array('gghadmin/iprihatin/index', 'iPrihatin', 'class' => 'btn btn-primary')); ?>
				  <?php echo $this->tag->linkTo(array('gghadmin/iprihatin/add', 'New Post', 'class' => 'btn btn-success')); ?>
				  <?php foreach ($iprihatins as $iprihatin) { ?>
				  
				  
				    <div class="jun_view_iprihatin"> 
				    <?php echo $this->getContent(); ?>
					    
				        <h4><?php echo $this->tag->linkTo(array('gghadmin/iprihatin/view/' . $iprihatin->slug, $iprihatin->title)); ?></h4>
				        <?php if (!(empty($iprihatin->image))) { ?>
						    <?php echo $this->tag->image(array('uploads/iprihatins/' . $iprihatin->image, 'class' => 'img-responsive imall_image')); ?> 
						<?php } ?>
						   
				        <p>Tarikh <?php echo $iprihatin->created; ?></p><p>Jumlah Sumbangan <b>RM<?php echo $iprihatin->amount; ?></b></p>
				        <?php echo $this->tag->linkTo(array('gghadmin/iprihatin/edit/' . $iprihatin->slug, 'Edit This Post', 'class' => 'btn btn-danger')); ?>
				        <pre><?php echo $iprihatin->body; ?></pre>
					         
					<?php } ?>
            </div> 
        </div> 
    </div>
	</div>
	<div class="col-lg-4"> 
		 <div class="bs-example wgreen">
          <div class="list-group">
            <a href="/ishare/isharephal/iprihatin/index" class="list-group-item active">
              <i class="glyphicon glyphicon-info-sign"></i>  iPrihatin
            </a>
            <?php foreach ($rights as $right) { ?>
            <a href="/ishare/isharephal/gghadmin/iprihatin/view/<?php echo $right->slug; ?>" class="list-group-item"><h4><?php echo $right->title; ?></h4> 
			<p class="list-group-item-text"><?php echo $right->body; ?>...</p>
			</a> 
            <?php } ?>
            <a href="/ishare/isharephal/gghadmin/iprihatin/index" class="list-group-item"> View All 
                  <i class="fa fa-arrow-circle-right"></i> 
          </a>
          </div>
        </div> 
	</div> 
</div>
<?php echo $this->partial('partials/footer'); ?>