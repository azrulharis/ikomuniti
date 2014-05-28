{{ partial("partials/navigation") }} 
{% for user in profiles %}
<div class="row">
  <div class="col-lg-6">
    <div class="panel panel-info">
      <div class="panel-heading">
        <h3 class="panel-title">Update {{user.username}} quotation</h3>
	  </div>
	  <div class="panel-body">  
	   
	  {{ content() }}
	  {% for post in updates %}
			{{ form('gghadmin/insuran/update/'~post.u_id, 'method': 'post') }}
			    <div class="form-group"> 
				  <label><p>Jumlah Premium (Total Flas) RM <span style="color: #FF0000;">*</span></p></label>{{ text_field("insuran_amount", "size": 20, "value": post.ins_amount, "class": "form-control") }}
				</div>
				
				<div class="form-group"> 
				<label><p>Road Tax Amount RM <span style="color: #FF0000;">*</span></p></label>{{ text_field("road_tax", "size": 20, "value": post.r_amount, "class": "form-control") }}
				</div>
				<div class="form-group"> 
				<label><p>Windscreen (Hanya Untuk Rekod GGHSB) RM</p></label>{{ text_field("wind_screen", "size": 20, "value": post.wind_screen, "class": "form-control") }}
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
				<label><p>Additional Drivers (Separate By Comma/Hanya Untuk Rekod GGHSB)</p></label>{{ text_field("second_driver", "size": 20, "value": post.second_driver, "class": "form-control", "placeholder": "Nama Satu, Nama Dua, Nama Tiga") }}
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
				<label><p>Cover Amount RM <span style="color: #FF0000;">*</span></p></label>{{ text_field("cover", "size": 20, "value": post.cover, "class": "form-control") }}
				</div>
				
				<div class="form-group"> 
				<label><p>Service Charge RM</p></label>
					 <select name="service_charge" class="form-control">
				       <option value="0" {% if post.charge == 0%}selected{%endif%}>Select</option>
				       <option value="20" {% if post.charge == 20%}selected{%endif%}>Normal</option>
				       <option value="30" {% if post.charge == 30%}selected{%endif%}>Urgent</option>
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
				
				{{hidden_field("reg_no", "value": post.reg_no)}}
				{{hidden_field("user_id", "value": post.u_id)}}
				{{hidden_field("due_date", "value": post.due_date)}}
				
			     <div class="form-group"> 
				    {{ submit_button('submit', 'value': 'Update', 'class': 'btn btn-primary', 'onclick': 'return confirm("Adakah anda pasti untuk update Takaful '~post.username~'? Sila semak dengan teliti sebelum menekan butang OK.")') }} 
				</div>
		    </form>
		    {% endfor %}
	      
	     </div>        
      </div>
    </div>
    
<div class="col-lg-6">
    <div class="panel panel-info">
      <div class="panel-heading">
        <h3 class="panel-title">Additional Request</h3>
	  </div>
	  <div class="panel-body">  
	   {% for req in reqs %}
	     <div class="form-group">
	         <span class="pull-left col-md-4">Windscreen </span><span class="pull-right col-md-8">RM{{ req.windscreen }}</span> 
	     </div>
	     <div class="form-group">
	         <span class="pull-left col-md-4">CRP </span><span class="pull-right col-md-8">RM{{ req.crp }}</span> 
	     </div>
	     <div class="form-group">
	        <span class="pull-left col-md-4">Additional Driver</span><span class="pull-right col-md-8">{{ req.additional_driver }}</span> 
	    </div>
	   {% endfor %}
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