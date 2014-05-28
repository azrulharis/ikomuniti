{{ partial("partials/navigation") }} 
<div class="row">
	<div class="col-sm-12">
    	<div class="panel panel-primary"> 
   			<div class="panel-body">
   			    {{ content() }} 
			   {% for post in posts %}
               <div class="row">
	              <div class="clearfix"></div>
	              <a href="/ikomuniti/ioffer/view/{{post.slug}}">
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
				  <h4><i class="fa fa-clock-o"></i> {{ post.created }}</h4> 
				  </div> 
				  <div class="col-md-7 text-left">
				    <p>{{ post.body }}...</p>
				  </div>
				  <div class="col-md-2 text-left">
				     <p>&nbsp;</p>
				  </div>
				  <div class="col-md-7 text-left">
				    <i class="fa fa-tags"></i>  <b>RM{{ post.price }}</b><span style="color: #FF0000; text-decoration:line-through"> <b>{{post.market_price}}</b></span> 
				  </div> 
				  <div class="col-md-3 text-left">
				     <i class="fa fa-star"></i> Stock <b>{{ post.stock }}</b>
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