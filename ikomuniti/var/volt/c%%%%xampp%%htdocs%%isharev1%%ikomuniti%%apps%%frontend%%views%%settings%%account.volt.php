<?php echo $this->partial('partials/navigation'); ?> 
<div class="row">
    <div class="col-lg-12">
      
      <div class="panel panel-primary">
        <div class="panel-heading">
		  <h3 class="panel-title">SMS Setting</h3>
		</div>
		  <div class="panel-body">
		    <div class="bs-example">
			  <ul class="breadcrumb" style="margin-bottom: 5px;">
			    <li><?php echo $this->tag->linkTo(array('settings/profile', 'Profile')); ?></li>
			    <li><?php echo $this->tag->linkTo(array('settings/personal', 'Personal Informations')); ?></li>
			    <li><?php echo $this->tag->linkTo(array('settings/vehicle', 'Vehicle Informations')); ?></li> 
			    <li class="active">Account Settings</li> 
			  </ul>
			</div>
			<?php echo $this->getContent(); ?>
		  <?php foreach ($users as $user) { ?>
		    <?php echo $this->tag->form(array('settings/account', 'method' => 'post')); ?>	
			 
	   <div class="form-group">
	      <label>SMS Commission Notification</label> 
	      <label class="radio-inline">
                  <input type="radio" name="sms_setting" id="optionsRadiosInline1" value="1" <?php if ($user->sms_setting == 1) { ?>checked<?php } ?>> Send SMS
                </label>
                <label class="radio-inline">
                  <input type="radio" name="sms_setting" id="optionsRadiosInline2" value="0" <?php if ($user->sms_setting == 0) { ?>checked<?php } ?>> Dont send SMS
                </label> 

	    </div>
 
	   
	   <div class="form-group">
	      <?php echo $this->tag->submitButton(array('submit', 'name' => 'sms', 'value' => 'Change SMS Setting', 'class' => 'btn btn-primary')); ?>
      </div>
      </form>
			<?php } ?>
	      </div>
	  </div>
    </div>
</div> 

<div class="row">
    <div class="col-lg-12">
      
      <div class="panel panel-primary">
        <div class="panel-heading">
		  <h3 class="panel-title">Change Password</h3>
		</div>
		  <div class="panel-body">
		     
		  <?php foreach ($users as $user) { ?>
		    <?php echo $this->tag->form(array('settings/account', 'method' => 'post')); ?>	
			 
 
	   <div class="form-group">
	      <label>New Password</label>: <?php echo $this->tag->passwordField(array('password', 'class' => 'form-control')); ?>
	      
	      </div>
	   <div class="form-group">
	      <label>Retype New Password</label>: <?php echo $this->tag->passwordField(array('retype_password', 'class' => 'form-control')); ?>
	      </div>
	   <div class="form-group">
	      <label>Current Password</label>: <?php echo $this->tag->passwordField(array('old_password', 'class' => 'form-control')); ?>
	      </div> 
	   <div class="form-group">
	      <?php echo $this->tag->submitButton(array('submit', 'name' => 'change_password', 'value' => 'Change Password', 'class' => 'btn btn-primary')); ?>
      </div>
      </form>
			<?php } ?>
	      </div>
	  </div>
    </div>
</div> 

<div class="row">
    <div class="col-lg-12">
      
      <div class="panel panel-primary">
        <div class="panel-heading">
		  <h3 class="panel-title">Change Transaction Password</h3>
		</div>
		  <div class="panel-body">
		     
		  <?php foreach ($users as $user) { ?>
		    <?php echo $this->tag->form(array('settings/account', 'method' => 'post')); ?>	
			 
	   <div class="form-group"> 
	      <label>New Transaction Password</label>: <?php echo $this->tag->passwordField(array('transaction_password', 'class' => 'form-control')); ?>
	   </div>
	   <div class="form-group"> 
	      <label>Retype New Transaction Password</label>: <?php echo $this->tag->passwordField(array('retype_transaction_password', 'class' => 'form-control')); ?>
	   </div>
	   <div class="form-group"> 
	      <label>Current Transaction Password</label>: <?php echo $this->tag->passwordField(array('old_transaction_password', 'class' => 'form-control')); ?>
	   </div>
	   
	   <div class="form-group">
	      <?php echo $this->tag->submitButton(array('submit', 'name' => 'trans_password', 'value' => 'Change Transaction Password', 'class' => 'btn btn-primary')); ?>
      </div>
      </form>
			<?php } ?>
	      </div>
	  </div>
    </div>
</div> 
<?php echo $this->partial('partials/footer'); ?>

