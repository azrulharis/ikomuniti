
{{ partial("partials/navigation") }}  
<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Add iPoint Request</h3>
	  </div>
	  <div class="panel-body">  
	     <div class="bs-example">
			  <ul class="breadcrumb" style="margin-bottom: 5px;">
			    <li>{{ link_to("gghadmin/wallets/index", "Add iPoint") }}</li>
				<li>{{ link_to("gghadmin/wallets/view", "View iPoint") }}</li>
			    <li>{{ link_to("gghadmin/wallets/deduct", "Deduct iPoint") }}</li>
			    <li class="active">Request</li> 
			  </ul>
			</div>
		    {{ content() }}  
	        <div class="table-responsive">
		      <table class="table table-bordered table-hover table-striped tablesorter"> 
			    <tr>
				  <th>Username</th><th>Amount</th><th>Payment Date</th><th>Payment Time</th><th>Date</th><th>From Acc</th><th>Remark</th><th>Action</th>
			    </tr>
				{% for req in requests %}
				<script type="text/javascript">
				    $(function() {
				        $('#readmore{{req.mid}}').click(function() {
				        $('.result{{req.mid}}').toggle();
				        return false;
				        }); 
				    });
				</script>
				<tr>
				    <td><p>{{ req.username|e }}</p></td>
					<td><p>{{ req.amount|e }}</p></td> 
				    <td><p>{{req.date|e}}</p></td>
					<td><p>{{req.time|e}}</p></td>
					<td><p>{{req.created}}</p></td>
					<td><p>{% if req.from_acc != ''%}{{req.from_acc|e}}{%else%}CDM{%endif%}</p></td>
					<td><p><a href="" id="readmore{{req.mid}}">Read More</a><div class="result{{req.mid}}" style="display:none; width:240px;height:auto;">{{req.remark|e}}</div></p></td>
					<td><a href="admin?id={{req.mid}}" class="btn btn-success">Delete</a></td>
				</tr>
				{% elsefor %} 
				
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