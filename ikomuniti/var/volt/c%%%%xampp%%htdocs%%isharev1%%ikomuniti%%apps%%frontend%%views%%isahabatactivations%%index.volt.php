<?php echo $this->partial('partials/navigation'); ?> 
    <div class="row">
        <div class="col-lg-12">
          
      <div class="panel panel-primary">
        <div class="panel-heading">
		  <h3 class="panel-title">iSahabat Activation</h3>
		</div>
	  <div class="panel-body">
	  <div class="bs-example">
		  <ul class="breadcrumb" style="margin-bottom: 5px;">
		    <li class="active"><?php echo $this->tag->linkTo(array('isahabatactivations/index', 'Activate iS 1')); ?></li>
		    <li><?php echo $this->tag->linkTo(array('isahabatactivations/all', 'Activate All')); ?></li> 
		    <li><?php echo $this->tag->linkTo(array('isahabatactivations/problems', 'Problems Activation')); ?></li> 
		  </ul>
		</div>
	  <?php echo $this->getContent(); ?>
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
			<?php echo $this->tag->linkTo(array('isahabatactivations/profile/' . $post->username, 'View Profile', 'class' => 'btn btn-success')); ?> 
			</p></td>
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