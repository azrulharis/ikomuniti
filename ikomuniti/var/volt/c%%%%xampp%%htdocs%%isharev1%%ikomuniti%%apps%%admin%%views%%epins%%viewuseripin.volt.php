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
		  <h3 class="panel-title">iPin informations</h3>
		</div>
		  <div class="panel-body">  
			<div class="bs-example">
			  <ul class="breadcrumb" style="margin-bottom: 5px;">
			    <li><?php echo $this->tag->linkTo(array('gghadmin/epins/index', 'iPin', 'class' => 'jun_button')); ?></li>
				<li><?php echo $this->tag->linkTo(array('gghadmin/epins/add', 'Add iPin', 'class' => 'jun_button')); ?></li>
			    <li><?php echo $this->tag->linkTo(array('gghadmin/epins/transfer', 'Transfer iPin', 'class' => 'jun_button')); ?></li>
			    <li class="active">View iKomuniti iPin</li>
			    <li><?php echo $this->tag->linkTo(array('gghadmin/epins/track', 'Track', 'class' => 'jun_button')); ?></li> 
			  </ul>
			</div>
			
		<?php echo $this->getContent(); ?>
		 
         <?php echo $this->tag->form(array('gghadmin/epins/viewuseripin', 'method' => 'get')); ?> 
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
		<?php $v19927212531iterated = false; ?><?php foreach ($epins as $pin) { ?><?php $v19927212531iterated = true; ?>
		<tr>
		    <td><p><?php echo $pin->epin; ?></p></td>
			<td><p><?php if (empty($pin->used_username)) { ?> Available <?php } else { ?> <?php echo $pin->used_username; ?> <?php } ?></p></td>
			<td><p><?php echo $pin->username; ?></p></td> 
		    <td><p><?php echo $pin->last_owner; ?></p></td>
			<td><p><?php echo $pin->created; ?></p></td>
		</tr>
		<?php } if (!$v19927212531iterated) { ?>
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