<script>
$(function() {
$( "#datepicker_from" ).datepicker({changeMonth: true,
changeYear: true, dateFormat: "yy-mm-dd", stepMonths: 12});
});
$(function() {
$( "#datepicker_to" ).datepicker({changeMonth: true,
changeYear: true, dateFormat: "yy-mm-dd", stepMonths: 12});
});
</script>

<?php echo $this->partial('partials/navigation'); ?> 
    <div class="row">
        <div class="col-lg-12">
          
      <div class="panel panel-primary">
        <div class="panel-heading">
		  <h3 class="panel-title">Transaction Histories</h3>
		</div>
		  <div class="panel-body">  
			<div class="bs-example">
			  <ul class="breadcrumb" style="margin-bottom: 5px;">
			    <li><?php echo $this->tag->linkTo(array('wallets/index', 'iPoint', 'class' => 'jun_button')); ?></li>
			    <li class="active">History</li>
		        <li><?php echo $this->tag->linkTo(array('wallets/redeem', 'Withdraw', 'class' => 'jun_button')); ?></li>
		    <li><?php echo $this->tag->linkTo(array('wallets/status', 'Withdrawal Status', 'class' => 'jun_button')); ?></li> 
			<li><?php echo $this->tag->linkTo(array('wallets/transfer', 'Transfer', 'class' => 'jun_button')); ?></li> 
			  </ul>
			</div>
			<div class="panel panel-primary"><div class="panel-body"> 
		        <form action="" method="GET">
		        <div class="form-group col-md-4">
		            <input type="text" name="date_from" class="form-control" id="datepicker_from" size="30" placeholder="YYYY-MM-DD">
		        </div>
		        <div class="form-group col-md-4">
		            <input type="text" name="date_to" class="form-control" id="datepicker_to" size="30" placeholder="YYYY-MM-DD">
		        </div>
		        <div class="form-group col-md-4">
		            <input type="submit" name="submit" value="Search" class="btn btn-success">
		        </div>
	        </div></div>
		    <?php echo $this->getContent(); ?>
		    <div class="table-responsive">
		      <table class="table table-bordered table-hover table-striped tablesorter"> 
			    <tr>
				 <th>Title</th> <th>Amount</th> <th>Reference</th> <th>Created</th> <th>Type</th>
			    </tr>
				<?php foreach ($views as $hist) { ?>
				<tr>
				    <td><p><?php echo $hist->title; ?></p></td>
					<td><p><?php echo $hist->amount; ?></p></td> 
					<td><p><?php echo $hist->reference; ?></p></td>
					<td><p><?php echo $hist->created; ?></p></td>
					<td><p><?php echo $hist->type; ?></p></td>
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


