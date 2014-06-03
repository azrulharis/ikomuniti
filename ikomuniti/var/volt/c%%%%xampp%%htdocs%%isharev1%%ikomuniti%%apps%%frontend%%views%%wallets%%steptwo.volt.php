<?php echo $this->partial('partials/navigation'); ?> 
<div class="row">
  <div class="col-lg-12">
          
      <div class="panel panel-primary">
          <div class="panel-heading">
		    <h3 class="panel-title">Step Two</h3>
		  </div>
		  <div class="panel-body">    
		    <div class="alert alert-dismissable alert-info">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              Dont close or leave this page. Please enter TAC Code that we sent to your Phone to complete this transaction.
            </div>

                <?php echo $this->getContent(); ?>   
                 
				<?php echo $this->tag->form(array('wallets/steptwo', 'method' => 'post', 'class' => 'form-horizontal', 'role' => 'form')); ?> 
				   <?php foreach ($recipients as $recipient) { ?>
					<div class="form-group">
					    <label class="col-sm-4">Recipient Username:</label>
					    <div class="col-sm-8">
					      <p class="form-control-static"><?php echo $recipient->username; ?></p>
					    </div>
					</div>
					<div class="form-group">
					    <label class="col-sm-4">Recipient Name:</label>
					    <div class="col-sm-8">
					      <p class="form-control-static"><?php echo $recipient->name; ?></p>
					    </div>
					</div>	
					<div class="form-group">
					    <label class="col-sm-4">Recipient Reg Number:</label>
					    <div class="col-sm-8">
					      <p class="form-control-static"><?php echo $recipient->reg_number; ?></p>
					    </div>
					</div>
					<div class="form-group">
					    <label class="col-sm-4">iPoint:</label>
					    <div class="col-sm-8">
					      <p class="form-control-static"><?php echo $amount; ?></p>
					    </div>
					</div>
					<div class="form-group">
					    <label class="col-sm-4">TAC</label>
					    <div class="col-sm-8">
					     <?php echo $this->tag->textField(array('tac', 'size' => 60, 'class' => 'form-control')); ?>
					    </div>
					</div>	 
					<div class="form-group">
					<label class="col-sm-4"></label>
					    <div class="col-sm-8"> 
						<?php echo $this->tag->submitButton(array('submit', 'name' => 'submit', 'value' => 'Submit', 'class' => 'btn btn-primary')); ?>
						</div>
					</div> 
					<?php } ?>
		        </form> 
		  </div>
	  </div>
  </div>
   
</div> 


  
<?php echo $this->partial('partials/footer'); ?>