{{ partial("partials/navigation") }}
 
<div class="row">
<div class="col-lg-12">
	<div class="panel panel-primary">
	    <a href="#" class="list-group-item active">
	      <i class="glyphicon glyphicon-shopping-cart"></i>  iCart
	    </a>
	    <div class="panel-body">
		    {{content()}}
		    {% for user in navigations %}
		    {% if view_success == 1 %}
		    
		    
		      
		    
		      {% if payment_method == 1 %} 
		        <h1>Amount to pay: <b>RM{{amount_to_pay}}</b></h1>
		        {{ form('payment/ipoint', 'method': 'post')}}
					<input type="hidden" name="{{return_name}}" value="{{return_value}}"> 
					<input type="hidden" name="ord_totalamt" value="{{amount_to_pay}}" />  
					<input type="hidden" name="ord_mercref" value="{{order_id}}">
					<input type="hidden" name="ord_shipname" value="{{user.username}}">  
					<input type="submit" name="submit" value="Pay With iPoint" class="btn btn-success"> 
				</form> 
		      {% else %}
		      {% for ipoint in ipoints %}
		        <div class="alert alert-dismissable alert-info">
	              <button type="button" class="close" data-dismiss="alert">&times;</button>
	              <strong>Note!</strong> Please complete the step during this transaction. You will redirect to our payment processor.
	            </div>
                <div class="table-responsive"> 
					<table class="table table-bordered table-hover table-striped tablesorter"> 
					   <thead>
						<tr>
				             <td>Title</td> <td>Total</td>
				        </tr>
				       </thead> 
				       <tbody> 
				        
				           <tr>
				             <td>Total Item Price</td><td>RM{{grand_amount}}</td> 
				           </tr>
				           <tr>
				             <td>iPoint Balance</td><td>{{ipoint.amount}}</td> 
				           </tr>
				           <tr>
				             <td>Webcash Service Charge</td><td>{% if payment_method == 2 %}2%{% elseif payment_method == 3 %}4%{% endif %}</td> 
				           </tr>
				           <tr>
				             <td>Amount To Pay</td><td><b>RM{{amount_to_pay}}</b</td> 
				           </tr>
				        
				      </tbody>
				    </table>
				</div>  
                
		        <form action="https://webcash.com.my/wcgatewayinit.php" method="post">  
					<input type="hidden" name="ord_date" value="{{date}}"> 
					<input type="hidden" name="ord_totalamt" value="{{amount_to_pay}}" /> 
					<input type="hidden" name="ord_shipname" value="{{user.username}}"> 
					<input type="hidden" name="ord_shipcountry" value="Malaysia"> 
					<input type="hidden" name="ord_mercref" value="{{order_id}}"> 
					<input type="hidden" name="ord_telephone" value="{{phone}}"> 
					<input type="hidden" name="ord_email" value="{{user.email}}"> 
					<input type="hidden" name="ord_delcharges" value="0.00"> 
					<input type="hidden" name="ord_svccharges" value="0.00"> 
					<input type="hidden" name="ord_mercID" value="80000706"> 
					<input type="hidden" name="ord_returnURL" value="{{host}}ioffer/verification/{{order_id}}?{{return_name}}={{return_value}}"> 
					<input type="submit" name="submit" value="Pay With Webcash" class="btn btn-success"> 
				</form>
				{% endfor %}
		      {% endif %}
		    {% endif %}
		    {% endfor %}
	    </div> 
	  </div>
	</div>  
</div>
 
{{ partial("partials/footer") }}