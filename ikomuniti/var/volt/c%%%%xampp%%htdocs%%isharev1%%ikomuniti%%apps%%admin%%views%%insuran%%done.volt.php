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
	    <div class="well">
		  <form action="" method="GET">
	      	<h4>From date</h4>
			  <div class="form-group text-center"> 
			  <input type="text" name="from" id="datepicker_from" class="form-control input-lg"> 
			</div>
	  	</div>
	</div>
	<div class="col-lg-4"> 
		<div class="well">  
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
		  <h3 class="panel-title">iTakaful</h3>
		</div>
		  <div class="panel-body">  
      
      <div class="bs-example">
		  <ul class="breadcrumb" style="margin-bottom: 5px;">
	        <li><?php echo $this->tag->linkTo(array('gghadmin/insuran/manage', 'iManagement')); ?></li> 
	      <li><?php echo $this->tag->linkTo(array('gghadmin/insuran/quotation', 'Updated')); ?></li>
		  <li><?php echo $this->tag->linkTo(array('gghadmin/insuran/kiv', 'Kiv')); ?></li>
	      <li><?php echo $this->tag->linkTo(array('gghadmin/insuran/problems', 'Problems')); ?></li>
	      <li class="active">Done <b><?php echo $count_user_done; ?></b></li>
	      </ul>
      </div>      
	   <div class="table-responsive">
		      <table class="table table-bordered table-hover table-striped tablesorter"> 
	    <tr>
	    <th>Username</th> <th>Due</th> <th>Insuran</th> <th>Roadtax</th> <th>Wallet</th> <th>Total</th> <th>Reg No</th><th>Year</th> <th>Action</th>
	    </tr>
		<?php foreach ($views as $post) { ?>
		<tr>
		    
			<td><p><?php echo $this->tag->linkTo(array('gghadmin/users/profile/' . $post->username, $post->username)); ?></p></td>
			<td><p><?php echo $post->due; ?></p></td>
			<td><p><?php echo $post->ins_amount; ?></p></td>
			<td><p><?php echo $post->r_amount; ?></p></td>
			<td><p><?php echo $post->amount; ?></p></td>
			<td><p><?php echo $post->total; ?></p></td>
			<td><p><?php echo $post->reg_no; ?></p></td> 
			<td><p><?php echo $post->year; ?></p></td>
			<td><p><?php echo $this->tag->linkTo(array('gghadmin/insuran/update/' . $post->id, 'Update', 'class' => 'btn btn-primary')); ?></p></td>
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