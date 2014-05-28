{{ stylesheet_link("css/view-ads.css") }}
<div class="header_bg">
<div class="container"> 
		<div class="header">
	        {{ link_to('index', image('/img/logo.png')) }}
	        <a href="{{ikomuniti_dir}}/imall/add" class="btn btn-success pull-right"><i class="fa fa-plus-circle"></i> Sell Your Item</a>
	    </div><!-- Header--> 
</div> 
</div>
<div class="container">  
<div class="row">
<div class="col-lg-12">
	<div class="bs-example">
	  <div class="list-group">
	    <a href="#" class="list-group-item active">
	      <i class="glyphicon glyphicon-shopping-cart"></i>  iCart
	    </a>
		{{content()}}
	    <div class="table-responsive">
	    {% if view_item == 1 %}
		<table class="table table-bordered table-hover table-striped tablesorter"> 
		   <thead>
			<tr>
	             <td>Title</td><td>Quantity</td><td>Price/Unit</td><td>Total</td>
	        </tr>
	       </thead> 
	       <tbody> 
	       {% for product in products %}
	           <tr>
	             <td>{{product['product_name']}}</td><td>{{product['product_quantity']}}</td>
				 <td>RM{{product['product_unit_price']}}</td><td>RM{{product['product_price']}}</td>
	           </tr>
	       {% endfor %}
	       <tr>
	         {% for ipoint in ipoints %}
	         <td>iPoint Balance <b>{{ipoint.amount}}</b></td><td></td><td><b>Total </b></td><td><b>RM{{grand_total}}</b></td>
	         {% endfor %}
	       </tr>
	      </tbody>
	    </table> 
		   {{ link_to("find", "Continue Shopping", "class": "btn btn-info") }} 
		   {{ link_to("imall/viewcart?"~field_name~"="~field_value~"&utility=clear", "Clear Cart", "class": "btn btn-danger") }}
	    {% else %}
	        <div class="alert alert-dismissable alert-danger">
	          <button type="button" class="close" data-dismiss="alert">&times;</button>
	          There is no item in cart. 
	        </div>
	
	    {% endif %}
	    </div>
	  </div>
	</div>
  </div> 
</div>
<div class="row">
<div class="col-lg-6">
    	<div class="panel">
			<div class="panel-heading">
			 <h4>Shipping Informations</h4>
			</div>
			<div class="panel-body"> 
			    {{ form('ioffer/checkout', 'method': 'post', 'role': 'form')}}
			    {% for user in navigations %}
			      <div class="form-group">
			        <label>Name<span class="red">*</span></label>
			        <input type="text" name="name" value="{{user.name}}" placeholder="Enter your name" class="form-control">
			      </div>
			      <div class="form-group">
			        <label>Phone Number<span class="red">*</span></label>
			        <input type="text" name="phone" value="{{user.telephone}}" placeholder="Enter your phone number" class="form-control">
			      </div> 
			      <div class="form-group">
			        <label>Address Line 1<span class="red">*</span></label>
			        <input type="text" name="address_one" placeholder="No 38-1, Jalan 7/7B" class="form-control">
			      </div>
			      <div class="form-group">
			        <label>Address Line 2</label>
			        <input type="text" name="address_two" placeholder="Seksyen 7" class="form-control">
			      </div>
				  <div class="form-group">
			        <label>Postcode<span class="red">*</span></label>
			        <input type="text" name="postcode" value="{{user.postcode}}" placeholder="43650" class="form-control">
			      </div> 
			      <div class="form-group">
			        <label>City<span class="red">*</span></label>
			        <input type="text" name="city" placeholder="Bandar Baru Bangi" class="form-control">
			      </div>
			      <div class="form-group">
			        <label>Region<span class="red">*</span></label>
			        <select name="region" class="form-control">
		                <option value="0">Select Region</option>				
					    <option value="Johor">Johor</option>
					    <option value="Melaka">Melaka</option>
					    <option value="Negeri Sembilan">Negeri Sembilan</option>
					    <option value="Selangor">Selangor</option>
					    <option value="Kuala Lumpur">Kuala Lumpur</option>
					    <option value="Pahang">Pahang</option>
					    <option value="Perak">Perak</option>
					    <option value="Kedah">Kedah</option>
					    <option value="Pulau Pinang">Pulau Pinang</option>
					    <option value="Perlis">Perlis</option>
					    <option value="Terengganu">Terengganu</option>
					    <option value="Kelantan">Kelantan</option>
					    <option value="Sabah">Sabah</option>
					    <option value="Sarawak">Sarawak</option>
					</select>

			        {% if view_item == 1 %}
			        <input type="hidden" name="{{field_name}}" value="{{field_value}}" class="form-control"> 
			        {% endif %}
			      </div>
				  {% for ipoint in ipoints %}
			      <div class="form-group">
	                  <label for="disabledSelect">Amount To Pay</label>
	                  {% if ipoint.amount >= grand_total %}
	                  	<input class="form-control" id="disabledInput" type="text" value="{{grand_total}}" disabled>
	                  	<input name="amount_to_pay" class="form-control" type="hidden" value="{{grand_total}}">
	                  {% else %}
	                    <input class="form-control" id="disabledInput" type="text" value="{{grand_total - ipoint.amount}}" disabled>
	                    <input name="amount_to_pay" class="form-control" type="hidden" value="{{grand_total - ipoint.amount}}">
	                  {% endif %}
	              </div>

			      <div class="form-group">
			        <label>Payment Method<span class="red">*</span></label>
			        <select name="payment_method"class="form-control">
			            <option value="0">Select</option>
			            
				            {% if ipoint.amount >= grand_total %}
								<option value="1">iPoint</option>
							{% else %}
							    <option value="2">Online Banking</option>
			            		<option value="3">Credit Card</option>
							{% endif %}
						 
			        </select>
			      </div>
				  {% endfor %}
			      <div class="form-group">
			        <input type="submit" name="submit" value="Proceed To Checkout"  class="btn btn-primary">
 			      </div>
 			      {% endfor %}
			    </form>
			</div>
         </div> 
    </div><!--/articles-->
    
    <div class="col-lg-6">
    	<div class="panel">
           <div class="panel-heading">
		     <h4>Service Informations</h4>
		   </div>
   			<div class="panel-body"> 
              <h4>Payment</h4>
              {{image('img/localbank.jpg', 'class': 'img-responsive img-thumbnail pull-left', 'style': 'margin-right:5px; max-width: 180px;')}} 
			  <p>All prices are in Ringgit Malaysia (MYR) and are subject to change without notice. You can pay using iPoint and currently accept direct payment from major bank in Malaysia including Maybank2u, CimbClicks, RHBonline, Alliance Bank, and Hong Leong Bank. You will be redirected to your preferred payment channel when you proceed to check out. </p>
			  <div class="clearfix"></div>
              <hr> 
              <h4>Delivery</h4>
              {{image('img/poslaju.jpg', 'class': 'img-responsive img-thumbnail pull-left', 'style': 'margin-right:5px; max-width: 180px;')}} 
              <p>All orders that have been paid before 2 pm will be sent to you at the same day. Orders that made on Friday until Sunday will only be shipped on Monday of the following week. We provide both local shipping. All orders within Semenanjung Malaysia, Sabah and Sarawak are shipped using PosLaju. Poslaju is Malaysia Express Mail Service and delivers within 2 - 5 business days. Signature will be required when you received the parcel. Tracking numbers will also be provided after we have sent your parcel. </p> 
            </div>
         </div> 
    </div><!--/articles-->
</div>
</div> <!-- end row -->