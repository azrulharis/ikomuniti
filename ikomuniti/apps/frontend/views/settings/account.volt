{{ partial("partials/navigation") }} 
<div class="row">
    <div class="col-lg-12">
      
      <div class="panel panel-primary">
        <div class="panel-heading">
		  <h3 class="panel-title">SMS Setting</h3>
		</div>
		  <div class="panel-body">
		    <div class="bs-example">
			  <ul class="breadcrumb" style="margin-bottom: 5px;">
			    <li>{{ link_to("settings/profile", "Profile") }}</li>
			    <li>{{ link_to("settings/personal", "Personal Informations") }}</li>
			    <li>{{ link_to("settings/vehicle", "Vehicle Informations") }}</li> 
			    <li class="active">Account Settings</li> 
			  </ul>
			</div>
			{{ content() }}
		  {% for user in users %}
		    {{ form('settings/account', 'method': 'post') }}	
			 
	   <div class="form-group">
	      <label>SMS Commission Notification</label> 
	      <label class="radio-inline">
                  <input type="radio" name="sms_setting" id="optionsRadiosInline1" value="1" {% if user.sms_setting == 1 %}checked{% endif %}> Send SMS
                </label>
                <label class="radio-inline">
                  <input type="radio" name="sms_setting" id="optionsRadiosInline2" value="0" {% if user.sms_setting == 0 %}checked{% endif %}> Dont send SMS
                </label> 

	    </div>
 
	   
	   <div class="form-group">
	      {{ submit_button('submit', 'name': 'sms', 'value': 'Change SMS Setting', 'class': 'btn btn-primary') }}
      </div>
      </form>
			{% endfor %}
	      </div>
	  </div>
    </div>
</div> 

<div class="row">
    <div class="col-lg-12">
      
      <div class="panel panel-primary">
        <div class="panel-heading">
		  <h3 class="panel-title">Change Password</h3>
		</div>
		  <div class="panel-body">
		     
		  {% for user in users %}
		    {{ form('settings/account', 'method': 'post') }}	
			 
 
	   <div class="form-group">
	      <label>Change Password</label>: {{ password_field("password", "class": "form-control") }}
	      
	      </div>
	   <div class="form-group">
	      <label>Retype Password</label>: {{ password_field("retype_password", "class": "form-control") }}
	      </div>
	   <div class="form-group">
	      <label>Old Password</label>: {{ password_field("old_password", "class": "form-control") }}
	      </div> 
	   <div class="form-group">
	      {{ submit_button('submit', 'name': 'change_password', 'value': 'Change Password', 'class': 'btn btn-primary') }}
      </div>
      </form>
			{% endfor %}
	      </div>
	  </div>
    </div>
</div> 

<div class="row">
    <div class="col-lg-12">
      
      <div class="panel panel-primary">
        <div class="panel-heading">
		  <h3 class="panel-title">Change Transaction Password</h3>
		</div>
		  <div class="panel-body">
		     
		  {% for user in users %}
		    {{ form('settings/account', 'method': 'post') }}	
			 
	   <div class="form-group"> 
	      <label>Transaction Password</label>: {{ password_field("transaction_password", "class": "form-control") }}
	   </div>
	   <div class="form-group"> 
	      <label>Retype Transaction Password</label>: {{ password_field("retype_transaction_password", "class": "form-control") }}
	   </div>
	   <div class="form-group"> 
	      <label>Old Transaction Password</label>: {{ password_field("old_transaction_password", "class": "form-control") }}
	   </div>
	   
	   <div class="form-group">
	      {{ submit_button('submit', 'name': 'trans_password', 'value': 'Change Transaction Password', 'class': 'btn btn-primary') }}
      </div>
      </form>
			{% endfor %}
	      </div>
	  </div>
    </div>
</div> 
{{ partial("partials/footer") }}

