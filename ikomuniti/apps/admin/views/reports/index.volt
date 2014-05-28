 <script type="text/javascript">
$(document).ready(function()
{   $('#username').autocomplete(
    {   source: "/ikomuniti/gghadmin/ajax/ajaxusername",
        minLength: 2
    });
});
</script>

{{ partial("partials/navigation") }} 
<div class="row"> 
	
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
			    <li class="active">Joining Report</li>
				<li>{{ link_to("gghadmin/reports/renewal", "Renewal") }}</li>
			    <li>{{ link_to("gghadmin/reports/bankin", "Bank In") }}</li>
				<li>{{ link_to("gghadmin/reports/payout", "Payout") }}</li>
			    <li>{{ link_to("gghadmin/reports/purchase", "Purchase") }}</li>  
			    <li>{{ link_to("gghadmin/reports/iprihatin", "iPrihatin Donation") }}</li>  
			  </ul>
			</div>
		    {{ content()}}
   		    
   <div class="col-lg-6">
	    <div class="well form">
		  <form action="" method="GET">
	      	<h4>From date</h4>
			  <div class="form-group text-center"> 
			  <input type="text" name="start" id="datepicker_from" class="form-control input-lg" value="{% if set_view == 1 %}{{start}}{% endif %}"> 
			</div>
	  	</div>
	</div>
	<div class="col-lg-6"> 
		<div class="well form">  
			<h4>To date</h4>
				<div class="input-group text-center">
				<input name="end" type="text" class="form-control input-lg" id="datepicker_to" value="{% if set_view == 1 %}{{end}}{% endif %}">
				<span class="input-group-btn"><button name="submit_date" class="btn btn-lg btn-primary" type="submit" value="search">Go</button></span>
				</div>
			</form>
		</div> 
	</div>
	<div class="col-lg-12">
	    <div class="well form">
		  <form action="" method="GET">
	      	<h4>Print By Username</h4>
			  <div class="form-group text-center"> 
			     <input type="text" name="username" id="username" class="col-lg-10 form-control input-lg" placeholder="Username"> 
			     <span class="input-group-btn"><button name="search_user" class="col-lg-2 btn btn-lg btn-primary" type="submit" value="search">Go</button></span>
			  </div>
		  </form>
	  	</div>
	</div>
		    {% if set_view == 1 %}
		    <div class="form-group col-md-12"> 
			   {{ counter }} Data Found
			  </div>
			  
			  <div class="col-lg-12">
			  <div class="table-responsive">
		      
			  {% for report in reports %}
				<table class="table table-bordered table-hover table-striped tablesorter"> 
			    <tr>
				 <th>Data</th> <th>Status</th> 
			    </tr>
			    <tr>
				    <td><p>Epin</p></td>
					<td><p>{{ report.epin }}</p></td>  
				</tr>
				<tr>
				    <td><p>Epin Tracking</p></td>
					<td><p>{{ report.last_owner }}</p></td>  
				</tr>
				<tr>
				    <td><p>Username</p></td>
					<td><p>{{ report.username }}</p></td>  
				</tr>
				<tr>
				    <td><p>Sponsor</p></td>
					<td><p>{{ report.username_sponsor }}</p></td>  
				</tr>
				<tr>
				    <td><p>Join Date</p></td>
					<td><p>{{ report.created_at }}</p></td>  
				</tr>
				<tr>
				    <td><p>IC Number</p></td>
					<td><p>{{ report.nric_new }}</p></td>  
				</tr>
				<tr>
				    <td><p>Next Of Kin</p></td>
					<td><p>{{ report.kin_name|e }}</p></td>  
				</tr>
				<tr>
				    <td><p>Relation</p></td>
					<td><p>{{ report.relation|e }}</p></td>  
				</tr>
				<tr>
				    <td><p>Kin NRIC</p></td>
					<td><p>{{ report.nric_new_kin }}</p></td>  
				</tr>
				<tr>
				    <td><p>Account Number</p></td>
					<td><p>{{ report.bank_number|e }}</p></td>  
				</tr>
				<tr>
				    <td><p>Bank</p></td>
					<td><p>{{ report.bank_name|e }}</p></td>  
				</tr>
				<tr>
				    <td><p>Address</p></td>
					<td><p>{{ report.address|e }}</p></td>  
				</tr>
				<tr>
				    <td><p>Postcode</p></td>
					<td><p>{{ report.postcode }}</p></td>  
				</tr>
				<tr>
				    <td><p>Phone</p></td>
					<td><p>{{ report.telephone }}</p></td>  
				</tr>
				<tr>
				    <td><p>Email</p></td>
					<td><p>{{ report.email }}</p></td>  
				</tr>
				<tr>
				    <td><p>Previous Insurance</p></td>
					<td><p>{{ report.previous_insuran_company|e }}</p></td>  
				</tr>
				<tr>
				    <td><p>Cover Note</p></td>
					<td><p>{{ report.cover_note|e }}</p></td>  
				</tr>
				<tr>
				    <td><p>NCD</p></td>
					<td><p>{{ report.insuran_ncb }}</p></td>  
				</tr>
				<tr>
				    <td><p>Road Tax</p></td>
					<td><p>{{ report.road_tax }}</p></td>  
				</tr>
				<tr>
				    <td><p>Due Date</p></td>
					<td><p>{{ report.insuran_due_date }}</p></td>  
				</tr>
				<tr>
				    <td><p>Reg Number</p></td>
					<td><p>{{ report.reg_number }}</p></td>  
				</tr>
				<tr>
				    <td><p>Owner Name</p></td>
					<td><p>{{ report.owner_name|e }}</p></td>  
				</tr>
				<tr>
				    <td><p>Owner NRIC</p></td>
					<td><p>{{ report.owner_nric }}</p></td>  
				</tr>
				<tr>
				    <td><p>Owner DOB</p></td>
					<td><p>{{ report.owner_dob }}</p></td>  
				</tr>
				<tr>
				    <td><p>Model</p></td>
					<td><p>{{ report.model|e }}</p></td>  
				</tr> 
				<tr>
				    <td><p>Year Make</p></td>
					<td><p>{{ report.year_make|e }}</p></td>  
				</tr>
				<tr>
				    <td><p>Engine Capacity</p></td>
					<td><p>{{ report.capacity }}</p></td>  
				</tr>
				<tr>
				    <td><p>Engine Number</p></td>
					<td><p>{{ report.engine_number|e }}</p></td>  
				</tr>
				<tr>
				    <td><p>Chasis Number</p></td>
					<td><p>{{ report.chasis_number|e }}</p></td>  
				</tr>
				<tr>
				    <td><p>Grant Serial Number</p></td>
					<td><p>{{ report.grant_serial_number|e }}</p></td>  
				</tr>
			 
				</table>
				
				{% endfor %}
			  </div>
			   </div>
			  
		     <div class="form-group col-md-12"> 
		     {% if set_print == 1 %}
			   <input type="submit" value="Print" onclick="printIframe(report);" class="btn btn-success"/>
			   <script>function printIframe(objFrame){ objFrame.focus(); objFrame.print(); bjFrame.save(); }</script>
			   <iframe style="display: none;" name="report" id="report" src="{{path}}reports/print?start={{start}}&end={{end}}"></iframe>
			   {% elseif set_print == 2 %}
			   <input type="submit" value="Print" onclick="printIframe(report);" class="btn btn-success"/>
			   <script>function printIframe(objFrame){ objFrame.focus(); objFrame.print(); bjFrame.save(); }</script>
			   <iframe style="display: none;" name="report" id="report" src="{{path}}reports/print?username={{username}}"></iframe>
			   {% endif %}
			</div>
			{% else %}
			<div class="form-group col-md-12">
			<div class="alert alert-dismissable alert-info">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              Please select data between two date to view record.
            </div>
			</div>
			{% endif %}
			</div>
		</div>
	</div>
</div>  

{{ partial("partials/footer") }}
