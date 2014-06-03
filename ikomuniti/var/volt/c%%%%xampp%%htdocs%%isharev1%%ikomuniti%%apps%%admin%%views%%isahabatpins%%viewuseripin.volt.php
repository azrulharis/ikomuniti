<script type="text/javascript">
$(document).ready(function()
{
    $('#username').autocomplete(
    {
        source: "<?php echo $urlajax; ?>",
        minLength: 2
    });
});
</script>
<?php echo $this->partial('partials/navigation'); ?> 
    <div class="row">
        <div class="col-lg-12">
          
      <div class="panel panel-primary">
        <div class="panel-heading">
		  <h3 class="panel-title">View iSahabat iPin</h3>
		</div>
		  <div class="panel-body">  
			<div class="bs-example">
			  <ul class="breadcrumb" style="margin-bottom: 5px;">
			    <li><?php echo $this->tag->linkTo(array('gghadmin/isahabatpins/index', 'iSahabat iPin')); ?></li>
				<li><?php echo $this->tag->linkTo(array('gghadmin/isahabatpins/add', 'Add iSahabat iPin')); ?></li>
			    <li><?php echo $this->tag->linkTo(array('gghadmin/isahabatpins/transfer', 'Transfer iSahabat iPin')); ?></li>
			    <li class="active">View iSahabat iPin</li>
			    <li><?php echo $this->tag->linkTo(array('gghadmin/isahabatpins/track', 'Track')); ?></li> 
			  </ul>
			</div>
			
		<?php echo $this->getContent(); ?>
		 
         <?php echo $this->tag->form(array('gghadmin/isahabatpins/viewuseripin', 'method' => 'get')); ?> 
        <div class="form-group">
		  <label>iKomuniti Username </label><?php echo $this->tag->textField(array('username', 'id' => 'username', 'class' => 'form-control', 'data-role' => 'none', 'value' => $get_username)); ?> 
		</div>
		 
		  <?php echo $this->tag->submitButton(array('submit', 'value' => 'Search', 'class' => 'btn btn-primary')); ?>
		 
		</form> 
   
 <div class="table-responsive">
		      <table class="table table-bordered table-hover table-striped tablesorter"> 
	    <tr>
		 <th>iPin</th> <th>Used</th> <th>Owner</th>  <th>Transfer History</th><th>Created</th>
	    </tr>
		<?php $v5331358051iterated = false; ?><?php foreach ($epins as $pin) { ?><?php $v5331358051iterated = true; ?>
		<tr>
		    <td><p><?php echo $pin->epin; ?></p></td>
			<td><p><?php if (empty($pin->used_username)) { ?> Available <?php } else { ?> <?php echo $pin->used_username; ?> <?php } ?></p></td>
			<td><p><?php echo $pin->username; ?></p></td> 
		    <td><p><?php echo $pin->last_owner; ?></p></td>
			<td><p><?php echo $pin->created; ?></p></td>
		</tr>
		<?php } if (!$v5331358051iterated) { ?>
		<div class="alert alert-danger alert-dismissable"> 
              No record, please select iKomuniti username to view data.</p>
            </div>
		<?php } ?>
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