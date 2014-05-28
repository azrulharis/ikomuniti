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
			    <li class="active">Add iPoint</li>
				<li>{{ link_to("gghadmin/wallets/view", "View iPoint") }}</li>
			    <li>{{ link_to("gghadmin/wallets/deduct", "Deduct iPoint") }}</li>
			    <li>{{ link_to("gghadmin/wallets/admin", "Request") }}</li> 
			  </ul>
			</div>
	  {{ content() }}
		{% if hideform == 1 %}
			
		{% else %}
        <form action="" method="GET">
        <div class="form-group">
		    <label>Username</label>{{ text_field("username", "size": 14, "id": "username", "class": "form-control") }}
		</div>
		<div class="form-group">
		    <label>Jumlah RM</label>{{ text_field("amount", "size": 14, "placeholder": "0.00", "class": "form-control") }}
		</div>
		<div class="form-group">
		{{ submit_button('submit', 'name': 'submit', 'value': 'Langkah Seterusnya', 'class': 'btn btn-success') }}
		</div>
		</form>
		{% endif %}
	      
	     </div>        
      </div>
    </div>    
</div>
{{ partial("partials/footer") }}