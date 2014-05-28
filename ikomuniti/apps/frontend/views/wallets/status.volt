{{ partial("partials/navigation") }} 
    <div class="row">
        <div class="col-lg-12">
          
      <div class="panel panel-primary">
        <div class="panel-heading">
		  <h3 class="panel-title">Transaction Histories</h3>
		</div>
		  <div class="panel-body">  
			<div class="bs-example">
			  <ul class="breadcrumb" style="margin-bottom: 5px;">
			    <li>{{ link_to("wallets/index", "iPoint", "class": "jun_button") }}</li>
			    <li>{{ link_to("wallets/histories", "History", "class": "jun_button") }}</li> 
		        <li>{{ link_to("wallets/redeem", "Withdraw", "class": "jun_button") }}</li>
		    <li class="active">Withdrawal Status</li> 
			<li>{{ link_to("wallets/transfer", "Transfer", "class": "jun_button") }}</li> 
			  </ul>
			</div>
	   
		    {{ content()}}
		    <div class="table-responsive">
		      <table class="table table-bordered table-hover table-striped tablesorter"> 
			    <tr>
				 <th>Amount</th><th>Bank Name</th><th>Account Number</th><th>Date</th><th>Status</th><th>Admin Remark</th>
			    </tr>
				{% for hist in status %}
				<tr> 
					<td><p>{{hist.amount}}</p></td>
					<td><p>{{hist.bank}}</p></td>
					<td><p>{{hist.account}}</p></td>
					<td><p>{{hist.created}}</p></td>
					<td><p>{% if hist.status == 0 %}Pending{% elseif hist.status == 1 %}In Progress{% elseif hist.status == 2 %}Rejected{% elseif hist.status == 3 %}Successful{% endif %}</p></td>
					<td><p>{{hist.reason}}</p></td>
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


