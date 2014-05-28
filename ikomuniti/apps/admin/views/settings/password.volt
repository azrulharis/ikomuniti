<script type="text/javascript">
$(document).ready(function()
{   $('#username').autocomplete(
    {   source: "{{ajaxurl}}",
        minLength: 2
    });
});
</script>

<script type="text/javascript">
$(document).ready(function()
{   $('#username_trans').autocomplete(
    {   source: "{{ajaxurl}}",
        minLength: 2
    });
});
</script>

{{ partial("partials/navigation") }}        
<div class="row">
    <div class="col-lg-12">
	    {{ content()}}
	</div>
	<div class="col-lg-6">  
		<div class="panel panel-success">
			<div class="panel-heading">
			<h3 class="panel-title">iKomuniti Password</h3>
			</div>
			
			<div class="panel-body"> 
			  <form action="" method="post">
			     <div class="form-group">
				     <label>Username</label>
				     <input type="text" name="username" id="username" class="form-control">
				     <input type="hidden" name="token" value="{{token}}">
			     </div>
			     <div class="form-group">
				     <label>Password</label>
				     <input type="password" name="password" class="form-control">
			     </div>
			     <div class="form-group">
				     <label>Retype Password</label>
				     <input type="password" name="retype_password" class="form-control">
			     </div>
			     <div class="form-group">
				     <label>Send SMS</label>
				     <select name="send_sms" class="form-control">
				       <option value="0">Dont Send</option>
				       <option value="1">Send SMS</option> 
				     </select>
			     </div>
			     <div class="form-group"> 
				     <input type="submit" name="change_password" value="Change Password" class="btn btn-primary">
			     </div>
			    </form>
			</div>
		</div> 
	</div> 
	
	<div class="col-lg-6">  
		<div class="panel panel-success">
			<div class="panel-heading">
			<h3 class="panel-title">iKomuniti Transaction Password</h3>
			</div>
			
			<div class="panel-body">
		       <form action="" method="post"> 
			     <div class="form-group">
				     <label>Username</label>
				     <input type="text" name="username" id="username_trans" class="form-control">
				     <input type="hidden" name="token" value="{{token}}">
			     </div>
			     <div class="form-group">
				     <label>Password</label>
				     <input type="password" name="password" class="form-control">
			     </div>
			     <div class="form-group">
				     <label>Retype Password</label>
				     <input type="password" name="retype_password" class="form-control">
			     </div>
			     <div class="form-group"> 
				     <input type="submit" name="trans_password" value="Change Transaction Password" class="btn btn-primary">
			     </div>
			    </form>
			</div>
		</div> 
	</div> 
</div>
 
{{ partial("partials/footer") }}