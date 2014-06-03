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
				<li class="active">Add iPin</li>
			    <li><?php echo $this->tag->linkTo(array('gghadmin/epins/transfer', 'Transfer iPin', 'class' => 'jun_button')); ?></li>
			    <li><?php echo $this->tag->linkTo(array('gghadmin/epins/viewuseripin', 'View iKomuniti iPin', 'class' => 'jun_button')); ?></li>
			    <li><?php echo $this->tag->linkTo(array('gghadmin/epins/track', 'Track', 'class' => 'jun_button')); ?></li> 
			  </ul>
			</div>
		    <?php echo $this->getContent(); ?>  
			<?php echo $this->tag->form(array('gghadmin/epins/add', 'method' => 'post')); ?>
			<div class="form-group col-xs-8 col-lg-6">
			<label>Jumlah iPin</label> <?php echo $this->tag->textField(array('count', 'size' => 14, 'placeholder' => '3, 10, 100', 'class' => 'form-control')); ?>
			 
			<?php echo $this->tag->submitButton(array('submit', 'value' => 'Generate', 'class' => 'btn btn-primary')); ?> 
			</div>
			</form>
        </div>
   
	</div>
    </div>
  </div>
</div> 
 

<?php echo $this->partial('partials/footer'); ?>