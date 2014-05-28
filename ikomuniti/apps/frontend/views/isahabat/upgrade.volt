{{ partial("partials/navigation") }} 
    <div class="row">
        <div class="col-lg-12">
          
      <div class="panel panel-primary">
        <div class="panel-heading">
		  <h3 class="panel-title">iReseller Lists</h3>
		</div>
	  <div class="panel-body"> 	 
      {{ content()}}
    <div class="table-responsive">
      <table class="table table-bordered table-hover table-striped tablesorter"> 
	    <tr>
	    <th>Username</th> <th>Name</th><th>Phone</th> <th>Address</th> 
	    </tr>
		{% for ireseller in iresellers %}
		<tr>
			<td><p>{{ireseller.username}}</p></td>
			<td><p>{{ireseller.name}}</p></td> 
			<td><p>{{ireseller.telephone}}</p></td> 
			<td><p>{{ireseller.address}}</p></td> 
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