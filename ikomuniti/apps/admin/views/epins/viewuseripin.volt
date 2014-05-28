<script type="text/javascript">
$(document).ready(function()
{
    $('#username').autocomplete(
    {
        source: "{{urlajax}}",
        minLength: 2
    });
});
</script>
{{ partial("partials/navigation") }} 
    <div class="row">
        <div class="col-lg-12">
          
      <div class="panel panel-primary">
        <div class="panel-heading">
		  <h3 class="panel-title">iPin informations</h3>
		</div>
		  <div class="panel-body">  
			<div class="bs-example">
			  <ul class="breadcrumb" style="margin-bottom: 5px;">
			    <li>{{ link_to("gghadmin/epins/index", "iPin", "class": "jun_button") }}</li>
				<li>{{ link_to("gghadmin/epins/add", "Add iPin", "class": "jun_button") }}</li>
			    <li>{{ link_to("gghadmin/epins/transfer", "Transfer iPin", "class": "jun_button") }}</li>
			    <li class="active">View iKomuniti iPin</li>
			    <li>{{ link_to("gghadmin/epins/track", "Track", "class": "jun_button") }}</li> 
			  </ul>
			</div>
			
		{{ content()}}
		 
         {{  form('gghadmin/epins/viewuseripin', 'method': 'get') }} 
        <div class="form-group">
		  <label>iKomuniti Username </label>{{ text_field("username", "id": "username", "class": "form-control", "data-role": "none", "value": get_username) }} 
		</div>
		 
		  {{ submit_button('submit', 'value': 'Search', 'class': 'btn btn-primary') }}
		 
		</form> 
   
 <div class="table-responsive">
		      <table class="table table-bordered table-hover table-striped tablesorter"> 
	    <tr>
		 <th>iPin</th> <th>Used</th> <th>Owner</th>  <th>Transfer History</th><th>Created</th>
	    </tr>
		{% for pin in epins %}
		<tr>
		    <td><p>{{pin.epin}}</p></td>
			<td><p>{% if pin.used_username is empty %} Available {% else %} {{pin.used_username}} {% endif %}</p></td>
			<td><p>{{pin.username}}</p></td> 
		    <td><p>{{pin.last_owner}}</p></td>
			<td><p>{{pin.created}}</p></td>
		</tr>
		{% elsefor %}
		<div class="alert alert-danger alert-dismissable"> 
              No record, please select iKomuniti username to view data.</p>
            </div>
		{% endfor %}
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