<style>
@media print
{
.frame-print {page-break-after:always; width: 100%;}
} 
.list-group-item {
	padding: 0;
	margin: 0;
	border: none;
} 
</style>
<?php foreach ($reports as $user) { ?> 
<div class="frame-print">
	<div class="col-lg-12">
          
      <div class="bs-example">
            <ul class="list-group"> 
	       <h4>Personal Information</h4> 
	       <li class="list-group-item">Epin: <b><?php echo $user->epin; ?></b></li>
	       <li class="list-group-item">Epin Tracking: <b><?php echo $user->last_owner; ?></b></li>
		      <li class="list-group-item">Sponsor: <b><?php echo $user->username_sponsor; ?></b></li>
		      <li class="list-group-item">Username: <b><?php echo $user->username; ?></b></li>
		      <li class="list-group-item">Full Name: <b><?php echo $this->escaper->escapeHtml($user->name); ?></b></li>
		      <li class="list-group-item">NRIC: <b><?php echo $user->nric_new; ?></b></li>
		      <li class="list-group-item">Occupation: <b><?php echo $user->occupation; ?></b></li>
		      <li class="list-group-item">Next Of Kin: <b><?php echo $this->escaper->escapeHtml($user->kin_name); ?></b></li>
		      <li class="list-group-item">Kin Phone: <b><?php echo $user->kin_phone; ?></b></li>
		      <li class="list-group-item">Relation: <b><?php echo $this->escaper->escapeHtml($user->relation); ?></b></li>
		      <li class="list-group-item">Kin NRIC: <b><?php echo $user->nric_new_kin; ?></b></li>
		      <li class="list-group-item">Account No: <b><?php echo $this->escaper->escapeHtml($user->bank_number); ?></b></li>
		      <li class="list-group-item">Bank Name: <b><?php echo $this->escaper->escapeHtml($user->bank_name); ?></b></li>
		      
		      <li class="list-group-item">Address: <b><?php echo $this->escaper->escapeHtml($user->address); ?></b></li>
		      <li class="list-group-item">Address Line Two: <b><?php echo $this->escaper->escapeHtml($user->second_address); ?></b></li>
		      <li class="list-group-item">City: <b><?php echo $this->escaper->escapeHtml($user->city); ?></b></li>
		      <li class="list-group-item">Region: <b><?php echo $user->region; ?></b></li>
		      <li class="list-group-item">Postcode: <b><?php echo $user->postcode; ?></b></li>
		      <li class="list-group-item">Phone: <b><?php echo $user->telephone; ?></b></li>
		      <li class="list-group-item">Email: <b><?php echo $user->email; ?></b></li>
		      <li class="list-group-item">Join Date: <b><?php echo $user->created_at; ?></b></li>
		   </ul>
	     
	</div>
  </div>
 
        <div class="col-lg-12">    
      <div class="bs-example">
            <ul class="list-group">
	   <h4>Vehicle Information</h4> 
	      <li class="list-group-item">Previous Insurance: <b><?php echo $this->escaper->escapeHtml($user->previous_insuran_company); ?></li>
	      <li class="list-group-item">Cover Note: <b><?php echo $this->escaper->escapeHtml($user->cover_note); ?></b></li>
	      <li class="list-group-item">NCD: <b><?php echo $this->escaper->escapeHtml($user->insuran_ncb); ?></b></li>
	      <li class="list-group-item">Road Tax: <b><?php echo $user->road_tax; ?></b></li>
	      <li class="list-group-item">Due Date: <b><?php echo $user->insuran_due_date; ?></b></li>
	      
	      <li class="list-group-item">Reg No: <b><?php echo $user->reg_number; ?></b></li>
	      <li class="list-group-item">Owner Name: <b><?php echo $this->escaper->escapeHtml($user->owner_name); ?></b></li>
	      <li class="list-group-item">Owner NRIC: <b><?php echo $user->owner_nric; ?></b></li>
	      <li class="list-group-item">Owner DOB: <b><?php echo $user->owner_dob; ?></b></li>
	      <li class="list-group-item">Model: <b><?php echo $this->escaper->escapeHtml($user->model); ?></b></li>
	      <li class="list-group-item">Year Make: <b><?php echo $user->year_make; ?></b></li>
	      <li class="list-group-item">Cubic Capacity: <b><?php echo $user->capacity; ?></b></li>
	      <li class="list-group-item">Engine No: <b><?php echo $this->escaper->escapeHtml($user->engine_number); ?></b></li>
	      <li class="list-group-item">Chasis No: <b><?php echo $this->escaper->escapeHtml($user->chasis_number); ?></b></li>
	      
	      <li class="list-group-item">Grant Serial: <b><?php echo $this->escaper->escapeHtml($user->grant_serial_number); ?></b></li>
	    </ul>  
            
	</div>
  </div>
</div>				 
<?php } ?>