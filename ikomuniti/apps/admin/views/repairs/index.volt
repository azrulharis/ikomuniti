

<div class="row">
    <div class="col-lg-12">
          
      <div class="panel panel-primary">
        <div class="panel-heading">
		  <h3 class="panel-title">iKomuniti</h3>
		</div>
		  <div class="panel-body"> 
            {{ content()}}
	        <div class="table-responsive">
		      <table class="table table-bordered table-hover table-striped tablesorter"> 
			    <tr>
			    <th>Username</th> <th>Owner Ic</th> <th>Owner Ic True</th> <th>Postcode</th> <th>Postcode True</th> <th>User Ic</th><th>Owner Name</th><th>Name</th>
			    </tr>
				{% for post in views %}
				<tr>
				    
					<td><p>{{ post.username }}</p></td>
					<td><p>{{post.owner_ic}}</p></td>
					<td><p>{{post.d_owner_ic}}</p></td>
					<td><p>{{post.postcode|e}}</p></td>
					<td><p>{{post.pin|e}}</p></td>
					<td><p>{{post.d_nric}}</p></td>
					<td><p>{{post.d_owner_name}}</p></td>
					<td><p>{{post.d_name}}</p></td>
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
 