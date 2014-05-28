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
		  <h3 class="panel-title">Joining Reports</h3>
		</div>
			<div class="panel-body">  
			<div class="bs-example">
			  <ul class="breadcrumb" style="margin-bottom: 5px;">
			    <li>{{ link_to("gghadmin/reports/index", "Joining Report") }}</li>
				<li>{{ link_to("gghadmin/reports/renewal", "Renewal") }}</li>
			    <li>{{ link_to("gghadmin/reports/bankin", "Bank In") }}</li>
				<li>{{ link_to("gghadmin/reports/payout", "Payout") }}</li>
			    <li>{{ link_to("gghadmin/reports/purchase", "Purchase") }}</li>  
			    <li class="active">iPrihatin Donation</li>  
			  </ul>
			</div>
		    {{ content()}}
		    <div class="table-responsive">
		      <table class="table table-bordered table-hover table-striped tablesorter"> 
			    <tr class="success">
				 <th>Username</th> <th>Title</th> <th>Amount</th> <th>Date</th> 
			    </tr>
				{% for rep in reports %}
				<tr> 
					<td><p>{{rep.username}}</p></td>
					<td><p>{{link_to('gghadmin/iprihatin/view/'~rep.slug, rep.title)}}</p></td> 
				    <td><p>RM{{rep.amount}}</p></td>
					<td><p>{{rep.donation_date}}</p></td>  
				</tr>
				{% endfor %} 
				<tr>
				    <td></td>
				    <td>Total donations</td>
				    <td><b>RM{{sum_donation}}</b></td>
				    <td></td>
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
