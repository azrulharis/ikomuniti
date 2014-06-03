
{{ partial("partials/navigation") }} 
<div class="row">
    <div class="col-lg-12">
          
      <div class="panel panel-primary"> 
	  	<div class="panel-body">
		    <div class="bs-example">
			  <ul class="breadcrumb" style="margin-bottom: 5px;">
			    <li>{{ link_to("isahabatactivations/index", "Activate iS 1") }}</li>
			    <li>{{ link_to("isahabatactivations/all", "Activate All") }}</li> 
			    <li>{{ link_to("isahabatactivations/problems", "Problems Activation") }}</li> 
			  </ul>
			</div>
	    {{ content() }}
		{% for user in users %} 
		<div class="alert alert-info alert-dismissable">
	       Sila pastikan iSahabat mengisi maklumat akaun dan kenderaan dengan lengkap sebelum pengaktifan     
	    </div>
  
	        <div class="bs-example user-profile">
        <ul class="list-group"> 
	       <h4><b>Personal Information</b></h4> 
	       <li class="list-group-item"> 
		   	   {{ link_to("activations/index?ref=" ~ user.password ~ "&action=activate&activate=bljkX3BjVziItYbEqMZ1SOU2e8Xv6ZuRuTAztmdjVz8fOHeomyeLpuLaIZF4lHT&ntsv=" ~ user.id, "Activate As iKomuniti", "class": "btn btn-success", "onclick": "return confirm('Adakah anda pasti untuk mengaktifkan "~user.username~" sebagai iKomuniti?')") }}
		   &nbsp;&nbsp;&nbsp;&nbsp;
		   {{ link_to("isahabatactivations/index?ref=" ~ user.password ~ "&action=activate&activate=bljkX3BjVziItYbEqMZ1SOU2e8Xv6ZuRuTAztmdjVz8fOHeomyeLpuLaIZF4lHT&ntsv=" ~ user.id, "Activate As iSahabat", "class": "btn btn-primary", "onclick": "return confirm('Adakah anda pasti untuk mengaktifkan "~user.username~" sebagai iSahabat?')") }}
		   &nbsp;&nbsp;&nbsp;&nbsp;
		   {{ link_to("activations/index?ref=" ~ user.password ~ "&action=problem&activate=bljkX3BjVziItYbEqMZ1SOU2e8Xv6ZuRuTAztmdjVz8fOHeomyeLpuLaIZF4lHT&ntsv=" ~ user.id, "Problem", "class": "btn btn-danger", "onclick": "return confirm('Adakah anda pasti untuk memindahkan "~user.username~" ke bahagian Problem?')") }} 
		    
		   
		   </li>
		   
		   <li class="list-group-item">Sponsor: <span class="space-left col-xs-12"><b>{{user.username_sponsor}}</b></span></li>
		      <li class="list-group-item">Username: <span class="space-left col-xs-12"><b>{{user.username}}</b></span></li>
		      <li class="list-group-item">Full Name: <span class="space-left col-xs-12 capitalize"><b>{{user.name|e}}</b></span></li>
		      <li class="list-group-item">NRIC: <span class="space-left col-xs-12"><b>{{user.nric_new}}</b></span></li>
		      <li class="list-group-item">Occupation: <span class="space-left col-xs-12 capitalize"><b>{{user.occupation|e}}</b></span></li>
		      <li class="list-group-item">Next Of Kin: <span class="space-left col-xs-12 capitalize"><b>{{user.kin_name|e}}</b></span></li>
		      <li class="list-group-item">Kin Phone: <span class="space-left col-xs-12"><b>{{user.kin_phone}}</b></span></li>
		      <li class="list-group-item">Relation: <span class="space-left col-xs-12 capitalize"><b>{{user.relation|e}}</b></span></li>
		      <li class="list-group-item">Kin NRIC: <span class="space-left col-xs-12"><b>{{user.nric_new_kin}}</b></span></li> 
		      <li class="list-group-item">Address: <span class="space-left col-xs-12 capitalize"><b>{{user.address|e}}</b></span></li>
		      <li class="list-group-item">Address Line 2: <span class="space-left col-xs-12 capitalize"><b>{{user.second_address|e}}</b></span></li>
		      
		      <li class="list-group-item">Postcode: <span class="space-left col-xs-12"><b>{{user.postcode}}</b></span></li>
		      <li class="list-group-item">City: <span class="space-left col-xs-12 capitalize"><b>{{user.city|e}}</b></span></li>
		      <li class="list-group-item">Region: <span class="space-left col-xs-12"><b>{{user.region|e}}</b></span></li>
		      <li class="list-group-item">Phone: <span class="space-left col-xs-12"><b>{{user.telephone}}</b></span></li>
		      <li class="list-group-item">Email: <span class="space-left col-xs-12"><b>{{user.email}}</b></span></li>
		      <li class="list-group-item">Join Date: <span class="space-left col-xs-12"><b>{{user.created}}</b></span></li>
		   </ul> 
	  </div> 
    
      <div class="bs-example user-profile">
        <ul class="list-group">
	      <h4><b>Vehicle Information</b></h4> 
	      <li class="list-group-item">Previous Insurance: <span class="space-left col-xs-12 capitalize"><b>{{user.previous_insuran_company|e}}</li>
	      <li class="list-group-item">Cover Note: <span class="space-left col-xs-12"><b>{{user.cover_note|e}}</b></span></li>
	      <li class="list-group-item">NCD: <span class="space-left col-xs-12"><b>{{user.insuran_ncb}}</b></span></li>
	      <li class="list-group-item">Road Tax: <span class="space-left col-xs-12"><b>{{user.road_tax}}</b></span></li>
	      <li class="list-group-item">Due Date: <span class="space-left col-xs-12"><b>{{user.insuran_due_date}}</b></span></li>
	      
	      <li class="list-group-item">Reg No: <span class="space-left col-xs-12"><b>{{user.reg_number}}</b></span></li>
	      <li class="list-group-item">Owner Name: <span class="space-left col-xs-12 capitalize"><b>{{user.owner_name}}</b></span></li>
	      <li class="list-group-item">Owner NRIC: <span class="space-left col-xs-12"><b>{{user.owner_nric}}</b></span></li>
	      <li class="list-group-item">Owner DOB: <span class="space-left col-xs-12"><b>{{user.owner_dob}}</b></span></li>
	      <li class="list-group-item">Model: <span class="space-left col-xs-12 capitalize"><b>{{user.model|e}}</b></span></li>
	      <li class="list-group-item">Year Make: <span class="space-left col-xs-12"><b>{{user.year_make}}</b></span></li>
	      <li class="list-group-item">Cubic Capacity: <span class="space-left col-xs-12"><b>{{user.capacity}}</b></span></li>
	      <li class="list-group-item">Engine No: <span class="space-left col-xs-12"><b>{{user.engine_number|e}}</b></span></li>
	      <li class="list-group-item">Chasis No: <span class="space-left col-xs-12"><b>{{user.chasis_number|e}}</b></span></li>
	      
	      <li class="list-group-item">Grant Serial: <span class="space-left col-xs-12"><b>{{user.grant_serial_number|e}}</b></span></li>
	      <li class="list-group-item"> 
		   {{ link_to("activations/index?ref=" ~ user.password ~ "&action=activate&activate=bljkX3BjVziItYbEqMZ1SOU2e8Xv6ZuRuTAztmdjVz8fOHeomyeLpuLaIZF4lHT&ntsv=" ~ user.id, "Activate As iKomuniti", "class": "btn btn-success", "onclick": "return confirm('Adakah anda pasti untuk mengaktifkan "~user.username~" sebagai iKomuniti?')") }}
		   &nbsp;&nbsp;&nbsp;&nbsp;
		   {{ link_to("isahabatactivations/index?ref=" ~ user.password ~ "&action=activate&activate=bljkX3BjVziItYbEqMZ1SOU2e8Xv6ZuRuTAztmdjVz8fOHeomyeLpuLaIZF4lHT&ntsv=" ~ user.id, "Activate As iSahabat", "class": "btn btn-primary", "onclick": "return confirm('Adakah anda pasti untuk mengaktifkan "~user.username~" sebagai iSahabat?')") }}
		   &nbsp;&nbsp;&nbsp;&nbsp;
		   {{ link_to("isahabatactivations/index?ref=" ~ user.password ~ "&action=problem&activate=bljkX3BjVziItYbEqMZ1SOU2e8Xv6ZuRuTAztmdjVz8fOHeomyeLpuLaIZF4lHT&ntsv=" ~ user.id, "Problem", "class": "btn btn-danger", "onclick": "return confirm('Adakah anda pasti untuk memindahkan "~user.username~" ke bahagian Problem?')") }} 
		    
		   
		   </li>
	    </ul>   
	  </div>
      {% endfor %}
	    </div>
    </div>
</div> 
{{ partial("partials/footer") }} 


 
			
			