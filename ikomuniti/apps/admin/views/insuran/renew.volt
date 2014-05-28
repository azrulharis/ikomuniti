<script>
  $(function() {
	$( "#due_date" ).datepicker({
	 changeMonth: true,
     changeYear: true, 
	 dateFormat: "yy-mm-dd", 
	 stepMonths: 12,
	 minDate: new Date({{ date_picker_from }}, 11 - 1, 6),
     yearRange: '{{ date_picker_from }}:{{ date_picker_to }}'
	 });
	});  
</script>
{{ partial("partials/navigation") }} 
{% for user in profiles %}
<div class="row">
  <div class="col-lg-6">
    <div class="panel panel-info">
      <div class="panel-heading">
        <h3 class="panel-title">Renew {{user.username}} Insurance</h3>
	  </div>
	  <div class="panel-body">  
	   
	  {{ content() }}

       
		
        {% for post in updates %}
			{{ form('gghadmin/insuran/renew/'~post.u_id, 'method': 'post') }}
			    
				  <div class="form-group"> 
				    <label>Insurance Premium RM</label> {{ text_field("insuran_amount", "size": 20, "value": post.ins_amount, "class": "form-control") }}
				  </div>
				  <div class="form-group"> 
				
				    <label>Road Tax RM</label> {{ text_field("road_tax", "size": 20, "value": post.r_amount, "class": "form-control") }}
				</div>
				  <div class="form-group"> 
				
				
				    <label>Sum Insured RM</label> {{ text_field("cover", "size": 20, "value": post.cover, "class": "form-control") }}
				</div>
				  <div class="form-group"> 
				
				     <label>Service Charge RM</label> {{ text_field("service_charge", "size": 20, "value": post.charge, "class": "form-control") }}
				</div>
				  <div class="form-group"> 
				
				     <label>Total RM</label> {{ text_field("total", "size": 20, "value": post.total, "class": "form-control") }}
				     <input type="hidden" name="reg_no" value="{{post.reg_no}}">
				     <input type="hidden" name="telephone" value="{{post.tel}}">
				</div>
				  <div class="form-group"> 
				     <label>iWallet Balance RM</label> {{ post.amount }}{{ hidden_field("wallet", "size": 20, "value": post.amount) }}
				</div>
				  <div class="form-group"> 
				
				     <label>Amount To Pay RM</label> {{ amount_to_pay }}{{ hidden_field("amount_to_pay", "size": 20, "value": amount_to_pay) }} 
				</div>
				<div class="form-group"> 
				
				     <label>Next Due Date <span style="color: #FF0000;">IMPORTANT! Must be + 1 year</span></label> {{ text_field("next_renewal", "id": "due_date", "value": post.due, "class": "form-control") }}
				</div>
				<div class="form-group"> 
				
				     <label>Tracking Code</label> {{ text_field("tracking_code", "value": post.tracking_code, "class": "form-control") }}
				</div>
				  <div class="form-group"> 
				
				     <label>Add iWallet RM</label> {{ text_field("add_iwallet", "size": 20, "placeholder": amount_to_pay, "class": "form-control") }} 
				{{hidden_field("reg_no", "value": post.reg_no)}}
				{{hidden_field("user_id", "value": post.u_id)}}
				</div>
				   
				
				
				<div class="form-group">
			     
				    {{ submit_button('submit', 'value': 'Renew', 'class': 'btn btn-success', 'onclick': 'return confirm("Adakah anda pasti untuk memperbaharui Takaful dan Cukai Jalan '~ post.username~'? Sila semak dengan teliti sebelum menekan butang OK.")') }}
				</div>
		    </form>
		{% endfor %}
      
      </div>        
      </div>
    </div>
    
<div class="col-lg-6">
    <div class="panel panel-info">
      <div class="panel-heading">
        <h3 class="panel-title">Roadtax Calculator</h3>
	  </div>
	  <div class="panel-body">  
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
	  <h3 class="panel-title">{{user.username}} Profile</h3>
	</div>
	<div class="panel-body">   
          
      <div class="bs-example user-profile">
            <ul class="list-group">
         
        
	       <h4><b>Personal Information</b></h4> 
		   
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
	    </ul>  
           
{% endfor %} 
  </div>
</div> 
      </div>
	</div>
  </div>
</div> 
{{ partial("partials/footer") }}