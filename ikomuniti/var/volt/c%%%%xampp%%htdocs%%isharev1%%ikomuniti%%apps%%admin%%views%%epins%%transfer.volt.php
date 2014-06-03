<script type="text/javascript">
$(document).ready(function()
{
    $('#username').autocomplete(
    {
        source: "<?php echo $urlajax; ?>",
        minLength: 2
    });
});
</script>
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
			    <li><?php echo $this->tag->linkTo(array('gghadmin/epins/index', 'iPin', 'class' => 'jun_button')); ?></li>
				<li><?php echo $this->tag->linkTo(array('gghadmin/epins/add', 'Add iPin', 'class' => 'jun_button')); ?></li>
			    <li class="active">Transfer iPin</li>
			    <li><?php echo $this->tag->linkTo(array('gghadmin/epins/viewuseripin', 'View iKomuniti iPin', 'class' => 'jun_button')); ?></li>
			    <li><?php echo $this->tag->linkTo(array('gghadmin/epins/track', 'Track', 'class' => 'jun_button')); ?></li> 
			  </ul>
			</div>
			
		<?php echo $this->getContent(); ?>
        <?php if ($hide == 0) { ?>
        <?php echo $this->tag->form(array('gghadmin/epins/transfer', 'method' => 'post')); ?> 
        
		<div class="form-group">
            <label>Jumlah iPin</label><?php echo $this->tag->textField(array('count', 'class' => 'form-control')); ?>
		</div>
		
		<div class="form-group"> 
		    <label>Username penerima</label><?php echo $this->tag->textField(array('username', 'id' => 'username', 'class' => 'form-control')); ?>
		</div>
		
		<div class="form-group"> 
		    <label>Kod Transaksi</label><?php echo $this->tag->passwordField(array('master_key', 'class' => 'form-control')); ?>
		</div>
		
		<div class="form-group"> 
		    <?php echo $this->tag->submitButton(array('submit', 'value' => 'Langkah Seterusnya', 'class' => 'btn btn-primary')); ?>
		 </div>
		</form>
		<?php } ?>
 </div>
   
	</div>
    </div>
  </div>
</div> 
 

<?php echo $this->partial('partials/footer'); ?>