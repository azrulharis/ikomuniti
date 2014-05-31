<?php echo $this->partial('partials/navigation'); ?> 
    <div class="row">
        <div class="col-lg-12">
          
      <div class="panel panel-primary">
        <div class="panel-heading">
		  <h3 class="panel-title">Withdrawals</h3>
		</div>
		  <div class="panel-body">  
			<div class="bs-example">
			  <ul class="breadcrumb" style="margin-bottom: 5px;">
			    <li class="active">Request</li>
				<li><?php echo $this->tag->linkTo(array('gghadmin/withdrawals/proceed', 'Proceed')); ?></li> 
			    <li><?php echo $this->tag->linkTo(array('gghadmin/withdrawals/rejected', 'Rejected')); ?></li>
			    <li><?php echo $this->tag->linkTo(array('gghadmin/withdrawals/success', 'Success')); ?></li> 
			  </ul>
			</div>
	   
		    <?php echo $this->getContent(); ?>
		    <div class="table-responsive">
		      <table class="table table-bordered table-hover table-striped tablesorter"> 
			    <tr>
				 <th>Username</th> <th>Amount</th><th>iPoint Balance</th><th>Bank</th><th>Account</th><th>Created</th><th>Action</th>
			    </tr>
				<?php foreach ($withdraws as $withdraw) { ?>
				<tr>
				    <td><?php echo $withdraw->username; ?></td>
					<td><?php echo $withdraw->amount; ?></td>
					<td><?php echo $withdraw->balance; ?></td>
					<td><?php echo $withdraw->bank; ?></td> 
				    <td><?php echo $withdraw->account; ?></td>
					<td><?php echo $withdraw->created; ?></td>
					<td><?php echo $this->tag->linkTo(array('gghadmin/withdrawals/view/' . $withdraw->w_id, 'View', 'class' => 'btn btn-primary')); ?></td>
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