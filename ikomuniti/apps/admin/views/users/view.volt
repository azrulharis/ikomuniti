{{ partial("partials/navigation") }} 
<div class="row"> 
  	<div class="col-lg-12"> 
		<div class="well"> 
			<form class="form" action="" method="GET">
			<h4>Search</h4>
				<div class="input-group text-center">
				<input name="query" type="text" class="form-control input-lg" placeholder="Username/Reg No/Phone">
				<span class="input-group-btn"><button name="submit" class="btn btn-lg btn-primary" type="submit">OK</button></span>
				</div>
			</form>
		</div> 
	</div> 
</div> 

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
			    <th>Username</th> <th>Sponsor</th> <th>Due</th> <th>Reg No</th> <th>Model</th> <th>Year</th>
			    </tr>
				{% for post in views %}
				<tr {% if post.insuran_due_date == '0000-00-00' OR post.capacity < 600 OR post.year_make < current OR post.engine_number == '0' OR post.engine_number == 'NA' %}class="warning"{% endif %}>
				    
					<td><p>{{ link_to('gghadmin/users/profile/' ~ post.username, post.username) }}</p></td>
					<td><p>{{post.username_sponsor}}</p></td>
					<td><p>{{post.insuran_due_date}}</p></td>
					<td><p>{{post.reg_number|e}}</p></td>
					<td><p>{{post.model|e}}</p></td>
					<td><p>{{post.year_make}}</p></td>
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