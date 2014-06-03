<script>
  $(function() {
	$( "#due_date" ).datepicker({
	 changeMonth: true,
     changeYear: true, 
	 dateFormat: "yy-mm-dd", 
	 stepMonths: 12,
	 minDate: new Date(2010, 11 - 1, 6),
     yearRange: '2010:2018'
	 });
	}); 
  $(function() {
	$( "#dob" ).datepicker({
	 changeMonth: true,
     changeYear: true, 
	 dateFormat: "yy-mm-dd", 
	 stepMonths: 12,
	 minDate: new Date(1940, 11 - 1, 6),
     yearRange: '1940:2014'
	 });
	});
</script>
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
			    <li>{{ link_to("settings/personal", "Personal Informations") }}</li>
			    <li class="active">Vehicle Informations</li> 
			    <li>{{ link_to("settings/account", "Account Settings") }}</li> 
			  </ul>
			</div>
		  {{ content() }}
		  {% for user in users %}
		    {{ form('settings/vehicle', 'method': 'post') }}	
		<div class="form-group"> 
	      <label>Previous Insurance</label>: {{ text_field("previous_insurance", "size": 30, "value": user.previous_insuran_company, "class": "form-control") }}
	   </div>
	   <div class="form-group">
	      <label>Cover Note</label>: {{ text_field("cover_note", "size": 30, "value": user.cover_note, "class": "form-control") }}
	      </div>
	   <div class="form-group">
	      <label>NCD</label>: 
	      
	      <select class="form-control" name="ncd">
					<option value="">Select</option>
					<option value="0"{% if user.ncd == 0 %} selected{%endif%}>0%</option>
					<option value="25"{% if user.ncd == 25 %} selected{%endif%}>25%</option>
					<option value="30"{% if user.ncd == 30 %} selected{%endif%}>30%</option>
					<option value="38.33"{% if user.ncd == '38.33' %} selected{%endif%}>38.33%</option>
					<option value="45"{% if user.ncd == 45 %} selected{%endif%}>45%</option>
					<option value="55"{% if user.ncd == 55 %} selected{%endif%}>55%</option>
				</select>
	      </div>
	   <div class="form-group">
	      <label>Road Tax</label>: {{ text_field("road_tax_amount", "size": 30, "value": user.road_tax, "class": "form-control") }}
	      </div>
	   <div class="form-group">
	      <label>Due Date</label>: <input type="text" name="cvm" value="{{user.next_renewal}}" class="form-control" disabled>
	      <input type="hidden" name="due_date" value="{{user.next_renewal}}" class="form-control">
		   
	      </div>
	   <div class="form-group">
	      
	      <label>Reg No <span class="red">*</span></label>: <input type="text" name="nvmv" value="{{user.reg_number}}" class="form-control" disabled>
		  <input type="hidden" name="reg_no" value="{{user.reg_number}}" class="form-control"> 
	      </div>
	   <div class="form-group">
	      <label>Owner Name <span class="red">*</span></label>: {{ text_field("owner_name", "size": 30, "value": user.owner_name, "class": "form-control") }}
	      </div>
	   <div class="form-group">
	      <label>Owner NRIC <span class="red">*</span></label>: {{ text_field("owner_nric", "size": 30, "value": user.owner_nric, "class": "form-control") }}
	      </div>
	   <div class="form-group">
	      <label>Owner DOB <span class="red">*</span></label>: {{ text_field("owner_dob", "id": "dob", "value": user.owner_dob, "class": "form-control") }}
	      </div>
	   <div class="form-group">
	      <label>Model <span class="red">*</span></label>: {{ text_field("model", "size": 30, "value": user.model, "class": "form-control") }}
	      </div>
	   <div class="form-group">
	      <label>Year Make <span class="red">*</span></label>: {{ text_field("year_make", "size": 30, "value": user.year_make, "class": "form-control") }}
	      </div>
	   <div class="form-group">
	      <label>Cubic Capacity <span class="red">*</span></label>: {{ text_field("cubic_capacity", "size": 30, "value": user.capacity, "class": "form-control") }}
	      </div>
	   <div class="form-group">
	      <label>Engine No <span class="red">*</span></label>: {{ text_field("engine_no", "size": 30, "value": user.engine_number, "class": "form-control") }}
	      </div>
	   <div class="form-group">
	      <label>Chasis Number <span class="red">*</span></label>: {{ text_field("chasis_no", "size": 30, "value": user.chasis_number, "class": "form-control") }}
	      </div>
	   <div class="form-group">
	      
	      <label>Grant Serial Number</label>: {{ text_field("grant_serial", "size": 30, "value": user.grant_serial_number, "class": "form-control") }}
	      </div>
	   <div class="form-group">
	      {{ submit_button('submit', 'value': 'Update', 'class': 'btn btn-primary') }}
      </div>
      </form>
			{% endfor %}
	      </div>
	  </div>
    </div>
</div> 
{{ partial("partials/footer") }}

