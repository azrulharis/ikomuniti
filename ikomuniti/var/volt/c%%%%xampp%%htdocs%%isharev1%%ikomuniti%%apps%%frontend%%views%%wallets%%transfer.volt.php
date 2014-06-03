<?php echo $this->partial('partials/navigation'); ?> 
<div class="row">
  <div class="col-lg-12">
          
      <div class="panel panel-primary">
          <div class="panel-heading">
		    <h3 class="panel-title">Transfer iPoint</h3>
		  </div>
		  <div class="panel-body">    
		    <div class="bs-example">
              <ul class="breadcrumb" style="margin-bottom: 5px;">
                <li><?php echo $this->tag->linkTo(array('wallets/index', 'iPoint', 'class' => 'jun_button')); ?></li> 
				<li><?php echo $this->tag->linkTo(array('wallets/histories', 'History', 'class' => 'jun_button')); ?></li> 
				<li><?php echo $this->tag->linkTo(array('wallets/redeem', 'Withdraw', 'class' => 'jun_button')); ?></li> 
				<li><?php echo $this->tag->linkTo(array('wallets/status', 'Withdrawal Status', 'class' => 'jun_button')); ?></li>
                <li class="active">Transfer</li>
              </ul>
            </div>
             
            <div class="panel panel-default">
              <div class="panel-body">
                <?php echo $this->getContent(); ?>   
                
            <div class="form-group">
			    <?php echo $this->tag->form(array('wallets/transfer', 'method' => 'post')); ?> 
			   
				<div class="form-group">
				<label>Recipient Username</label>
				    <?php echo $this->tag->textField(array('recipient_username', 'class' => 'form-control', 'placeholder' => 'username')); ?>	 
				</div>
				<div class="form-group"> 
				<label>Remark</label>
				     <?php echo $this->tag->textArea(array('remark', 'class' => 'form-control', 'placeholder' => 'Enter your remark')); ?>
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
		           </form>
		         </div>
              </div>
            </div>
		  </div>
	  </div>
  </div>
   
</div> 


  
<?php echo $this->partial('partials/footer'); ?>