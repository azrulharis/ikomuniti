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
			    <li class="active">Add iPoint</li>
				<li><?php echo $this->tag->linkTo(array('gghadmin/wallets/view', 'View iPoint')); ?></li>
			    <li><?php echo $this->tag->linkTo(array('gghadmin/wallets/deduct', 'Deduct iPoint')); ?></li>
			    <li><?php echo $this->tag->linkTo(array('gghadmin/wallets/admin', 'Request')); ?></li> 
			  </ul>
			</div>
	  <?php echo $this->getContent(); ?>
		<?php if ($hideform == 1) { ?>
			
		<?php } else { ?>
        <form action="" method="GET">
        <div class="form-group">
		    <label>Username</label><?php echo $this->tag->textField(array('username', 'size' => 14, 'id' => 'username', 'class' => 'form-control')); ?>
		</div>
		<div class="form-group">
		    <label>Jumlah RM</label><?php echo $this->tag->textField(array('amount', 'size' => 14, 'placeholder' => '0.00', 'class' => 'form-control')); ?>
		</div>
		<div class="form-group">
		<?php echo $this->tag->submitButton(array('submit', 'name' => 'submit', 'value' => 'Langkah Seterusnya', 'class' => 'btn btn-success')); ?>
		</div>
		</form>
		<?php } ?>
	      
	     </div>        
      </div>
    </div>    
</div>
<?php echo $this->partial('partials/footer'); ?>