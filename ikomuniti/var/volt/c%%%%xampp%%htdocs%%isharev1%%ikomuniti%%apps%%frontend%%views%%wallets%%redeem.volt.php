<?php echo $this->partial('partials/navigation'); ?> 
<div class="row">
  <div class="col-lg-12">
          
      <div class="panel panel-primary">
          <div class="panel-heading">
		    <h3 class="panel-title">Withdraw iPoint</h3>
		  </div>
		  <div class="panel-body">    
		    <div class="bs-example">
              <ul class="breadcrumb" style="margin-bottom: 5px;">
                <li><?php echo $this->tag->linkTo(array('wallets/index', 'iPoint', 'class' => 'jun_button')); ?></li> 
				<li><?php echo $this->tag->linkTo(array('wallets/histories', 'History', 'class' => 'jun_button')); ?></li> 
                <li class="active">Withdraw</li>
                <li><?php echo $this->tag->linkTo(array('wallets/status', 'Withdrawal Status', 'class' => 'jun_button')); ?></li>
                <li><?php echo $this->tag->linkTo(array('wallets/transfer', 'Transfer', 'class' => 'jun_button')); ?></li>
              </ul>
            </div>
            <div class="alert alert-danger alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <p><b>Attention!, You are not allow to redeem iPoint if your current balance below insurance amount.</p>
            </div>
            <div class="panel panel-default">
              <div class="panel-body">
                <?php echo $this->getContent(); ?>   
                
            <div class="form-group">
			<?php echo $this->tag->form(array('wallets/redeem', 'method' => 'post')); ?> 
			  <?php foreach ($users as $user) { ?>
				<div class="form-group">
				<label>Bank Name</label>
				    <?php echo $this->tag->textField(array('bank_name', 'value' => $user->bank_name, 'class' => 'form-control', 'placeholder' => 'Maybank/Cimb/Etc')); ?>	 
				</div>
				<div class="form-group"> 
				<label>Account Number</label>
				     <?php echo $this->tag->textField(array('account_number', 'value' => $user->bank_number, 'class' => 'form-control', 'placeholder' => '245346357353')); ?>
				</div>	
				<div class="form-group"> 
				<label>iPoint</label>
				     <?php echo $this->tag->textField(array('amount', 'size' => 60, 'class' => 'form-control', 'placeholder' => '0.00')); ?>
				     <?php echo $this->tag->hiddenField(array('DB8R4HAW4XB7Y8LMP6', 'value' => $csrfToken)); ?>
				</div>
				<div class="form-group"> 
				<label>Password</label>
				     <?php echo $this->tag->passwordField(array('password', 'size' => 60, 'class' => 'form-control')); ?>
				</div>		
			    <div class="form-group"> 
				<label>Transaction Password</label>
				     <?php echo $this->tag->passwordField(array('transaction_password', 'size' => 60, 'class' => 'form-control')); ?>
				</div> 
				<div class="form-group">
				    <?php echo $this->tag->submitButton(array('submit', 'value' => 'Next Step', 'class' => 'btn btn-primary')); ?>
				 </div>
			  <?php } ?>
		           </form>
		         </div>
              </div>
            </div>
		  </div>
	  </div>
  </div>
  
  <div class="col-lg-4">
  
  </div>
</div> 


  
<?php echo $this->partial('partials/footer'); ?>