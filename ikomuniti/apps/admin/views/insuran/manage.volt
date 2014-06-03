{{ partial("partials/navigation") }} 
<div class="row"> 
  	<div class="col-lg-4"> 
		<div class="well"> 
			<form class="form" action="" method="GET">
			<h4>Search</h4>
				<div class="input-group text-center">
				<input name="query" type="text" class="form-control input-lg" placeholder="Username/Reg No/Phone">
				<span class="input-group-btn"><button name="submit" class="btn btn-lg btn-primary" type="submit">OK</button></span>
				</div>
			</form>
		</div> 
	</div>
	<div class="col-lg-4">
	    <div class="well form">
		  <form action="" method="GET">
	      	<h4>From date</h4>
			  <div class="form-group text-center"> 
			  <input type="text" name="from" id="datepicker_from" class="form-control input-lg"> 
			</div>
	  	</div>
	</div>
	<div class="col-lg-4"> 
		<div class="well form">  
			<h4>To date</h4>
				<div class="input-group text-center">
				<input name="to" type="text" class="form-control input-lg" id="datepicker_to">
				<span class="input-group-btn"><button name="submit_date" class="btn btn-lg btn-primary" type="submit">Go</button></span>
				</div>
			</form>
		</div> 
	</div>
</div>     
 <div class="row">
        <div class="col-lg-12">
          
      <div class="panel panel-primary">
        <div class="panel-heading">
		  <h3 class="panel-title">Need To Update</h3>
		</div>
		  <div class="panel-body">  
      
      <div class="bs-example">
		  <ul class="breadcrumb" style="margin-bottom: 5px;">
	        <li class="active">iManagement <b>{{count_imanagement}}</b></li> 
	      <li>{{ link_to("gghadmin/insuran/quotation", "Updated") }}</li>
		  <li>{{ link_to("gghadmin/insuran/kiv", "Kiv") }}</li>
	      <li>{{ link_to("gghadmin/insuran/problems", "Problems") }}</li>
	      <li>{{ link_to("gghadmin/insuran/done", "Done") }}</li>
	      </ul>
      </div> 
	  {{ content() }}     
	   <div class="alert alert-info alert-dismissable">
	      Senarai kereta yang akan tamat tempoh dalam masa 1 bulan. Selepas update, ia akan pindah ke bahagian Updated untuk proses Renewal. Merah menandakan iSahabat.
	    </div>
	   <div class="table-responsive">
		      <table class="table table-bordered table-hover table-striped tablesorter"> 
	    <tr>
	    <th>Username</th><th>Reg No</th><th>Telephone</th> <th>Due</th> <th>Insuran</th> <th>Roadtax</th> <th>Wallet</th> <th>Total</th> <th>Year</th> <th>Action</th>
	    </tr>
		{% for post in views %}
		<tr {%if post.role == 3%}class="danger"{%endif%}>
		    
			<td><p>{{ link_to('gghadmin/users/profile/' ~ post.username, post.username) }}</p></td>
			<td><p>{{post.reg_no}}</p></td>
			<td><p>{{post.tel}}</p></td>
			<td><p>{{post.due}}</p></td>
			<td><p>{{post.ins_amount}}</p></td>
			<td><p>{{post.r_amount}}</p></td>
			<td><p>{{post.amount}}</p></td>
			<td><p>{{post.total}}</p></td>
			 
			<td><p>{{post.year}}</p></td>
			<td><p>{{ link_to("gghadmin/insuran/update/" ~ post.id, "Update", "class": "btn btn-primary") }} &nbsp; 
			</p></td>
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