{{ partial("partials/navigation") }} 
<div class="row">
  <div class="col-lg-12">
	  <div class="panel panel-primary">
	    <div class="panel-heading">
		  <h3 class="panel-title">iNews</h3>
		</div>
	      <div class="panel-body">  
      		{{ content()}}
		    <div class="table-responsive">
		      <table class="table table-bordered table-hover table-striped tablesorter"> 
			     
				{% for inews in news %}
				<tr>
				    
					<td><p>{{ link_to('news/view/'~inews.slug, inews.title) }}</p></td>
					<td><p>{{inews.body}}</p></td>
					<td><p>{{inews.created}}</p></td> 
					<td><p>{{ link_to('news/view/'~inews.slug, 'View', 'class': 'btn btn-primary') }}</p></td> 
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