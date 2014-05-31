<?php echo $this->partial('partials/navigation'); ?> 
    <div class="row">
        <div class="col-lg-12">
          
      <div class="panel panel-primary">
        <div class="panel-heading">
		  <h3 class="panel-title">All iKomuniti Activation</h3>
		</div>
	  <div class="panel-body">
	  <div class="bs-example">
		  <ul class="breadcrumb" style="margin-bottom: 5px;">
		    <li><?php echo $this->tag->linkTo(array('activations/index', 'Activate iS 1')); ?></li>
		    <li><?php echo $this->tag->linkTo(array('activations/all', 'Activate All')); ?></li> 
		    <li><?php echo $this->tag->linkTo(array('activations/problems', 'Problems Activation')); ?></li> 
		  </ul>
		</div>
	  <?php echo $this->getContent(); ?>
	  <div class="form-group">
	  <form action="" method="GET"> 
	  <div class="form-group col-lg-6 col-md-6 col-xs-12">
	      <input type="text" name="search" class="form-control" placeholder="Username or Name">
	  </div>
	  <div class="form-group col-lg-3 col-md-3 col-xs-12">
	      <button type="submit" name="submit" class="btn btn-success"><i class="fa fa-search"></i> Search</button>
	  </div>
	  </form>
	  </div>
	  <div class="table-responsive">
      <table class="table table-bordered table-hover table-striped tablesorter"> 
	    <tr>
	    <th>Username</th> <th>Sponsor</th> <th>Due</th> <th>Reg No</th> <th>Phone</th> <th>Actions</th>
	    </tr>
		<?php foreach ($views as $post) { ?>
		<tr>
		    
			<td><p><?php echo $post->username; ?></p></td>
			<td><p><?php echo $post->username_sponsor; ?></p></td>
			<td><p><?php echo $post->insuran_due_date; ?></p></td>
			<td><p><?php echo $this->escaper->escapeHtml($post->reg_number); ?></p></td>
			<td><p><?php echo $this->escaper->escapeHtml($post->telephone); ?></p></td>
			<td><p>
			<?php echo $this->tag->linkTo(array('activations/profile/' . $post->username, 'View Profile', 'class' => 'btn btn-success')); ?> </p></td>
		</tr>
		<?php } ?>
		</table>
		<div class="row">
			<?php echo $paginationUrl; ?>
		</div>
	  </div>
	  </div>
</div></div> 
<?php echo $this->partial('partials/footer'); ?>