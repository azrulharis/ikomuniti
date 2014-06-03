<?php echo $this->partial('partials/navigation'); ?> 
<div class="row"> 
  	<div class="col-lg-4"> 
		<div class="well"> 
			<form class="form" action="" method="GET">
			<h4>Search</h4>
				<div class="input-group text-center">
				<input name="query" type="text" class="form-control input-lg" placeholder="Username/Reg No/Phone">
				<span class="input-group-btn"><button name="submit" class="btn btn-lg btn-primary" type="submit">OK</button></span>
				</div>
			</form>
		</div> 
	</div>
	<div class="col-lg-4">
	    <div class="well form">
		  <form action="" method="GET">
	      	<h4>From date</h4>
			  <div class="form-group text-center"> 
			  <input type="text" name="from" id="datepicker_from" class="form-control input-lg"> 
			</div>
	  	</div>
	</div>
	<div class="col-lg-4"> 
		<div class="well form">  
			<h4>To date</h4>
				<div class="input-group text-center">
				<input name="to" type="text" class="form-control input-lg" id="datepicker_to">
				<span class="input-group-btn"><button name="submit_date" class="btn btn-lg btn-primary" type="submit">Go</button></span>
				</div>
			</form>
		</div> 
	</div>
</div>     
 <div class="row">
        <div class="col-lg-12">
          
      <div class="panel panel-primary">
        <div class="panel-heading">
		  <h3 class="panel-title">Need To Update</h3>
		</div>
		  <div class="panel-body">  
      
      <div class="bs-example">
		  <ul class="breadcrumb" style="margin-bottom: 5px;">
	        <li class="active">iManagement <b><?php echo $count_imanagement; ?></b></li> 
	      <li><?php echo $this->tag->linkTo(array('gghadmin/insuran/quotation', 'Updated')); ?></li>
		  <li><?php echo $this->tag->linkTo(array('gghadmin/insuran/kiv', 'Kiv')); ?></li>
	      <li><?php echo $this->tag->linkTo(array('gghadmin/insuran/problems', 'Problems')); ?></li>
	      <li><?php echo $this->tag->linkTo(array('gghadmin/insuran/done', 'Done')); ?></li>
	      </ul>
      </div> 
	  <?php echo $this->getContent(); ?>     
	   <div class="alert alert-info alert-dismissable">
	      Senarai kereta yang akan tamat tempoh dalam masa 1 bulan. Selepas update, ia akan pindah ke bahagian Updated untuk proses Renewal. Merah menandakan iSahabat.
	    </div>
	   <div class="table-responsive">
		      <table class="table table-bordered table-hover table-striped tablesorter"> 
	    <tr>
	    <th>Username</th><th>Reg No</th><th>Telephone</th> <th>Due</th> <th>Insuran</th> <th>Roadtax</th> <th>Wallet</th> <th>Total</th> <th>Year</th> <th>Action</th>
	    </tr>
		<?php foreach ($views as $post) { ?>
		<tr <?php if ($post->role == 3) { ?>class="danger"<?php } ?>>
		    
			<td><p><?php echo $this->tag->linkTo(array('gghadmin/users/profile/' . $post->username, $post->username)); ?></p></td>
			<td><p><?php echo $post->reg_no; ?></p></td>
			<td><p><?php echo $post->tel; ?></p></td>
			<td><p><?php echo $post->due; ?></p></td>
			<td><p><?php echo $post->ins_amount; ?></p></td>
			<td><p><?php echo $post->r_amount; ?></p></td>
			<td><p><?php echo $post->amount; ?></p></td>
			<td><p><?php echo $post->total; ?></p></td>
			 
			<td><p><?php echo $post->year; ?></p></td>
			<td><p><?php echo $this->tag->linkTo(array('gghadmin/insuran/update/' . $post->id, 'Update', 'class' => 'btn btn-primary')); ?> &nbsp; 
			</p></td>
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