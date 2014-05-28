{{ partial("partials/navigation") }} 
<div class="row">
  	<div class="col-lg-8">
		<div class="panel panel-primary">
          	<div class="panel-heading">
		    	<h3 class="panel-title">Add iOffer > Step 2</h3>
		  	</div>
			<div class="panel-body">    
				<div class="bs-example">
				  <ul class="breadcrumb" style="margin-bottom: 5px;">
				    <li>{{ link_to("gghadmin/ioffer/index", "iOffer") }}</li>
					<li class="active">Add iOffer > Step Two</li>  
				    <li>{{ link_to("gghadmin/ioffer/order", "Orders") }}</li>
				    <li>{{ link_to("gghadmin/ioffer/histories", "Histories") }}</li> 
				  </ul>
				</div>  
	            <div class="alert alert-info alert-dismissable">
	              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	              <p><b>Step 2 of 3: Upload iOffer product image.</b> You can choose up to 4 image. Please use high quality image and it will resize during file upload to save server space.</p>
	            </div>
            	<div class="panel panel-default">
              	<div class="panel-body">
                {{ content() }} 
					{% for post in posts %}  
					<form method="post" action="" enctype="multipart/form-data">
					
					<div class="form-group">	
					<label>Price RM</label>
					    {{ post.price }}
					</div>		
					<div class="form-group">   
					<label>Stock</label>
					    {{ post.stock }}
					</div>
					<div class="form-group"> 
					<label>Title</label>
					    {{ post.title }}
					</div>
					<div class="form-group"> 
					<pre>{{ post.body }}</pre>
					    
					</div> 
					
					<div class="form-group">
					<label>Optional</label><input type="file" name="image[]"/> 
					</div>
					
					<div class="form-group">
					<label>Optional</label><input type="file" name="image[]"/> 
					</div>
					
					<div class="form-group"> 
					<label>Optional</label>
					  <input type="file" name="image[]"/>
					</div> 
					
					<div class="form-group">
					<label>Optional</label> <input type="file" name="image[]"/>
					</div>
					<div class="form-group">
					 {{ submit_button('submit', 'value': 'Next Step', 'class': 'btn btn-primary') }}
					 </div>
					</form>
		            {% endfor %}
              	</div>
        	</div>
		</div>
	</div>
</div>
   

<div class="row">
  <div class="col-lg-4">
     

   <div class="bs-example">
      <div class="list-group">
        <a href="#" class="list-group-item">
          <h4 class="list-group-item-heading">Description</h4>
          <p class="list-group-item-text">The ad heading has to describe the item or the service advertised, no company names or urls are allowed. No unnecessary characters are allowed in the heading.</p>
        </a>
        <a href="#" class="list-group-item">
          <h4 class="list-group-item-heading">Solely marketing</h4>
          <p class="list-group-item-text">It&#39;s only allowed to advertise sales, rentals, jobs and services. To use the ad for pure marketing purposes, i.e. not offering any concrete goods, jobs or services, is not allowed.</p>
        </a>
        <a href="#" class="list-group-item">
          <h4 class="list-group-item-heading">Categorising</h4>
          <p class="list-group-item-text">The ad has to be placed in the category that describes the item or service the best (the ad will be moved to the right category when possible).</p>
        </a>
        <a href="#" class="list-group-item">
          <h4 class="list-group-item-heading">No multiple items in 1 ad</h4>
          <p class="list-group-item-text">You are required to place only one property or vehicle per ad. We would therefore like to advise you to divide your properties or vehicles and place them in separate ads.</p>
        </a>
         
         
      </div>
    </div>

  </div>
</div>
{{ partial("partials/footer") }}