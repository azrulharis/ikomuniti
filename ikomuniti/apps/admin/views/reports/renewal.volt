{{ partial("partials/navigation") }} 
<div class="row"> 
	<div class="col-lg-6">
	    <div class="well form">
		  <form action="" method="GET">
	      	<h4>From date</h4>
			  <div class="form-group text-center"> 
			  <input type="text" name="start" id="datepicker_from" class="form-control input-lg"> 
			</div>
	  	</div>
	</div>
	<div class="col-lg-6"> 
		<div class="well form">  
			<h4>To date</h4>
				<div class="input-group text-center">
				<input name="end" type="text" class="form-control input-lg" id="datepicker_to">
				<span class="input-group-btn"><button name="submit_date" class="btn btn-lg btn-primary" type="submit" value="search">Go</button></span>
				</div>
			</form>
		</div> 
	</div>
</div>     
<div class="row">
    <div class="col-lg-12">
          
      <div class="panel panel-primary">
        <div class="panel-heading">
		  <h3 class="panel-title">Renewal Reports</h3>
		</div>
			<div class="panel-body">  
			<div class="bs-example">
			  <ul class="breadcrumb" style="margin-bottom: 5px;">
			    <li>{{ link_to("gghadmin/reports/index", "Joining Report") }}</li>
				<li class="active">Renewal</li>
			    <li>{{ link_to("gghadmin/reports/bankin", "Bank In") }}</li>
				<li>{{ link_to("gghadmin/reports/payout", "Payout") }}</li>
			    <li>{{ link_to("gghadmin/reports/purchase", "Purchase") }}</li>  
			    <li>{{ link_to("gghadmin/reports/iprihatin", "iPrihatin Donation") }}</li> 
			  </ul>
			</div>
		    {{ content()}}
		    <div class="table-responsive">
		      <table class="table table-bordered table-hover table-striped tablesorter"> 
			    <tr class="success">
				 <th>Username</th> <th>Reg No</th> <th>Insurance</th> <th>Roadtax</th> <th>Cover</th> 
				 <th>Service Charge</th><th>Total</th><th>Created</th><th>PIC</th>
			    </tr>
				{% for rep in reports %}
				<tr> 
					<td><p>{{rep.ikomuniti_username}}</p></td>
					<td><p>{{rep.reg_number}}</p></td> 
				    <td><p>RM{{rep.insurance}}</p></td>
					<td><p>{{rep.road_tax}}</p></td>
					<td><p>{{rep.cover}}</p></td>
					<td><p>{{rep.service_charge}}</p></td>
					<td><p>{{rep.insurance + rep.road_tax + rep.service_charge }}</p></td> 
				    <td><p>{{rep.created_at}}</p></td>
					<td><p>{{rep.pic_username}}</p></td>
				</tr>
				{% endfor %} 
				<tr class="success">
				    <td><p>Result</p></td>
					<td><p><b>{{ result }}</b></p></td> 
				    <td><p></p></td> 
					<td><p>Gross</p></td>
					<td><p><b>RM{{ gross }}</b></p></td> 
				    <td><p>Profit</p></td>
					<td><p><b>RM{{ gross_profit }}</b></p></td>
					<td><p></p></td> 
					<td><p></p></td>
				</tr> 
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
