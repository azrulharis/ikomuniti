{{ partial("partials/navigation") }} 
<div class="row">
	<div class="col-lg-12">  
  		<div class="panel-body">
		    {{ link_to('imall/add', '<button type="button" class="btn btn-success btn-lg right-button">
			  <i class="glyphicon glyphicon-plus"></i> Post On iMall
			</button>') }} 
	    </div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12"> 
	    
    	<div class="panel panel-primary"> 
	  		<div class="panel-body">
	  			
	
	            {{content()}}
				<form method="get" action="">
				<div class="form-group col-lg-4">
				<input size="32" class="form-control" name="title" id="title" value="" type="text" placeholder="Search item..."/> </div>
				<div class="form-group col-lg-4">
				<select name="category" class="form-control category" id="category">
				<option value="986750">All Categories</option>
				<option value="1"class="jun_select_parent">VEHICLES</option>
				<option value="2">Cars</option>
				<option value="3">Motorcycles</option>
				<option value="4">Car Accessories & Parts</option>
				<option value="5">Other Accessories & Parts</option>
				<option value="6">Other Vehicles</option>
				<option value="7">PROPERTIES</option>
				<option value="8">Apartments</option>
				<option value="9">Houses</option>
				<option value="10">Commercial Properties</option>
				<option value="11">Land</option>
				<option value="12">Rooms</option>
				<option value="13">New Properties</option>
				<option value="14">ELECTRONICS</option>
				<option value="15">Mobile Phones & Gadgets</option>
				<option value="16">TV/Audio/Video/Cameras</option>
				<option value="17">Computers & Accessories</option>
				<option value="18">HOME & PERSONAL ITEMS</option>
				<option value="19">Home & Gardens</option>
				<option value="20">Watches/Accessories</option>
				<option value="21">For Children</option>
				<option value="22">Clothes & Fashions</option>
				<option value="23">LEISURE/SPORTS/HOBBIES</option>
				<option value="24">Sports & Outdoors</option>
				<option value="25">Hobby & Collectibles</option>
				<option value="26">Music/Movies/Books</option>
				<option value="27">Pets</option>
				<option value="28">BUSINESS TO BUSINESS</option>
				<option value="29">Professional/Office Equipment</option>
				<option value="30">Business for Sale</option>
				<option value="31">JOBS & SERVICES</option>
				<option value="32">Jobs</option>
				<option value="33">Services</option>
				<option value="34">TRAVEL</option>
				<option value="35">Accommodation</option>
				<option value="36">Tours and Holidays</option>
				<option value="37">FOODS & BEVERAGES</option>
				<option value="38">Food & Beverages</option>
				<option value="39">OTHERS</option>
				<option value="40">Courses/Seminars/Educations</option>
				<option value="41">Agroculture</option>
				<option value="42">Dropships & Consignment</option>
				<option value="43">Others</option>
				</select>
				</div>
				<div class="form-group col-lg-3">
				<select name="region" class="form-control" id="selectId">
				
				
				<option value="1">Johor</option>
				<option value="2">Melaka</option>
				<option value="3">Negeri Sembilan</option>
				<option value="4">Selangor</option>
				<option value="5">Kuala Lumpur</option>
				<option value="6">Pahang</option>
				<option value="7">Perak</option>
				<option value="8">Kedah</option>
				<option value="9">Pulau Pinang</option>
				<option value="10">Perlis</option>
				<option value="11">Terengganu</option>
				<option value="12">Kelantan</option>
				<option value="13">Sabah</option>
				<option value="14">Sarawak</option>
				</select>
				</div>
				<div class="form-group">
				<input type="submit" name="submit" value="Search" class="btn btn-success">
				</div>
				<div class="search_option"></div>
				</form>	            
                
	    	</div>
		</div>
	</div>
</div> 

<div class="row">
	<div class="col-lg-12">  
	  <div class="panel panel-primary"> 
  		<div class="panel-body">  
  		     
		     {% for post in posts %}
               <div class="row">
	              <div class="clearfix"></div>
	              <a href="/ishare/isharephal/imall/view/{{post.slug}}">
				  <div class="col-md-2 text-center">
				  {% if post.image != '' %}
				  	<img src="{{imall_thumb_image_dir ~ post.image}}" class="img-responsive img-thumbnail pull-center" width="140">
				  {% else %}
				    <img src="{{imall_thumb_image_dir}}no_photo.jpg" class="img-responsive img-thumbnail pull-center" width="140">
				  {% endif %}
				  </div>
	              <div class="col-md-6 text-left">
				  <h4><b>{{ post.title }}</b></h4>
				  </div>
				  </a>
				  <div class="col-md-1 text-left">
				  <h4></h4> 
				  </div>
				  <div class="col-md-3 text-left">
				  <h4><i class="glyphicon glyphicon-time"></i> {{ post.created }}</h4> 
				  </div> 
				  <div class="col-md-7 text-left">
				    <p>{{ post.body }}...</p>
				  </div>
				  <div class="col-md-2 text-left">
				     <p>&nbsp;</p>
				  </div>
				  <div class="col-md-7 text-left" style="margin-top: 10px;">
				    <i class="glyphicon glyphicon-th-large"></i> Category {{post.category}}
				  </div> 
				  <div class="col-md-3 text-left" style="margin-top: 10px;">
				    {% if post.price != 0 %}<i class="glyphicon glyphicon-star"></i> <b>RM{{post.price}}</b>{% endif %}
				  </div> 
				   
				  <div class="clearfix"></div>
	               
	              <hr>
              </div>
              {% endfor %} 
	    </div>
	    {{paginationUrl}}
	    </div>
	</div>
</div>

{{ partial("partials/footer") }} 
