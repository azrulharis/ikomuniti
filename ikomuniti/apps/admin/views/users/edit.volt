<script>
  $(function() {
	$("#dob").datepicker({
	    changeMonth: true,
        changeYear: true, 
		dateFormat: "yy-mm-dd", 
		stepMonths: 12,
		minDate: new Date(1930, 11 - 1, 6),
        yearRange: '1930:2010'
		});
	});
</script>

{{ partial("partials/navigation") }} 
{% for user in users %}
<div class="row">
	<div class="col-lg-12">
	<div class="panel"><div class="panel-body"> 
	  {{ link_to('gghadmin/users/profile/'~user.username, '<i class="fa fa-user"></i> Back To '~user.username~' Profile', 'class': 'btn btn-success')}}
	  {{ link_to('gghadmin/users/view', '<i class="fa fa-search"></i> Back To Search Page', 'class': 'btn btn-primary')}}
	</div></div>
	</div>
</div>
<div class="row">
<div class="col-lg-12">
  <div class="panel panel-primary">
    <div class="panel-heading">
	  <h3 class="panel-title">Edit {{user.username}} Profile</h3>
	</div>
	<div class="panel-body">     
	{{ content()}}
	
	<form action="" method="POST">
	<div class="form-group">
	<label>Name</label>
	<input type="text" name="name" class="form-control" value="{{user.name|e}}">
	</div>
	
	<div class="form-group">
	<label>NRIC</label>
	<input type="text" name="nric_new" class="form-control" value="{{user.nric_new}}">
	</div>
	
	<div class="form-group">
	<label>Next Of Kin</label>
	<input type="text" name="kin_name" class="form-control" value="{{user.kin_name|e}}">
	</div>
	
	<div class="form-group">
	<label>Kin Phone</label>
	<input type="text" name="kin_phone" class="form-control" value="{{user.kin_phone}}">
	</div>
	
	<div class="form-group">
	<label>Relation</label>
	<input type="text" name="relation" class="form-control" value="{{user.relation|e}}">
	</div>
	
	<div class="form-group">
	<label>Next of Kin NRIC</label>
	<input type="text" name="nric_new_kin" class="form-control" value="{{user.nric_new_kin}}">
	</div>
	
	<div class="form-group">
	<label>Acc Number (Optional)</label>
	<input type="text" name="bank_number" class="form-control" value="{{user.bank_number|e}}">
	</div>
	
	<div class="form-group">
	<label>Bank Name (Optional)</label>
	<input type="text" name="bank_name" class="form-control" value="{{user.bank_name|e}}">
	</div>
	
	<div class="form-group">
	<label>Address</label>
	<input type="text" name="address" class="form-control" value="{{user.address|e}}">
	</div>
	
	<div class="form-group">
	<label>Postcode</label>
	<input type="text" name="postcode" class="form-control" value="{{user.postcode}}">
	</div>
	
	<div class="form-group">
	<label>iKomuniti Phone Number</label>
	<input type="text" name="telephone" class="form-control" value="{{user.telephone}}">
	</div>
	
	<div class="form-group">
	<label>Email</label>
	<input type="text" name="email" class="form-control" value="{{user.email}}">
	</div> 
		      
	<div class="form-group">
	<label>Previous Insurance Company</label>
	<input type="text" name="previous_insuran_company" class="form-control" value="{{user.previous_insuran_company|e}}">
	</div>
	
	<div class="form-group">
	<label>Cover Note</label>
	<input type="text" name="cover_note" class="form-control" value="{{user.cover_note|e}}">
	</div>
	
	<div class="form-group">
	<label>NCD</label>
	<select class="form-control" name="insuran_ncb">
					<option value="">Pilih</option>
					<option value="0" {%if user.insuran_ncb == 0%}selected{%endif%}>0%</option>
					<option value="25" {%if user.insuran_ncb == 25%}selected{%endif%}>25%</option>
					<option value="30" {%if user.insuran_ncb == 30%}selected{%endif%}>30%</option>
					<option value="38.33" {%if user.insuran_ncb == 38.33%}selected{%endif%}>38.33%</option>
					<option value="45" {%if user.insuran_ncb == 45%}selected{%endif%}>45%</option>
					<option value="55" {%if user.insuran_ncb == 55%}selected{%endif%}>55%</option>
				</select>
 
	</div>
	
	<div class="form-group">
	<label>Road Tax Amount RM</label>
	<input type="text" name="road_tax" class="form-control" value="{{user.road_tax}}">
	</div>
	
	<div class="form-group">
	<label>Insurance Due Date</label>
	<input type="text" name="insuran_due_date" id="datepicker_from" class="form-control" value="{{user.insuran_due_date}}">
	</div>
	
	<div class="form-group">
	<label>Reg Number (Without Space)</label>
	<input type="text" name="reg_number" class="form-control" value="{{user.reg_number}}">
	</div>
	
	<div class="form-group">
	<label>Vehicle Owner Name</label>
	<input type="text" name="owner_name" class="form-control" value="{{user.owner_name}}">
	</div>
	
	<div class="form-group">
	<label>Owner NRIC</label>
	<input type="text" name="owner_nric" class="form-control" value="{{user.owner_nric}}">
	</div>
	
	<div class="form-group">
	<label>Owner D.O.B</label>
	<input type="text" name="owner_dob" id="dob" class="form-control" value="{{user.owner_dob}}">
	</div>
	
	<div class="form-group">
	<label>Model</label>
	<input type="text" name="model" class="form-control" value="{{user.model|e}}">
	</div>
	
	<div class="form-group">
	<label>Year Make</label>
	<input type="text" name="year_make" class="form-control" value="{{user.year_make}}">
	</div>
	
	<div class="form-group">
	<label>Engine Capacity (Number only)</label>
	<input type="text" name="capacity" class="form-control" value="{{user.capacity}}">
	</div>
	
	<div class="form-group">
	<label>Engine Number</label>
	<input type="text" name="engine_number" class="form-control" value="{{user.engine_number|e}}">
	</div>
	
    <div class="form-group">
	<label>Chasis Number</label>
	<input type="text" name="chasis_number" class="form-control" value="{{user.chasis_number|e}}">
	</div>
	
	<div class="form-group">
	<label>Grant Serial Number</label>
	<input type="text" name="grant_serial_number" class="form-control" value="{{user.grant_serial_number|e}}">
	<input type="hidden" name="user_id" value="{{user.id}}">
	</div>  
	
	<div class="form-group">
 
	<input type="submit" name="submit" class="btn btn-success" value="Save">
	</div>  
	 </form>          
	{% endfor %}  
      </div>
	</div>
  </div>
</div> 
{{ partial("partials/footer") }}