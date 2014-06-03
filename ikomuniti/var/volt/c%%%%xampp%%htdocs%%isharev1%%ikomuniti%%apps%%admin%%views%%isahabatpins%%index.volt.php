<?php echo $this->partial('partials/navigation'); ?> 
    <div class="row">
        <div class="col-lg-12">
          
      <div class="panel panel-primary">
        <div class="panel-heading">
		  <h3 class="panel-title">iSahabat iPin</h3>
		</div>
		  <div class="panel-body">  
			<div class="bs-example">
			  <ul class="breadcrumb" style="margin-bottom: 5px;">
			    <li class="active">iSahabat iPin</li>
				<li><?php echo $this->tag->linkTo(array('gghadmin/isahabatpins/add', 'Add iSahabat iPin')); ?></li>
			    <li><?php echo $this->tag->linkTo(array('gghadmin/isahabatpins/transfer', 'Transfer iSahabat iPin')); ?></li>
			    <li><?php echo $this->tag->linkTo(array('gghadmin/isahabatpins/viewuseripin', 'View iSahabat iPin')); ?></li>
			    <li><?php echo $this->tag->linkTo(array('gghadmin/isahabatpins/track', 'Track')); ?></li>  
			  </ul>
			</div>
	   
		    <?php echo $this->getContent(); ?>
		    <div class="table-responsive">
		      <table class="table table-bordered table-hover table-striped tablesorter"> 
			    <tr>
				 <th>iPin</th> <th>Status</th> <th>Owner</th>  <th>Transfer History</th><th>Created</th>
			    </tr>
				<?php foreach ($epins as $pin) { ?>
				<tr>
				    <td><p><?php echo $pin->epin; ?></p></td>
					<td><p><?php if ($pin->used_user_id == 0) { ?>Active<?php } ?></p></td>
					<td><p><?php echo $pin->username; ?></p></td> 
				    <td><p><?php echo $pin->last_owner; ?></p></td>
					<td><p><?php echo $pin->created; ?></p></td>
				</tr>
				<?php } ?>
				</table>
			  </div>
		</div>
    </div>
  </div>
</div> 
		
  	
<div class="row">
  <div class="col-lg-12">
    <?php echo $paginationUrl; ?>
  </div>
</div>

<?php echo $this->partial('partials/footer'); ?>