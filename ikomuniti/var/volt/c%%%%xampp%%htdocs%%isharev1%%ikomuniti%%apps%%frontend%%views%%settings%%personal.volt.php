<?php echo $this->partial('partials/navigation'); ?> 
<div class="row">
    <div class="col-lg-12">
      
      <div class="panel panel-primary">
        <div class="panel-heading">
		  <h3 class="panel-title">iSetting</h3>
		</div>
		  <div class="panel-body">
		    <div class="bs-example">
			  <ul class="breadcrumb" style="margin-bottom: 5px;">
			  <li><?php echo $this->tag->linkTo(array('settings/profile', 'Profile')); ?></li> 
			    <li class="active">Personal Informations</li>
			    <li><?php echo $this->tag->linkTo(array('settings/vehicle', 'Vehicle Informations')); ?></li> 
			    <li><?php echo $this->tag->linkTo(array('settings/account', 'Account Settings')); ?></li> 
			  </ul>
			</div>
			<?php echo $this->getContent(); ?>
		  <?php foreach ($users as $user) { ?>
		    <?php echo $this->tag->form(array('settings/personal', 'method' => 'post')); ?>	
				<div class="form-group">    
				<label>Username</label>: <?php echo $user->username; ?>
				</div>
				<div class="form-group">
				<label>Full Name <span class="red">*</span></label>: <?php echo $this->tag->textField(array('name', 'size' => 30, 'value' => $user->name, 'class' => 'form-control')); ?>
				</div>
				<div class="form-group">
				<label>NRIC <span class="red">*</span></label>: <?php echo $this->tag->textField(array('nric', 'size' => 30, 'value' => $user->nric_new, 'class' => 'form-control')); ?>
				</div>
				<div class="form-group">
				<label>Next Of Kin <span class="red">*</span></label>: <?php echo $this->tag->textField(array('next_of_kin', 'size' => 30, 'value' => $user->kin_name, 'class' => 'form-control')); ?>
				</div>
				<div class="form-group">
				<label>Relation <span class="red">*</span></label>: <?php echo $this->tag->textField(array('relation', 'size' => 30, 'value' => $user->relation, 'class' => 'form-control')); ?>
				</div>
				<div class="form-group">
				<label>Kin NRIC <span class="red">*</span></label>: <?php echo $this->tag->textField(array('kin_nric', 'size' => 30, 'value' => $user->nric_new_kin, 'class' => 'form-control')); ?>
				</div>
				<div class="form-group">
				<label>Account Number</label>: <?php echo $this->tag->textField(array('account_no', 'size' => 30, 'value' => $user->bank_number, 'class' => 'form-control')); ?>
				</div>
				<div class="form-group">
				<label>Bank Name </label>: <?php echo $this->tag->textField(array('bank_name', 'size' => 30, 'value' => $user->bank_name, 'class' => 'form-control')); ?>
				</div>
				<div class="form-group">
				<label>Address Line 1  <span class="red">*</span></label>: <?php echo $this->tag->textField(array('address', 'size' => 30, 'value' => $user->address, 'class' => 'form-control')); ?>
				</div>
				
				<div class="form-group">
				<label>Address Line 2 </label>: <?php echo $this->tag->textField(array('second_address', 'size' => 30, 'value' => $user->second_address, 'class' => 'form-control')); ?>
				</div>
				<div class="form-group">
				<label>Postcode  <span class="red">*</span></label>: <?php echo $this->tag->textField(array('postcode', 'size' => 30, 'value' => $user->postcode, 'class' => 'form-control')); ?>
				</div>
				<div class="form-group">
				<label>City  <span class="red">*</span></label>: <?php echo $this->tag->textField(array('city', 'size' => 30, 'value' => $user->city, 'class' => 'form-control')); ?>
				</div>
				<div class="form-group">
				<label>Region  <span class="red">*</span></label> 
					<select name="region" class="form-control"> 
						<option value="">Select Region</option>
						<option value="Johor"<?php if ($user->region == 'Johor') { ?> selected<?php } ?>>Johor</option>
						<option value="Melaka"<?php if ($user->region == 'Melaka') { ?> selected<?php } ?>>Melaka</option>
						<option value="Negeri Sembilan"<?php if ($user->region == 'Negeri Sembilan') { ?> selected<?php } ?>>Negeri Sembilan</option>
						<option value="Selangor"<?php if ($user->region == 'Selangor') { ?> selected<?php } ?>>Selangor</option>
						<option value="Kuala Lumpur"<?php if ($user->region == 'Kuala Lumpur') { ?> selected<?php } ?>>Kuala Lumpur</option>
						<option value="Pahang"<?php if ($user->region == 'Pahang') { ?> selected<?php } ?>>Pahang</option>
						<option value="Perak"<?php if ($user->region == 'Perak') { ?> selected<?php } ?>>Perak</option>
						<option value="Kedah"<?php if ($user->region == 'Kedah') { ?> selected<?php } ?>>Kedah</option>
						<option value="Pulau Pinang"<?php if ($user->region == 'Pulau Pinang') { ?> selected<?php } ?>>Pulau Pinang</option>
						<option value="Perlis"<?php if ($user->region == 'Perlis') { ?> selected<?php } ?>>Perlis</option>
						<option value="Terengganu"<?php if ($user->region == 'Terengganu') { ?> selected<?php } ?>>Terengganu</option>
						<option value="Kelantan"<?php if ($user->region == 'Kelantan') { ?> selected<?php } ?>>Kelantan</option>
						<option value="Sabah"<?php if ($user->region == 'Sabah') { ?> selected<?php } ?>>Sabah</option>
						<option value="Sarawak"<?php if ($user->region == 'Sarawak') { ?> selected<?php } ?>>Sarawak</option>
					</select>
				</div>
				
				<div class="form-group">
				<label>Phone <span class="red">*</span></label>: <?php echo $this->tag->textField(array('telephone', 'size' => 30, 'value' => $user->telephone, 'class' => 'form-control')); ?>
				</div>
				<div class="form-group">
				<label>Email </label>: <?php echo $this->tag->textField(array('email', 'size' => 30, 'value' => $user->email, 'class' => 'form-control')); ?>
				</div>
				<div class="form-group">
				 <?php echo $this->tag->submitButton(array('submit', 'value' => 'Save', 'class' => 'btn btn-primary')); ?>
				</div>
			</form>
			<?php } ?>
	      </div>
	  </div>
    </div>
</div> 
<?php echo $this->partial('partials/footer'); ?>

