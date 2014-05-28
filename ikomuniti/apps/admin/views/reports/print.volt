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
{% for user in reports %} 
<div class="frame-print">
	<div class="col-lg-12">
          
      <div class="bs-example">
            <ul class="list-group"> 
	       <h4>Personal Information</h4> 
	       <li class="list-group-item">Epin: <b>{{user.epin}}</b></li>
	       <li class="list-group-item">Epin Tracking: <b>{{user.last_owner}}</b></li>
		      <li class="list-group-item">Sponsor: <b>{{user.username_sponsor}}</b></li>
		      <li class="list-group-item">Username: <b>{{user.username}}</b></li>
		      <li class="list-group-item">Full Name: <b>{{user.name|e}}</b></li>
		      <li class="list-group-item">NRIC: <b>{{user.nric_new}}</b></li>
		      <li class="list-group-item">Occupation: <b>{{user.occupation}}</b></li>
		      <li class="list-group-item">Next Of Kin: <b>{{user.kin_name|e}}</b></li>
		      <li class="list-group-item">Kin Phone: <b>{{user.kin_phone}}</b></li>
		      <li class="list-group-item">Relation: <b>{{user.relation|e}}</b></li>
		      <li class="list-group-item">Kin NRIC: <b>{{user.nric_new_kin}}</b></li>
		      <li class="list-group-item">Account No: <b>{{user.bank_number|e}}</b></li>
		      <li class="list-group-item">Bank Name: <b>{{user.bank_name|e}}</b></li>
		      
		      <li class="list-group-item">Address: <b>{{user.address|e}}</b></li>
		      <li class="list-group-item">Address Line Two: <b>{{user.second_address|e}}</b></li>
		      <li class="list-group-item">City: <b>{{user.city|e}}</b></li>
		      <li class="list-group-item">Region: <b>{{user.region}}</b></li>
		      <li class="list-group-item">Postcode: <b>{{user.postcode}}</b></li>
		      <li class="list-group-item">Phone: <b>{{user.telephone}}</b></li>
		      <li class="list-group-item">Email: <b>{{user.email}}</b></li>
		      <li class="list-group-item">Join Date: <b>{{user.created_at}}</b></li>
		   </ul>
	     
	</div>
  </div>
 
        <div class="col-lg-12">    
      <div class="bs-example">
            <ul class="list-group">
	   <h4>Vehicle Information</h4> 
	      <li class="list-group-item">Previous Insurance: <b>{{user.previous_insuran_company|e}}</li>
	      <li class="list-group-item">Cover Note: <b>{{user.cover_note|e}}</b></li>
	      <li class="list-group-item">NCD: <b>{{user.insuran_ncb|e}}</b></li>
	      <li class="list-group-item">Road Tax: <b>{{user.road_tax}}</b></li>
	      <li class="list-group-item">Due Date: <b>{{user.insuran_due_date}}</b></li>
	      
	      <li class="list-group-item">Reg No: <b>{{user.reg_number}}</b></li>
	      <li class="list-group-item">Owner Name: <b>{{user.owner_name|e}}</b></li>
	      <li class="list-group-item">Owner NRIC: <b>{{user.owner_nric}}</b></li>
	      <li class="list-group-item">Owner DOB: <b>{{user.owner_dob}}</b></li>
	      <li class="list-group-item">Model: <b>{{user.model|e}}</b></li>
	      <li class="list-group-item">Year Make: <b>{{user.year_make}}</b></li>
	      <li class="list-group-item">Cubic Capacity: <b>{{user.capacity}}</b></li>
	      <li class="list-group-item">Engine No: <b>{{user.engine_number|e}}</b></li>
	      <li class="list-group-item">Chasis No: <b>{{user.chasis_number|e}}</b></li>
	      
	      <li class="list-group-item">Grant Serial: <b>{{user.grant_serial_number|e}}</b></li>
	    </ul>  
            
	</div>
  </div>
</div>				 
{% endfor %}