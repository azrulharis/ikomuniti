<script type="text/javascript">
$(document).ready(function()
{   $('#username').autocomplete(
    {   source: "<?php echo $ajaxurl; ?>",
        minLength: 2
    });
});
</script>
<?php echo $this->partial('partials/navigation'); ?>  
<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Add iPoint</h3>
	  </div>
	  <div class="panel-body">  
	     <div class="bs-example">
			  <ul class="breadcrumb" style="margin-bottom: 5px;">
			    <li><?php echo $this->tag->linkTo(array('gghadmin/wallets/index', 'Add iPoint')); ?></li>
				<li class="active">View iPoint</li>
			    <li><?php echo $this->tag->linkTo(array('gghadmin/wallets/deduct', 'Deduct iPoint')); ?></li>
			    <li><?php echo $this->tag->linkTo(array('gghadmin/wallets/admin', 'Request')); ?></li> 
			  </ul>
			</div>
		    <?php echo $this->getContent(); ?>
			<div class="col-xs-12">
		        <form action="" method="GET">
		        <div class="form-group col-xs-6">
				    <?php echo $this->tag->textField(array('username', 'size' => 14, 'id' => 'username', 'class' => 'form-control')); ?>
				</div>
				 
				<div class="form-group col-xs-6">
				<?php echo $this->tag->submitButton(array('submit', 'name' => 'submit', 'value' => 'View', 'class' => 'btn btn-success')); ?>
				</div>
				</form> 
			</div>
			<?php if ($view_hist == 1) { ?>
	        <div class="table-responsive">
		      <table class="table table-bordered table-hover table-striped tablesorter"> 
			    <tr>
				  <th>Title</th> <th>Amount</th><th>Ref</th><th>Date</th><th>PIC</th><th>Type</th>
			    </tr>
				<?php foreach ($hists as $hist) { ?>
				<tr>
				    <td><p><?php echo $hist->title; ?></p></td>
					<td><p><?php echo $hist->amount; ?></p></td> 
				    <td><p><?php echo $hist->ref; ?></p></td>
					<td><p><?php echo $hist->created; ?></p></td>
					<td><p><?php echo $hist->pic_username; ?></p></td>
					<td><p><?php echo $hist->type; ?></p></td>
				</tr>
				<?php } ?> 
				<?php foreach ($wallets as $wallet) { ?>
				<tr>
				    <td><p>Balance</p></td>
					<td><p><b>RM<?php echo $wallet->amount; ?></b></p></td>
					<td></td> 
				    <td></td>
					<td></td>
					<td></td>
				</tr>
				<?php } ?>
				</table>
			  </div>
			  <?php } else { ?> 
			      <div class="alert alert-dismissable alert-warning">
	                <button type="button" class="close" data-dismiss="alert">&times;</button>
	                 Please select username to view iPoint and transaction hostory.
	              </div>

			  <?php } ?>
	     </div>        
      </div>
    </div>   
</div>
<div class="row">
	    <div class="col-lg-12">
	        <?php if ($view_hist == 1) { ?>
	            <?php echo $paginationUrl; ?>
	        <?php } ?>
	    </div>
	</div>  
<?php echo $this->partial('partials/footer'); ?>