<script type="text/javascript">
$(document).ready(function()
{   $('#username').autocomplete(
    {   source: "{{ajaxurl}}",
        minLength: 2
    });
});
</script>
{{ partial("partials/navigation") }}  
<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Add iPoint</h3>
	  </div>
	  <div class="panel-body">  
	     <div class="bs-example">
			  <ul class="breadcrumb" style="margin-bottom: 5px;">
			    <li>{{ link_to("gghadmin/wallets/index", "Add iPoint") }}</li>
				<li class="active">View iPoint</li>
			    <li>{{ link_to("gghadmin/wallets/deduct", "Deduct iPoint") }}</li>
			    <li>{{ link_to("gghadmin/wallets/admin", "Request") }}</li> 
			  </ul>
			</div>
		    {{ content() }}
			<div class="col-xs-12">
		        <form action="" method="GET">
		        <div class="form-group col-xs-6">
				    {{ text_field("username", "size": 14, "id": "username", "class": "form-control") }}
				</div>
				 
				<div class="form-group col-xs-6">
				{{ submit_button('submit', 'name': 'submit', 'value': 'View', 'class': 'btn btn-success') }}
				</div>
				</form> 
			</div>
			{% if view_hist == 1 %}
	        <div class="table-responsive">
		      <table class="table table-bordered table-hover table-striped tablesorter"> 
			    <tr>
				  <th>Title</th> <th>Amount</th><th>Ref</th><th>Date</th><th>PIC</th><th>Type</th>
			    </tr>
				{% for hist in hists %}
				<tr>
				    <td><p>{{ hist.title }}</p></td>
					<td><p>{{hist.amount}}</p></td> 
				    <td><p>{{hist.ref}}</p></td>
					<td><p>{{hist.created}}</p></td>
					<td><p>{{hist.pic_username}}</p></td>
					<td><p>{{hist.type}}</p></td>
				</tr>
				{% endfor %} 
				{% for wallet in wallets %}
				<tr>
				    <td><p>Balance</p></td>
					<td><p><b>RM{{wallet.amount}}</b></p></td>
					<td></td> 
				    <td></td>
					<td></td>
					<td></td>
				</tr>
				{% endfor %}
				</table>
			  </div>
			  {% else %} 
			      <div class="alert alert-dismissable alert-warning">
	                <button type="button" class="close" data-dismiss="alert">&times;</button>
	                 Please select username to view iPoint and transaction hostory.
	              </div>

			  {% endif %}
	     </div>        
      </div>
    </div>   
</div>
<div class="row">
	    <div class="col-lg-12">
	        {% if view_hist == 1 %}
	            {{ paginationUrl }}
	        {% endif %}
	    </div>
	</div>  
{{ partial("partials/footer") }}