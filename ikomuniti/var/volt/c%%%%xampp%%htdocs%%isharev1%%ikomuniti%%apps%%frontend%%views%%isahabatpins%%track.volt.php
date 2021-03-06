<?php echo $this->partial('partials/navigation'); ?> 
    <div class="row">
        <div class="col-lg-12">
          
      <div class="panel panel-primary">
        <div class="panel-heading">
		  <h3 class="panel-title">iSahabat iPin Tracking</h3>
		</div>
	  <div class="panel-body">
	  
	  <div class="bs-example">
        <ul class="breadcrumb" style="margin-bottom: 5px;">
	    <li><?php echo $this->tag->linkTo(array('isahabatpins/index', 'iSahabat iPin')); ?></li> 
	    <li><?php echo $this->tag->linkTo(array('isahabatpins/transfer', 'Transfer iPin')); ?></li>
	    <li class="active">Track</li>
	  </ul>
      </div>
    <?php echo $this->getContent(); ?>
     
      
    <div class="table-responsive">
      <table class="table table-bordered table-hover table-striped tablesorter"> 
	    <tr> 
		 <th>iPin</th> <th>Transfer To</th><th>Created</th>  
	    </tr>
		<?php foreach ($epins as $pin) { ?>
		<tr> 
			<td><p><?php echo $pin->epin; ?></p></td>
			<td><p><?php echo $pin->username; ?></p></td> 
			<td><p><?php echo $pin->created; ?></p></td> 
		</tr>
		<?php } ?>
		</table>
	</div>
        <div class="row">
			<?php echo $paginationUrl; ?>
		</div>
	  </div>
	  </div>
</div></div> 
<?php echo $this->partial('partials/footer'); ?>