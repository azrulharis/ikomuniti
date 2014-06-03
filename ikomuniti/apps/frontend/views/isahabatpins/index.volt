{{ partial("partials/navigation") }} 
    <div class="row">
        <div class="col-lg-12">
          
      <div class="panel panel-primary">
        <div class="panel-heading">
		  <h3 class="panel-title">iSahabat iPin</h3>
		</div>
	  <div class="panel-body">
	  
	  <div class="bs-example">
          <ul class="breadcrumb" style="margin-bottom: 5px;">
		    <li class="active">iSahabat iPin</li> 
		    <li>{{ link_to("isahabatpins/transfer", "Transfer iPin") }}</li>
		    <li>{{ link_to("isahabatpins/track", "Track") }}</li>
		  </ul>
      </div>
    
     
      {{ content()}}
    <div class="table-responsive">
      <table class="table table-bordered table-hover table-striped tablesorter"> 
	    <tr>
	    <th>iPin</th> <th>Status</th><th>Created</th>  
	    </tr>
		{% for pin in epins %}
		<tr>
			<td><p>{{pin.epin}}</p></td>
			<td><p>{% if pin.used_username is empty %} Available {% else %} {{pin.used_username}} {% endif %}</p></td> 
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