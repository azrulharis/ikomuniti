{{ partial("partials/navigation") }} 
<div class="row">
	<div class="col-md-12 col-sm-12">
    	<div class="panel panel-primary">
       		<a href="/ishare/isharephal/gghadmin/ioffer/index" class="list-group-item active">
            	<i class="glyphicon glyphicon-info-sign"></i>  iOffer
            </a>
   			<div class="panel-body">
				<div class="bs-example">
				  <ul class="breadcrumb" style="margin-bottom: 5px;">
				    <li class="active">iOffer</li> 
				    <li>{{ link_to("gghadmin/ioffer/add", "Add iOffer") }}</li>
				    <li>{{ link_to("gghadmin/ioffer/order", "Orders") }}</li>
				    <li>{{ link_to("gghadmin/ioffer/histories", "Histories") }}</li> 
				  </ul>
				</div>  
			   {% for post in posts %}
               <div class="row">
	              <div class="clearfix"></div>
	              <a href="/ishare/isharephal/gghadmin/ioffer/view/{{post.id}}">
				  <div class="col-md-2 text-center">
				  {% if post.image != '' %}
				  	<img src="{{ioffer_thumb_dir ~ post.image}}" class="img-responsive img-thumbnail pull-center">
				  {% else %}
				  	<img src="{{ioffer_thumb_dir}}no_photo.jpg" class="img-responsive img-thumbnail pull-center">
				  {% endif %}
				  </div>
	              <div class="col-md-6 text-left">
				  <h4>{{ post.title }}</h4>
				  </div>
				  </a>
				  <div class="col-md-1 text-left">
				  <h4>RM{{ post.price }}</h4> 
				  </div>
				  <div class="col-md-3 text-left">
				  <h4>On {{ post.created }}</h4> 
				  </div> 
				  
				  <div class="col-md-7 text-left">
				    <p>Balance <b>{{ post.stock }}</b> Views <b>{{ post.counter }}</b></p>
				  </div> 
				  <div class="col-md-3 text-left">
				    {{ link_to("gghadmin/ioffer/edit/"~post.id, "Edit", "class": "btn btn-primary") }}
				    {{ link_to("gghadmin/ioffer/delete/"~post.id, "Delete", "class": "btn btn-danger") }}
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