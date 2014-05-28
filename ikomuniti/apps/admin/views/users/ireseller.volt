{{ partial("partials/navigation") }} 
{% for user in users %}
   
<div class="row">
<div class="col-lg-12">
  <div class="panel panel-primary">
    <div class="panel-heading">
	  <h3 class="panel-title">{{user.username}} Profile</h3>
	</div>
	<div class="panel-body">     
	{{content()}}
	<div class="col-lg-12">
	  {{ form('gghadmin/users/ireseller/'~user.username, 'method': 'post') }}
	    <div class="form-group">    
		    <label>Username</label>: {{ user.username }}
		</div>
        <div class="form-group">
		    <label>Full Name</label>: {{ text_field("name", "size": 30, "value": user.name, "class": "form-control") }}
		</div>
		<div class="form-group">
		    <label>Tel</label>: {{ text_field("phone", "size": 30, "value": user.telephone, "class": "form-control") }}
		</div>
		<div class="form-group">
		    <label>Location</label>: {{ text_field("location", "size": 30, "value": user.address, "class": "form-control") }}
		    {{ hidden_field("profile_image", "size": 30, "value": user.profile_image, "class": "form-control") }}
		    {{ hidden_field("username", "size": 30, "value": user.username, "class": "form-control") }}
		    {{ hidden_field("user_id", "size": 30, "value": user.id, "class": "form-control") }}
		</div>
		<div class="form-group">
		    {{ submit_button('submit', 'name': 'submit', 'value': 'Submit', 'class': 'btn btn-success')}}
		</div>
	  </form>
      <div class="bs-example">
            <ul class="list-group">
         
        
	       <h4>Personal Information</h4> 
		   <li class="list-group-item">{{link_to('gghadmin/users/edit/' ~ user.username, '<i class="fa fa-edit"></i>', 'title': 'Edit Profile')}}</li>
		      <li class="list-group-item">Sponsor: <span class="pull-right"><b>{{user.username_sponsor}}</b></span></li>
		      <li class="list-group-item">Username: <span class="pull-right"><b>{{user.username}}</b></span></li>
		      <li class="list-group-item">Full Name: <span class="pull-right"><b>{{user.name}}</b></span></li>
		      <li class="list-group-item">NRIC: <span class="pull-right"><b>{{user.nric_new}}</b></span></li>
		      <li class="list-group-item">Next Of Kin: <span class="pull-right"><b>{{user.kin_name}}</b></span></li>
		      <li class="list-group-item">Kin Phone: <span class="pull-right"><b>{{user.kin_phone}}</b></span></li>
		      <li class="list-group-item">Relation: <span class="pull-right"><b>{{user.relation}}</b></span></li>
		      <li class="list-group-item">Kin NRIC: <span class="pull-right"><b>{{user.nric_new_kin}}</b></span></li>
		      <li class="list-group-item">Account No: <span class="pull-right"><b>{{user.bank_number}}</b></span></li>
		      <li class="list-group-item">Bank Name: <span class="pull-right"><b>{{user.bank_name}}</b></span></li>
		      
		      <li class="list-group-item">Address: <span class="pull-right"><b>{{user.address}}</b></span></li>
		      <li class="list-group-item">Postcode: <span class="pull-right"><b>{{user.postcode}}</b></span></li>
		      <li class="list-group-item">Phone: <span class="pull-right"><b>{{user.telephone}}</b></span></li>
		      <li class="list-group-item">Email: <span class="pull-right"><b>{{user.email}}</b></span></li>
		      <li class="list-group-item">Join Date: <span class="pull-right"><b>{{user.created}}</b></span></li>
		   </ul>
	     
	</div>
  </div>
 
        <div class="col-lg-12">    
      <div class="bs-example">
            <ul class="list-group">
	   <h4>Vehicle Information</h4>
	   <li class="list-group-item">{{link_to('gghadmin/users/edit/' ~ user.username, '<i class="fa fa-edit"></i>', 'title': 'Edit Profile')}}</li>   
	      <li class="list-group-item">Previous Insurance: <span class="pull-right"><b>{{user.previous_insuran_company}}</li>
	      <li class="list-group-item">Cover Note: <span class="pull-right"><b>{{user.cover_note}}</b></span></li>
	      <li class="list-group-item">NCD: <span class="pull-right"><b>{{user.insuran_ncb}}</b></span></li>
	      <li class="list-group-item">Road Tax: <span class="pull-right"><b>{{user.road_tax}}</b></span></li>
	      <li class="list-group-item">Due Date: <span class="pull-right"><b>{{user.insuran_due_date}}</b></span></li>
	      
	      <li class="list-group-item">Reg No: <span class="pull-right"><b>{{user.reg_number}}</b></span></li>
	      <li class="list-group-item">Owner Name: <span class="pull-right"><b>{{user.owner_name}}</b></span></li>
	      <li class="list-group-item">Owner NRIC: <span class="pull-right"><b>{{user.owner_nric}}</b></span></li>
	      <li class="list-group-item">Owner DOB: <span class="pull-right"><b>{{user.owner_dob}}</b></span></li>
	      <li class="list-group-item">Model: <span class="pull-right"><b>{{user.model}}</b></span></li>
	      <li class="list-group-item">Year Make: <span class="pull-right"><b>{{user.year_make}}</b></span></li>
	      <li class="list-group-item">Cubic Capacity: <span class="pull-right"><b>{{user.capacity}}</b></span></li>
	      <li class="list-group-item">Engine No: <span class="pull-right"><b>{{user.engine_number}}</b></span></li>
	      <li class="list-group-item">Chasis No: <span class="pull-right"><b>{{user.chasis_number}}</b></span></li>
	      
	      <li class="list-group-item">Grant Serial: <span class="pull-right"><b>{{user.grant_serial_number}}</b></span></li>
	    </ul>  
           
{% endfor %}
	</div>
  </div>
</div> 
      </div>
	</div>
  </div>
</div> 
{{ partial("partials/footer") }}