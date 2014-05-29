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
	    <li><?php echo $this->tag->linkTo(array('epins/index', 'My iPin')); ?></li> 
	    <li class="active">Transfer iPin</li>
	    <li><?php echo $this->tag->linkTo(array('epins/track', 'Track')); ?></li>
	  </ul>
	  </div>
		 
		 
		 <div class="form-group">
			<?php echo $this->getContent(); ?>
			<?php if ($hide == 0) { ?>
			<?php echo $this->tag->form(array('epins/transfer', 'method' => 'post')); ?> 
			<div class="form-group">
	        <label>iPin Total</label> <?php echo $this->tag->textField(array('count', 'class' => 'form-control', 'size' => 24)); ?>
			</div>
			<div class="form-group">
			<label>Recipient Username </label><?php echo $this->tag->textField(array('username', 'class' => 'form-control', 'size' => 24, 'id' => 'username')); ?>
			</div>
			<div class="form-group">
			<label>Transaction Code </label><?php echo $this->tag->passwordField(array('master_key', 'class' => 'form-control', 'size' => 24)); ?>
			</div>
			<div class="form-group">
			 <?php echo $this->tag->submitButton(array('submit', 'value' => 'Next Step', 'class' => 'btn btn-primary')); ?> 
			 </div>
			</form> 
			<?php } ?>
	    </div>
</div>
	  </div>
</div></div> 
<?php echo $this->partial('partials/footer'); ?>