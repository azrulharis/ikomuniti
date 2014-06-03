{{ partial("partials/navigation") }} 
    <div class="row">
        <div class="col-lg-12">
          
      <div class="panel panel-primary">
        <div class="panel-heading">
		  <h3 class="panel-title">Problems Activation</h3>
		</div>
	  <div class="panel-body">
	  <div class="bs-example">
		  <ul class="breadcrumb" style="margin-bottom: 5px;">
		    <li>{{ link_to("isahabatactivations/index", "Activate iS 1") }}</li>
		    <li>{{ link_to("isahabatactivations/all", "Activate All") }}</li> 
		    <li class="active">Problems Activation</li> 
		  </ul>
		</div>
	  {{ content() }}
	  <div class="table-responsive">
      <table class="table table-bordered table-hover table-striped tablesorter"> 
	    <tr>
	    <th>Username {{ role }}</th> <th>Sponsor</th> <th>Due</th> <th>Reg No</th> <th>Phone</th> <th>Actions</th>
	    </tr>
		{% for post in views %}
		<tr>
		    
			<td><p>{{post.username}}</p></td>
			<td><p>{{post.username_sponsor}}</p></td>
			<td><p>{{post.insuran_due_date}}</p></td>
			<td><p>{{post.reg_number}}</p></td>
			<td><p>{{post.telephone}}</p></td>
			<td><p>
			{{ link_to("activations/profile/" ~ post.username, "View Profile", "class": "btn btn-success") }} </p></td>
		{% endfor %}
		</table>
		<div class="row">
			{{ paginationUrl }}
		</div>
	  </div>
	  </div>
</div></div> 
{{ partial("partials/footer") }}