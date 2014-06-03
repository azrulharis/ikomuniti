
<?php echo $this->partial('partials/navigation'); ?> 
<div class="row">
    <div class="col-lg-12">
          
      <div class="panel panel-primary"> 
	  	<div class="panel-body">
		    <div class="bs-example">
			  <ul class="breadcrumb" style="margin-bottom: 5px;">
			    <li><?php echo $this->tag->linkTo(array('activations/index', 'Activate iS 1')); ?></li>
			    <li><?php echo $this->tag->linkTo(array('activations/all', 'Activate All')); ?></li> 
			    <li><?php echo $this->tag->linkTo(array('activations/problems', 'Problems Activation')); ?></li> 
			  </ul>
			</div>
	    <?php echo $this->getContent(); ?>
		<?php foreach ($users as $user) { ?> 
		<div class="alert alert-info alert-dismissable">
	       Sila pastikan iKomuniti mengisi maklumat akaun dan kenderaan dengan lengkap sebelum pengaktifan     
	    </div>
  
	        <div class="bs-example user-profile">
        <ul class="list-group"> 
	       <h4><b>Personal Information</b></h4> 
	       <li class="list-group-item"> 
		   <?php echo $this->tag->linkTo(array('activations/index?ref=' . $user->password . '&action=activate&activate=bljkX3BjVziItYbEqMZ1SOU2e8Xv6ZuRuTAztmdjVz8fOHeomyeLpuLaIZF4lHT&ntsv=' . $user->id, 'Activate', 'class' => 'btn btn-success', 'onclick' => 'return confirm(\'Adakah anda pasti untuk mengaktifkan ' . $user->username . '?\')')); ?>
		   &nbsp;&nbsp;&nbsp;&nbsp;
		   <?php echo $this->tag->linkTo(array('activations/index?ref=' . $user->password . '&action=problem&activate=bljkX3BjVziItYbEqMZ1SOU2e8Xv6ZuRuTAztmdjVz8fOHeomyeLpuLaIZF4lHT&ntsv=' . $user->id, 'Problem', 'class' => 'btn btn-danger', 'onclick' => 'return confirm(\'Adakah anda pasti untuk memindahkan ' . $user->username . ' ke bahagian Problem?\')')); ?> 
		    
		   
		   </li>
		   
		   <li class="list-group-item">Sponsor: <span class="space-left col-xs-12"><b><?php echo $user->username_sponsor; ?></b></span></li>
		      <li class="list-group-item">Username: <span class="space-left col-xs-12"><b><?php echo $user->username; ?></b></span></li>
		      <li class="list-group-item">Full Name: <span class="space-left col-xs-12 capitalize"><b><?php echo $this->escaper->escapeHtml($user->name); ?></b></span></li>
		      <li class="list-group-item">NRIC: <span class="space-left col-xs-12"><b><?php echo $user->nric_new; ?></b></span></li>
		      <li class="list-group-item">Occupation: <span class="space-left col-xs-12 capitalize"><b><?php echo $this->escaper->escapeHtml($user->occupation); ?></b></span></li>
		      <li class="list-group-item">Next Of Kin: <span class="space-left col-xs-12 capitalize"><b><?php echo $this->escaper->escapeHtml($user->kin_name); ?></b></span></li>
		      <li class="list-group-item">Kin Phone: <span class="space-left col-xs-12"><b><?php echo $user->kin_phone; ?></b></span></li>
		      <li class="list-group-item">Relation: <span class="space-left col-xs-12 capitalize"><b><?php echo $this->escaper->escapeHtml($user->relation); ?></b></span></li>
		      <li class="list-group-item">Kin NRIC: <span class="space-left col-xs-12"><b><?php echo $user->nric_new_kin; ?></b></span></li> 
		      <li class="list-group-item">Address: <span class="space-left col-xs-12 capitalize"><b><?php echo $this->escaper->escapeHtml($user->address); ?></b></span></li>
		      <li class="list-group-item">Address Line 2: <span class="space-left col-xs-12 capitalize"><b><?php echo $this->escaper->escapeHtml($user->second_address); ?></b></span></li>
		      
		      <li class="list-group-item">Postcode: <span class="space-left col-xs-12"><b><?php echo $user->postcode; ?></b></span></li>
		      <li class="list-group-item">City: <span class="space-left col-xs-12 capitalize"><b><?php echo $this->escaper->escapeHtml($user->city); ?></b></span></li>
		      <li class="list-group-item">Region: <span class="space-left col-xs-12"><b><?php echo $this->escaper->escapeHtml($user->region); ?></b></span></li>
		      <li class="list-group-item">Phone: <span class="space-left col-xs-12"><b><?php echo $user->telephone; ?></b></span></li>
		      <li class="list-group-item">Email: <span class="space-left col-xs-12"><b><?php echo $user->email; ?></b></span></li>
		      <li class="list-group-item">Join Date: <span class="space-left col-xs-12"><b><?php echo $user->created; ?></b></span></li>
		   </ul> 
	  </div> 
    
      <div class="bs-example user-profile">
        <ul class="list-group">
	      <h4><b>Vehicle Information</b></h4> 
	      <li class="list-group-item">Previous Insurance: <span class="space-left col-xs-12 capitalize"><b><?php echo $this->escaper->escapeHtml($user->previous_insuran_company); ?></li>
	      <li class="list-group-item">Cover Note: <span class="space-left col-xs-12"><b><?php echo $this->escaper->escapeHtml($user->cover_note); ?></b></span></li>
	      <li class="list-group-item">NCD: <span class="space-left col-xs-12"><b><?php echo $user->insuran_ncb; ?></b></span></li>
	      <li class="list-group-item">Road Tax: <span class="space-left col-xs-12"><b><?php echo $user->road_tax; ?></b></span></li>
	      <li class="list-group-item">Due Date: <span class="space-left col-xs-12"><b><?php echo $user->insuran_due_date; ?></b></span></li>
	      
	      <li class="list-group-item">Reg No: <span class="space-left col-xs-12"><b><?php echo $user->reg_number; ?></b></span></li>
	      <li class="list-group-item">Owner Name: <span class="space-left col-xs-12 capitalize"><b><?php echo $user->owner_name; ?></b></span></li>
	      <li class="list-group-item">Owner NRIC: <span class="space-left col-xs-12"><b><?php echo $user->owner_nric; ?></b></span></li>
	      <li class="list-group-item">Owner DOB: <span class="space-left col-xs-12"><b><?php echo $user->owner_dob; ?></b></span></li>
	      <li class="list-group-item">Model: <span class="space-left col-xs-12 capitalize"><b><?php echo $this->escaper->escapeHtml($user->model); ?></b></span></li>
	      <li class="list-group-item">Year Make: <span class="space-left col-xs-12"><b><?php echo $user->year_make; ?></b></span></li>
	      <li class="list-group-item">Cubic Capacity: <span class="space-left col-xs-12"><b><?php echo $user->capacity; ?></b></span></li>
	      <li class="list-group-item">Engine No: <span class="space-left col-xs-12"><b><?php echo $this->escaper->escapeHtml($user->engine_number); ?></b></span></li>
	      <li class="list-group-item">Chasis No: <span class="space-left col-xs-12"><b><?php echo $this->escaper->escapeHtml($user->chasis_number); ?></b></span></li>
	      
	      <li class="list-group-item">Grant Serial: <span class="space-left col-xs-12"><b><?php echo $this->escaper->escapeHtml($user->grant_serial_number); ?></b></span></li>
	      <li class="list-group-item"> 
		   <?php echo $this->tag->linkTo(array('activations/index?ref=' . $user->password . '&action=activate&activate=bljkX3BjVziItYbEqMZ1SOU2e8Xv6ZuRuTAztmdjVz8fOHeomyeLpuLaIZF4lHT&ntsv=' . $user->id, 'Activate', 'class' => 'btn btn-success', 'onclick' => 'return confirm(\'Adakah anda pasti untuk mengaktifkan ' . $user->username . '?\')')); ?>
		   &nbsp;&nbsp;&nbsp;&nbsp;
		   <?php echo $this->tag->linkTo(array('activations/index?ref=' . $user->password . '&action=problem&activate=bljkX3BjVziItYbEqMZ1SOU2e8Xv6ZuRuTAztmdjVz8fOHeomyeLpuLaIZF4lHT&ntsv=' . $user->id, 'Problem', 'class' => 'btn btn-danger', 'onclick' => 'return confirm(\'Adakah anda pasti untuk memindahkan ' . $user->username . ' ke bahagian Problem?\')')); ?> 
		    
		   
		   </li>
	    </ul>   
	  </div>
      <?php } ?>
	    </div>
    </div>
</div> 
<?php echo $this->partial('partials/footer'); ?> 


 
			
			