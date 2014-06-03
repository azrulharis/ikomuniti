{{ partial("partials/navigation") }} 
<div class="row">
    <div class="col-lg-12">
      
      <div class="panel panel-primary">
        <div class="panel-heading">
		  <h3 class="panel-title">iSetting</h3>
		</div>
		  <div class="panel-body">
		    <div class="bs-example">
			  <ul class="breadcrumb" style="margin-bottom: 5px;">
			  <li>{{ link_to("settings/profile", "Profile") }}</li> 
			    <li class="active">Personal Informations</li>
			    <li>{{ link_to("settings/vehicle", "Vehicle Informations") }}</li> 
			    <li>{{ link_to("settings/account", "Account Settings") }}</li> 
			  </ul>
			</div>
			{{ content() }}
		  {% for user in users %}
		    {{ form('settings/personal', 'method': 'post') }}	
				<div class="form-group">    
				<label>Username</label>: {{ user.username }}
				</div>
				<div class="form-group">
				<label>Full Name <span class="red">*</span></label>: {{ text_field("name", "size": 30, "value": user.name, "class": "form-control") }}
				</div>
				<div class="form-group">
				<label>NRIC <span class="red">*</span></label>: {{ text_field("nric", "size": 30, "value": user.nric_new, "class": "form-control") }}
				</div>
				<div class="form-group">
				<label>Next Of Kin <span class="red">*</span></label>: {{ text_field("next_of_kin", "size": 30, "value": user.kin_name, "class": "form-control")}}
				</div>
				<div class="form-group">
				<label>Relation <span class="red">*</span></label>: {{ text_field("relation", "size": 30, "value": user.relation, "class": "form-control")}}
				</div>
				<div class="form-group">
				<label>Kin NRIC <span class="red">*</span></label>: {{ text_field("kin_nric", "size": 30, "value": user.nric_new_kin, "class": "form-control")}}
				</div>
				<div class="form-group">
				<label>Account Number</label>: {{ text_field("account_no", "size": 30, "value": user.bank_number, "class": "form-control")}}
				</div>
				<div class="form-group">
				<label>Bank Name </label>: {{ text_field("bank_name", "size": 30, "value": user.bank_name, "class": "form-control")}}
				</div>
				<div class="form-group">
				<label>Address Line 1  <span class="red">*</span></label>: {{ text_field("address", "size": 30, "value": user.address, "class": "form-control")}}
				</div>
				
				<div class="form-group">
				<label>Address Line 2 </label>: {{ text_field("second_address", "size": 30, "value": user.second_address, "class": "form-control")}}
				</div>
				<div class="form-group">
				<label>Postcode  <span class="red">*</span></label>: {{ text_field("postcode", "size": 30, "value": user.postcode, "class": "form-control")}}
				</div>
				<div class="form-group">
				<label>City  <span class="red">*</span></label>: {{ text_field("city", "size": 30, "value": user.city, "class": "form-control")}}
				</div>
				<div class="form-group">
				<label>Region  <span class="red">*</span></label> 
					<select name="region" class="form-control"> 
						<option value="">Select Region</option>
						<option value="Johor"{%if user.region == 'Johor'%} selected{%endif%}>Johor</option>
						<option value="Melaka"{%if user.region == 'Melaka'%} selected{%endif%}>Melaka</option>
						<option value="Negeri Sembilan"{%if user.region == 'Negeri Sembilan'%} selected{%endif%}>Negeri Sembilan</option>
						<option value="Selangor"{%if user.region == 'Selangor'%} selected{%endif%}>Selangor</option>
						<option value="Kuala Lumpur"{%if user.region == 'Kuala Lumpur'%} selected{%endif%}>Kuala Lumpur</option>
						<option value="Pahang"{%if user.region == 'Pahang'%} selected{%endif%}>Pahang</option>
						<option value="Perak"{%if user.region == 'Perak'%} selected{%endif%}>Perak</option>
						<option value="Kedah"{%if user.region == 'Kedah'%} selected{%endif%}>Kedah</option>
						<option value="Pulau Pinang"{%if user.region == 'Pulau Pinang'%} selected{%endif%}>Pulau Pinang</option>
						<option value="Perlis"{%if user.region == 'Perlis'%} selected{%endif%}>Perlis</option>
						<option value="Terengganu"{%if user.region == 'Terengganu'%} selected{%endif%}>Terengganu</option>
						<option value="Kelantan"{%if user.region == 'Kelantan'%} selected{%endif%}>Kelantan</option>
						<option value="Sabah"{%if user.region == 'Sabah'%} selected{%endif%}>Sabah</option>
						<option value="Sarawak"{%if user.region == 'Sarawak'%} selected{%endif%}>Sarawak</option>
					</select>
				</div>
				
				<div class="form-group">
				<label>Phone <span class="red">*</span></label>: {{ text_field("telephone", "size": 30, "value": user.telephone, "class": "form-control")}}
				</div>
				<div class="form-group">
				<label>Email </label>: {{ text_field("email", "size": 30, "value": user.email, "class": "form-control")}}
				</div>
				<div class="form-group">
				 {{ submit_button('submit', 'value': 'Save', 'class': 'btn btn-primary') }}
				</div>
			</form>
			{% endfor %}
	      </div>
	  </div>
    </div>
</div> 
{{ partial("partials/footer") }}

