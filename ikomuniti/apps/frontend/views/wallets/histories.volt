<script>
$(function() {
$( "#datepicker_from" ).datepicker({changeMonth: true,
changeYear: true, dateFormat: "yy-mm-dd", stepMonths: 12});
});
$(function() {
$( "#datepicker_to" ).datepicker({changeMonth: true,
changeYear: true, dateFormat: "yy-mm-dd", stepMonths: 12});
});
</script>

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
			    <li class="active">History</li>
		        <li>{{ link_to("wallets/redeem", "Withdraw", "class": "jun_button") }}</li>
		    <li>{{ link_to("wallets/status", "Withdrawal Status", "class": "jun_button") }}</li> 
			<li>{{ link_to("wallets/transfer", "Transfer", "class": "jun_button") }}</li> 
			  </ul>
			</div>
			<div class="panel panel-primary"><div class="panel-body"> 
		        <form action="" method="GET">
		        <div class="form-group col-md-4">
		            <input type="text" name="date_from" class="form-control" id="datepicker_from" size="30" placeholder="YYYY-MM-DD">
		        </div>
		        <div class="form-group col-md-4">
		            <input type="text" name="date_to" class="form-control" id="datepicker_to" size="30" placeholder="YYYY-MM-DD">
		        </div>
		        <div class="form-group col-md-4">
		            <input type="submit" name="submit" value="Search" class="btn btn-success">
		        </div>
	        </div></div>
		    {{ content()}}
		    <div class="table-responsive">
		      <table class="table table-bordered table-hover table-striped tablesorter"> 
			    <tr>
				 <th>Title</th> <th>Amount</th> <th>Reference</th> <th>Created</th> <th>Type</th>
			    </tr>
				{% for hist in views %}
				<tr>
				    <td><p>{{hist.title}}</p></td>
					<td><p>{{hist.amount}}</p></td> 
					<td><p>{{hist.reference}}</p></td>
					<td><p>{{hist.created}}</p></td>
					<td><p>{{hist.type}}</p></td>
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


