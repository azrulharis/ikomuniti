{{ partial("partials/navigation") }} 
    <div class="row">
        <div class="col-lg-12">
          
      <div class="panel panel-primary">
        <div class="panel-heading">
		  <h3 class="panel-title">Withdrawals</h3>
		</div>
		  <div class="panel-body">  
			<div class="bs-example">
			  <ul class="breadcrumb" style="margin-bottom: 5px;">
			    <li>{{ link_to("gghadmin/withdrawals/index", "Request") }}</li>
				<li>{{ link_to("gghadmin/withdrawals/proceed", "Proceed") }}</li> 
			    <li class="active">Rejected</li>
			    <li>{{ link_to("gghadmin/withdrawals/success", "Success") }}</li> 
			  </ul>
			</div>
	   
		    {{ content()}}
		    <div class="table-responsive">
		      <table class="table table-bordered table-hover table-striped tablesorter"> 
			    <tr>
				 <th>Username</th> <th>Amount</th><th>iPoint Balance</th><th>Bank</th><th>Account</th><th>Created</th><th>Action</th>
			    </tr>
				{% for withdraw in withdraws %}
				<tr>
				    <td>{{withdraw.username}}</td>
					<td>{{withdraw.amount}}</td>
					<td>{{withdraw.balance}}</td>
					<td>{{withdraw.bank}}</td> 
				    <td>{{withdraw.account}}</td>
					<td>{{withdraw.created}}</td>
					<td>{{link_to("gghadmin/withdrawals/view/"~withdraw.w_id, "View", "class": "btn btn-primary")}}</td>
				</tr>
				{% endfor %}
				</table>
			  </div>
		</div>
    </div>
  </div>
</div> 
		
  	
<div class="row">
  <div class="col-lg-12">
    {{ paginationUrl }}
  </div>
</div>

{{ partial("partials/footer") }}