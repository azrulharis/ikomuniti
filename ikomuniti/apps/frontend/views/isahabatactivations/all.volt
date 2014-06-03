{{ partial("partials/navigation") }} 
    <div class="row">
        <div class="col-lg-12">
          
      <div class="panel panel-primary">
        <div class="panel-heading">
		  <h3 class="panel-title">All iSahabat Activation</h3>
		</div>
	  <div class="panel-body">
	  <div class="bs-example">
		  <ul class="breadcrumb" style="margin-bottom: 5px;">
		    <li>{{ link_to("isahabatactivations/index", "Activate iS 1") }}</li>
		    <li class="active">Activate All</li> 
		    <li>{{ link_to("isahabatactivations/problems", "Problems Activation") }}</li> 
		  </ul>
		</div>
	  {{ content() }}
	  <div class="form-group">
	  <form action="" method="GET"> 
	  <div class="form-group col-lg-6 col-md-6 col-xs-12">
	      <input type="text" name="search" class="form-control" placeholder="Username or Name">
	  </div>
	  <div class="form-group col-lg-3 col-md-3 col-xs-12">
	      <button type="submit" name="submit" class="btn btn-success"><i class="fa fa-search"></i> Search</button>
	  </div>
	  </form>
	  </div>
	  <div class="table-responsive">
      <table class="table table-bordered table-hover table-striped tablesorter"> 
	    <tr>
	    <th>Username</th> <th>Sponsor</th> <th>Due</th> <th>Reg No</th> <th>Phone</th> <th>Actions</th>
	    </tr>
		{% for post in views %}
		<tr>
		    
			<td><p>{{post.username}}</p></td>
			<td><p>{{post.username_sponsor}}</p></td>
			<td><p>{{post.insuran_due_date}}</p></td>
			<td><p>{{post.reg_number|e}}</p></td>
			<td><p>{{post.telephone|e}}</p></td>
			<td><p>
			{{ link_to("activations/profile/" ~ post.username, "View Profile", "class": "btn btn-success") }} </p></td>
		</tr>
		{% endfor %}
		</table>
		<div class="row">
			{{ paginationUrl }}
		</div>
	  </div>
	  </div>
</div></div> 
{{ partial("partials/footer") }}