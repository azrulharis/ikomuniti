<script>
  $(function() {
	$( "#due_date" ).datepicker({
	 changeMonth: true,
     changeYear: true, 
	 dateFormat: "yy-mm-dd", 
	 stepMonths: 12,
	 minDate: new Date(2010, 11 - 1, 6),
     yearRange: '2010:2018'
	 });
	}); 
  $(function() {
	$( "#dob" ).datepicker({
	 changeMonth: true,
     changeYear: true, 
	 dateFormat: "yy-mm-dd", 
	 stepMonths: 12,
	 minDate: new Date(1940, 11 - 1, 6),
     yearRange: '1940:2014'
	 });
	});
</script>
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
			    <li><?php echo $this->tag->linkTo(array('settings/personal', 'Personal Informations')); ?></li>
			    <li class="active">Vehicle Informations</li> 
			    <li><?php echo $this->tag->linkTo(array('settings/account', 'Account Settings')); ?></li> 
			  </ul>
			</div>
		  <?php echo $this->getContent(); ?>
		  <?php foreach ($users as $user) { ?>
		    <?php echo $this->tag->form(array('settings/vehicle', 'method' => 'post')); ?>	
		<div class="form-group"> 
	      <label>Previous Insurance</label>: <?php echo $this->tag->textField(array('previous_insurance', 'size' => 30, 'value' => $user->previous_insuran_company, 'class' => 'form-control')); ?>
	   </div>
	   <div class="form-group">
	      <label>Cover Note</label>: <?php echo $this->tag->textField(array('cover_note', 'size' => 30, 'value' => $user->cover_note, 'class' => 'form-control')); ?>
	      </div>
	   <div class="form-group">
	      <label>NCD</label>: 
	      
	      <select class="form-control" name="ncd">
					<option value="">Select</option>
					<option value="0"<?php if ($user->ncd == 0) { ?> selected<?php } ?>>0%</option>
					<option value="25"<?php if ($user->ncd == 25) { ?> selected<?php } ?>>25%</option>
					<option value="30"<?php if ($user->ncd == 30) { ?> selected<?php } ?>>30%</option>
					<option value="38.33"<?php if ($user->ncd == '38.33') { ?> selected<?php } ?>>38.33%</option>
					<option value="45"<?php if ($user->ncd == 45) { ?> selected<?php } ?>>45%</option>
					<option value="55"<?php if ($user->ncd == 55) { ?> selected<?php } ?>>55%</option>
				</select>
	      </div>
	   <div class="form-group">
	      <label>Road Tax</label>: <?php echo $this->tag->textField(array('road_tax_amount', 'size' => 30, 'value' => $user->road_tax, 'class' => 'form-control')); ?>
	      </div>
	   <div class="form-group">
	      <label>Due Date</label>: <input type="text" name="cvm" value="<?php echo $user->next_renewal; ?>" class="form-control" disabled>
	      <input type="hidden" name="due_date" value="<?php echo $user->next_renewal; ?>" class="form-control">
		   
	      </div>
	   <div class="form-group">
	      
	      <label>Reg No <span class="red">*</span></label>: <input type="text" name="nvmv" value="<?php echo $user->reg_number; ?>" class="form-control" disabled>
		  <input type="hidden" name="reg_no" value="<?php echo $user->reg_number; ?>" class="form-control"> 
	      </div>
	   <div class="form-group">
	      <label>Owner Name <span class="red">*</span></label>: <?php echo $this->tag->textField(array('owner_name', 'size' => 30, 'value' => $user->owner_name, 'class' => 'form-control')); ?>
	      </div>
	   <div class="form-group">
	      <label>Owner NRIC <span class="red">*</span></label>: <?php echo $this->tag->textField(array('owner_nric', 'size' => 30, 'value' => $user->owner_nric, 'class' => 'form-control')); ?>
	      </div>
	   <div class="form-group">
	      <label>Owner DOB <span class="red">*</span></label>: <?php echo $this->tag->textField(array('owner_dob', 'id' => 'dob', 'value' => $user->owner_dob, 'class' => 'form-control')); ?>
	      </div>
	   <div class="form-group">
	      <label>Model <span class="red">*</span></label>: <?php echo $this->tag->textField(array('model', 'size' => 30, 'value' => $user->model, 'class' => 'form-control')); ?>
	      </div>
	   <div class="form-group">
	      <label>Year Make <span class="red">*</span></label>: <?php echo $this->tag->textField(array('year_make', 'size' => 30, 'value' => $user->year_make, 'class' => 'form-control')); ?>
	      </div>
	   <div class="form-group">
	      <label>Cubic Capacity <span class="red">*</span></label>: <?php echo $this->tag->textField(array('cubic_capacity', 'size' => 30, 'value' => $user->capacity, 'class' => 'form-control')); ?>
	      </div>
	   <div class="form-group">
	      <label>Engine No <span class="red">*</span></label>: <?php echo $this->tag->textField(array('engine_no', 'size' => 30, 'value' => $user->engine_number, 'class' => 'form-control')); ?>
	      </div>
	   <div class="form-group">
	      <label>Chasis Number <span class="red">*</span></label>: <?php echo $this->tag->textField(array('chasis_no', 'size' => 30, 'value' => $user->chasis_number, 'class' => 'form-control')); ?>
	      </div>
	   <div class="form-group">
	      
	      <label>Grant Serial Number</label>: <?php echo $this->tag->textField(array('grant_serial', 'size' => 30, 'value' => $user->grant_serial_number, 'class' => 'form-control')); ?>
	      </div>
	   <div class="form-group">
	      <?php echo $this->tag->submitButton(array('submit', 'value' => 'Update', 'class' => 'btn btn-primary')); ?>
      </div>
      </form>
			<?php } ?>
	      </div>
	  </div>
    </div>
</div> 
<?php echo $this->partial('partials/footer'); ?>

