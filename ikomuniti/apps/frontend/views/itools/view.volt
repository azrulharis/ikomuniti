{{ partial("partials/navigation") }}
<div class="row">
	<div class="col-lg-12"> 
		{{link_to('itools/index', 'class': 'btn btn-primary', '<i class="fa fa-bullhorn"></i> iTool Home')}}
		{{link_to('itools/view', 'class': 'btn btn-success', '<i class="fa fa-bar-chart-o"></i> iTool Statistic')}}   
	</div>
</div> <!--/.row -->

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-primary">
		  <div class="panel-heading">
		    <h3 class="panel-title"><i class="fa fa-bars"></i> Visitor Detail</h3>
		  </div>
		  
		  <div class="panel-body">
		     <div class="table-responsive">
		      <table class="table table-bordered table-hover table-striped tablesorter"> 
			    <tr>
				 <th>Date</th> <th>Status</th> <th>Username</th>  <th>Total Visit</th><th>Referral</th>
			    </tr>
				{% for stat in stats %}
				<tr>
				    <td><p>{{stat.created}}</p></td>
					<td><p>{% if stat.status == 0 %}Not Register{%else%}Registered{% endif %}</p></td>
					<td><p>{{stat.d_username}}</p></td> 
				    <td><p class="text-center">{{stat.counter}}</p></td>
					<td><p>{{stat.ref}}</p></td>
				</tr>
				{% endfor %}
				</table>
			  </div>
		  </div>
		</div>
	</div>
</div> <!--/.row -->

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-primary">
		  <div class="panel-heading">
		    <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Visitor Statistic</h3>
		  </div>
		  
		  <div class="panel-body">
		    <div id="stats"></div>
		  </div>
		</div>
	</div>
</div> <!--/.row -->
        
<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-success">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Click And Register Statistic</h3>
      </div>
      <div class="panel-body">
        <div id="graphisahabat"></div>
      </div>
    </div>
  </div>
</div> <!--/.row -->   

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-success">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> iKomuniti Registration (iS 1)</h3>
      </div>
      <div class="panel-body">
        <div id="graphikomuniti"></div>
      </div>
    </div>
  </div>
</div> <!--/.row --> 
{{ partial("partials/footer") }}
{{ javascript_include("js/morris-0.4.3.min.js") }}  
{{ javascript_include("js/morris/ref-stats.js") }}