{{ partial("partials/navigation") }} 
    <div class="row">
        <div class="col-lg-12">
          
      <div class="panel panel-primary">
        <div class="panel-heading">
		  <h3 class="panel-title">iPin Tracking</h3>
		</div>
	  <div class="panel-body">
	  
	    <div class="bs-example">
		  <ul class="breadcrumb" style="margin-bottom: 5px;">
		    <li>{{ link_to("gghadmin/epins/index", "iPin", "class": "jun_button") }}</li>
			<li>{{ link_to("gghadmin/epins/add", "Add iPin", "class": "jun_button") }}</li>
		    <li>{{ link_to("gghadmin/epins/transfer", "Transfer iPin", "class": "jun_button") }}</li>
		    <li>{{ link_to("gghadmin/epins/viewuseripin", "View iKomuniti iPin", "class": "jun_button") }}</li>
		    <li class="active">Track</li> 
		  </ul>
		</div>
 
    
     
      {{ content()}}
    <div class="table-responsive">
      <table class="table table-bordered table-hover table-striped tablesorter"> 
	    <tr>
	    <th>iPin</th> <th>Used Usename</th> <th>Tracking</th> <th>Activator</th><th>Created</th>  
	    </tr>
		{% for pin in epins %}
		<tr>
		    
			 
			<td><p>{{pin.epin}}</p></td>
			<td><p>{{pin.username}}</p></td>
			<td><p>{{pin.last_owner}}</p></td>
			<td><p>{{pin.activator_username}}</p></td>
			<td><p>{{pin.created}}</p></td> 
		</tr>
		{% endfor %}
		</table>
	</div>
        <div class="row">
			{{ paginationUrl }}
		</div>
	  </div>
	  </div>
</div></div> 
{{ partial("partials/footer") }}