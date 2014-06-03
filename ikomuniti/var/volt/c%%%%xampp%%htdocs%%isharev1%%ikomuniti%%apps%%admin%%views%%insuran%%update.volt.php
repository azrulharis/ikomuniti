<?php echo $this->partial('partials/navigation'); ?> 
<?php foreach ($profiles as $user) { ?>
<div class="row">
  <div class="col-lg-6">
    <div class="panel panel-info">
      <div class="panel-heading">
        <h3 class="panel-title">Update <?php echo $user->username; ?> quotation</h3>
	  </div>
	  <div class="panel-body">  
	   
	  <?php echo $this->getContent(); ?>
	  <?php foreach ($updates as $post) { ?>
			<?php echo $this->tag->form(array('gghadmin/insuran/update/' . $post->u_id, 'method' => 'post')); ?>
			    <div class="form-group"> 
				  <label><p>Jumlah Premium (Total Flas) RM <span style="color: #FF0000;">*</span></p></label><?php echo $this->tag->textField(array('insuran_amount', 'size' => 20, 'value' => $post->ins_amount, 'class' => 'form-control')); ?>
				</div>
				
				<div class="form-group"> 
				<label><p>Road Tax Amount RM <span style="color: #FF0000;">*</span></p></label><?php echo $this->tag->textField(array('road_tax', 'size' => 20, 'value' => $post->r_amount, 'class' => 'form-control')); ?>
				</div>
				<div class="form-group"> 
				<label><p>Windscreen (Hanya Untuk Rekod GGHSB) RM</p></label><?php echo $this->tag->textField(array('wind_screen', 'size' => 20, 'value' => $post->wind_screen, 'class' => 'form-control')); ?>
				</div>
				<div class="form-group"> 
				<label><p>PA (Hanya Untuk Rekod GGHSB) RM</p></label>
				
				<select name="pa" class="form-control">
				       <option value="0">Select</option>
					   <option value="50">RM50 (Sum Covered RM10K/Person)</option>  
				       <option value="90">RM90 (Sum Covered RM20K/Person)</option> 
				       <option value="130">RM130 (Sum Covered RM30K/Person)</option>
				       <option value="170">RM170 (Sum Covered RM40K/Person)</option> 
				       <option value="210">RM210 (Sum Covered RM50K/Person)</option>
				    </select>
				</div>
				<div class="form-group"> 
				<label><p>Additional Drivers (Separate By Comma/Hanya Untuk Rekod GGHSB)</p></label><?php echo $this->tag->textField(array('second_driver', 'size' => 20, 'value' => $post->second_driver, 'class' => 'form-control', 'placeholder' => 'Nama Satu, Nama Dua, Nama Tiga')); ?>
				</div>
				<div class="form-group"> 
				<label><p>CRP (Hanya Untuk Rekod GGHSB)</p></label>
				<select name="crp" class="form-control">
				       <option value="0">Dont include CRP</option>
				       <option value="78">RM78 - 14 Days CRP (For premium 500 and above)</option>
				       <option value="120">RM120 - 14 Days CRP (For premium less than 500)</option> 
				    </select>
				</div>
				<div class="form-group"> 
				<label><p>Cover Amount RM <span style="color: #FF0000;">*</span></p></label><?php echo $this->tag->textField(array('cover', 'size' => 20, 'value' => $post->cover, 'class' => 'form-control')); ?>
				</div>
				
				<div class="form-group"> 
				<label><p>Service Charge RM</p></label>
					 <select name="service_charge" class="form-control">
				       <option value="0" <?php if ($post->charge == 0) { ?>selected<?php } ?>>Select</option>
				       <option value="20" <?php if ($post->charge == 20) { ?>selected<?php } ?>>Normal</option>
				       <option value="30" <?php if ($post->charge == 30) { ?>selected<?php } ?>>Urgent</option>
				    </select>
				</div>
				<div class="form-group">
			    <label>NCD <span style="color: #FF0000;">*</span></label>
		 
				<select class="form-control" name="insuran_ncb">
					<option value="">Pilih</option>
					<option value="0">0%</option>
					<option value="25">25%</option>
					<option value="30">30%</option>
					<option value="38.33">38.33%</option>
					<option value="45">45%</option>
					<option value="55">55%</option>
				</select> 
		        </div>

				<div class="form-group"> 
				<label><p>Send SMS</p></label>
					 <select name="sms" class="form-control">
				       <option value="0">Select</option>
				       <option value="1">Yes</option>
				       <option value="2">No</option>
				    </select>
				</div>
				
				<?php echo $this->tag->hiddenField(array('reg_no', 'value' => $post->reg_no)); ?>
				<?php echo $this->tag->hiddenField(array('user_id', 'value' => $post->u_id)); ?>
				<?php echo $this->tag->hiddenField(array('due_date', 'value' => $post->due_date)); ?>
				
			     <div class="form-group"> 
				    <?php echo $this->tag->submitButton(array('submit', 'value' => 'Update', 'class' => 'btn btn-primary', 'onclick' => 'return confirm("Adakah anda pasti untuk update Takaful ' . $post->username . '? Sila semak dengan teliti sebelum menekan butang OK.")')); ?> 
				    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				    <?php echo $this->tag->linkTo(array('gghadmin/insuran/addtokiv?action=problem&user_id=' . $post->u_id, 'Problem', 'class' => 'btn btn-danger', 'onclick' => 'return confirm(\'Adakah anda pasti untuk memindahkan ' . $post->username . ' ke bahagian Problem?\')')); ?>
       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       <?php echo $this->tag->linkTo(array('gghadmin/insuran/addtokiv?action=kiv&user_id=' . $post->u_id, 'Kiv', 'class' => 'btn btn-warning', 'onclick' => 'return confirm(\'Adakah anda pasti untuk memindahkan ' . $post->username . ' ke bahagian Kiv?\')')); ?>
				</div>
		    </form>
		    <?php } ?>
	      
	     </div>        
      </div>
    </div>
    
<div class="col-lg-6">
    <div class="panel panel-info">
      <div class="panel-heading">
        <h3 class="panel-title">Additional Request</h3>
	  </div>
	  <div class="panel-body">  
	   <?php foreach ($reqs as $req) { ?>
	     <div class="form-group">
	         <span class="pull-left col-md-4">Windscreen </span><span class="pull-right col-md-8">RM<?php echo $req->windscreen; ?></span> 
	     </div>
	     <div class="form-group">
	         <span class="pull-left col-md-4">CRP </span><span class="pull-right col-md-8">RM<?php echo $req->crp; ?></span> 
	     </div>
	     <div class="form-group">
	        <span class="pull-left col-md-4">Additional Driver</span><span class="pull-right col-md-8"><?php echo $req->additional_driver; ?></span> 
	    </div>
	   <?php } ?>
	     <div style="width: 100%; height: 386px; border: 1px solid #ccc; overflow: hidden; z-index: 999; padding-bottom: 5px;">
	   <iframe style="width: 100%; height: 680px; border: none; margin-top: -210px;" scrolling="no" id="extFrame" src="http://www.einsuran.com/roadtax.aspx"></iframe>
       </div>
       
      </div>        
    </div>
</div>      
    
    
</div><!-- /.row -->




<div class="row">
<div class="col-lg-12">
  <div class="panel panel-primary">
    <div class="panel-heading">
	  <h3 class="panel-title"><?php echo $user->username; ?> Profile</h3>
	</div>
	<div class="panel-body">  
          
      <div class="bs-example user-profile">
            <ul class="list-group">
         
        
	       <h4><b>Personal Information</b></h4>
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
	    </ul>  
           
<?php } ?> 
  </div>
</div> 
      </div>
	</div>
  </div>
</div> 
<?php echo $this->partial('partials/footer'); ?>