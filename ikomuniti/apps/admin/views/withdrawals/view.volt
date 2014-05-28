{{ partial("partials/navigation") }}
<div class="row">
    <div class="col-lg-12">  
        <div class="alert alert-dismissable alert-warning">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong>Attention!</strong> Please make sure iKomuniti iPoint balance is available to renew on next. 
        </div> 

        {{ content() }}
	    
	</div>
</div>

<div class="row">
{% for withdraw in withdraws %}
<div class="col-lg-6">
    <div class="bs-example">
      <div class="list-group">
        <a href="#" class="list-group-item active">
          <i class="glyphicon glyphicon-bookmark"></i> Withdrawal
        </a>
        <div class="table-responsive">
		<table class="table table-bordered table-hover table-striped tablesorter"> 
        
             <tr>
			   <td>Username: </td><td>{{ withdraw.username }}</td>
			 </tr>
             <tr><td>Amount: </td><td>RM{{ withdraw.amount }}</td></tr>
             <tr><td>Bank Name: </td><td>{{ withdraw.bank }}</td></tr>
             <tr><td>Account Number: </td><td>{{ withdraw.account }}</td></tr>
             <tr><td>Created: </td><td>{{ withdraw.created }}</td></tr>
             <tr><td>iPoint Balance: </td><td>{{ withdraw.balance }}</td></tr>
             <tr><td>Last Total Insurance Amount: </td><td>RM{{ withdraw.total }}</td></tr>
             <tr><td>Last Renew: </td><td>{{ withdraw.last_renewal }}</td></tr> 
        
        </table>
        </div>
      </div>
    </div>
  </div>
  
<div class="col-lg-6"> 
		<div class="panel panel-primary">
			<div class="panel-heading">
			<h3 class="panel-title">Proceed</h3>
			</div>
			<div class="panel-body">
			<form method="POST" action="">			
			<div class="form-group">
			    <label>Amount RM</label>
				<input class="form-control" name="amount" value="{{withdraw.amount}}" type="text" />
				<input class="form-control" name="user_id" value="{{withdraw.u_id}}" type="hidden" /> 		
			</div>
			<div class="form-group">
			<label>Action</label><select name="action" class="form-control">
		       <option value="0">Select</option>
		       <option value="1">Proceed</option>
		       <option value="2">Reject</option> 
		    </select>
		    </div>
		    <div class="form-group">
				<label>If reject, add reason</label>
				<textarea name="reason" class="form-control"></textarea>
		    </div>
			<div class="form-group">
			    <input value="Submit" class="btn btn-primary" type="submit" />			
			</div>
			</form>
			</div>
		</div>
	</div>
 {% endfor %}           
</div>