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
			    <li><?php echo $this->tag->linkTo(array('wallets/histories', 'History', 'class' => 'jun_button')); ?></li> 
		        <li><?php echo $this->tag->linkTo(array('wallets/redeem', 'Withdraw', 'class' => 'jun_button')); ?></li>
		    <li class="active">Withdrawal Status</li> 
			<li><?php echo $this->tag->linkTo(array('wallets/transfer', 'Transfer', 'class' => 'jun_button')); ?></li> 
			  </ul>
			</div>
	   
		    <?php echo $this->getContent(); ?>
		    <div class="table-responsive">
		      <table class="table table-bordered table-hover table-striped tablesorter"> 
			    <tr>
				 <th>Amount</th><th>Bank Name</th><th>Account Number</th><th>Date</th><th>Status</th><th>Admin Remark</th>
			    </tr>
				<?php foreach ($status as $hist) { ?>
				<tr> 
					<td><p><?php echo $hist->amount; ?></p></td>
					<td><p><?php echo $hist->bank; ?></p></td>
					<td><p><?php echo $hist->account; ?></p></td>
					<td><p><?php echo $hist->created; ?></p></td>
					<td><p><?php if ($hist->status == 0) { ?>Pending<?php } elseif ($hist->status == 1) { ?>In Progress<?php } elseif ($hist->status == 2) { ?>Rejected<?php } elseif ($hist->status == 3) { ?>Successful<?php } ?></p></td>
					<td><p><?php echo $hist->reason; ?></p></td>
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


