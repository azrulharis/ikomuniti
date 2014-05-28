{{ partial("partials/navigation") }} 
<div class="row">
	<div class="col-sm-12">
    	<div class="panel panel-primary">
       		<a href="/ishare/isharephal/ioffer/index" class="list-group-item active">
            	<i class="glyphicon glyphicon-info-sign"></i>  iOffer
            </a>
   			<div class="panel-body">
   			    {{ content() }}
				<div class="bs-example">
				  <ul class="breadcrumb" style="margin-bottom: 5px;">
				    <li class="active">iOffer</li> 
				    <li>{{ link_to("ioffer/add", "Add iOffer") }}</li>
				    <li>{{ link_to("ioffer/order", "Orders") }}</li>
				    <li>{{ link_to("ioffer/histories", "Histories") }}</li> 
				  </ul>
				</div>  
			   {% for post in posts %}
               <div class="row">
	              <div class="clearfix"></div>
	              <a href="/ishare/isharephal/ioffer/view/{{post.slug}}">
				  <div class="col-md-2 text-center">
				  <img src="{{ioffer_thumb_dir ~ post.image}}" class="img-responsive img-thumbnail pull-center">
				  </div>
	              <div class="col-md-6 text-left">
				  <h4>{{ post.title }}</h4>
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
				  <div class="col-md-7 text-left">
				    <i class="glyphicon glyphicon-star"></i>  <b>RM{{ post.price }}</b><span style="color: #FF0000; text-decoration:line-through"> <b>{{post.market_price}}</b></span> 
				  </div> 
				  <div class="col-md-3 text-left">
				     <i class="glyphicon glyphicon-star"></i> Stock <b>{{ post.stock }}</b>
				  </div>
				   
				  <div class="clearfix"></div>
	               
	              <hr>
              </div>
              {% endfor %}
            </div> 
    	</div> 
	</div>
</div>
{{ partial("partials/footer") }}