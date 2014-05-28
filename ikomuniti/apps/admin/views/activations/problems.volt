{{ partial("partials/navigation") }} 
    <div class="row">
        <div class="col-lg-12">
          
      <div class="panel panel-primary">
        <div class="panel-heading">
		  <h3 class="panel-title">iKomuniti Activation</h3>
		</div>
	  <div class="panel-body">
	  <div class="bs-example">
		  <ul class="breadcrumb" style="margin-bottom: 5px;">
		    <li>{{ link_to("gghadmin/activations/index", "Activate iS 1") }}</li>
		    <li>{{ link_to("gghadmin/activations/all", "Activate All") }}</li> 
		    <li>{{ link_to("gghadmin/activations/problems", "Problems Activation") }}</li> 
		  </ul>
		</div>
	  {{ content() }}
	  <div class="table-responsive">
      <table class="table table-bordered table-hover table-striped tablesorter"> 
	    <tr>
	    <th>Username </th> <th>Sponsor</th> <th>Due</th> <th>Reg No</th> <th>Model</th> <th>Actions</th>
	    </tr>
		{% for post in views %}
		<tr>
		    
			<td><p>{{ link_to('gghadmin/users/profile/' ~ post.username, post.username) }}</p></td>
			<td><p>{{post.username_sponsor}}</p></td>
			<td><p>{{post.insuran_due_date}}</p></td>
			<td><p>{{post.reg_number}}</p></td>
			<td><p>{{post.model}}</p></td>
			<td><p>
			{{ link_to("gghadmin/activations/index?ref=" ~ post.xmtlvc ~ "&action=activate&activate=bljkX3BjVziItYbEqMZ1SOU2e8Xv6ZuRuTAztmdjVz8fOHeomyeLpuLaIZF4lHT&ntsv=" ~ post.id, "Activate", "class": "btn btn-success", "onclick": "return confirm('Adakah anda pasti untuk mengaktifkan "~post.username~"?')") }} 
			
			{{ link_to("gghadmin/activations/problems?delete=delete&user_id=" ~ post.id, "Delete", "class": "btn btn-danger", "onclick": "return confirm('Adakah anda pasti untuk padamkan rekod "~post.username~"?')") }}
			
			</p></td>
		{% endfor %}
		</table>
		<div class="row">
			{{ paginationUrl }}
		</div>
	  </div>
	  </div>
</div></div> 
{{ partial("partials/footer") }}