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
				<label>Full Name</label>: {{ text_field("name", "size": 30, "value": user.name, "class": "form-control") }}
				</div>
				<div class="form-group">
				<label>NRIC</label>: {{ text_field("nric", "size": 30, "value": user.nric_new, "class": "form-control") }}
				</div>
				<div class="form-group">
				<label>Next Of Kin</label>: {{ text_field("next_of_kin", "size": 30, "value": user.kin_name, "class": "form-control")}}
				</div>
				<div class="form-group">
				<label>Relation</label>: {{ text_field("relation", "size": 30, "value": user.relation, "class": "form-control")}}
				</div>
				<div class="form-group">
				<label>Kin NRIC</label>: {{ text_field("kin_nric", "size": 30, "value": user.nric_new_kin, "class": "form-control")}}
				</div>
				<div class="form-group">
				<label>Account No</label>: {{ text_field("account_no", "size": 30, "value": user.bank_number, "class": "form-control")}}
				</div>
				<div class="form-group">
				<label>Bank Name</label>: {{ text_field("bank_name", "size": 30, "value": user.bank_name, "class": "form-control")}}
				</div>
				<div class="form-group">
				<label>Address</label>: {{ text_area("address", "size": 30, "value": user.address, "class": "form-control")}}
				</div>
				<div class="form-group">
				<label>Postcode</label>: {{ text_field("postcode", "size": 30, "value": user.postcode, "class": "form-control")}}
				</div>
				<div class="form-group">
				<label>Phone</label>: {{ text_field("telephone", "size": 30, "value": user.telephone, "class": "form-control")}}
				</div>
				<div class="form-group">
				<label>Email</label>: {{ text_field("email", "size": 30, "value": user.email, "class": "form-control")}}
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

