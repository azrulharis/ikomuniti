{{ partial("partials/navigation") }} 
<div class="row">
	<div class="col-lg-12">  
  		<div class="panel-body">
		    {{ link_to('imall/index', '<i class="fa fa-plus"></i> My Ads', 'class': 'btn btn-primary') }}  
			{{ link_to('imall/add', '<i class="fa fa-plus"></i> Post On iMall', 'class': 'btn btn-success') }} 
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
	              <a href="/ikomuniti/imall/view/{{post.slug}}">
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
				  <h4><i class="fa fa-clock-o"></i> {{ post.created }}</h4> 
				  </div> 
				  <div class="col-md-7 text-left">
				    <p>{{ post.body }}...</p>
				  </div>
				  <div class="col-md-2 text-left">
				     <p>&nbsp;</p>
				  </div>
				  <div class="col-md-5 text-left" style="margin-top: 10px;">
				    <i class="fa fa-bars"></i> {{post.category}}
				  </div>  
				  <div class="col-md-2 text-left" style="margin-top: 10px;">
				    <i class="fa fa-eye"></i> {{post.hit}} Views
				  </div> 
				  <div class="col-md-3 text-left" style="margin-top: 10px;">
				    {% if post.price != 0 %}<i class="fa fa-tag"></i> <b>RM{{post.price}}</b>{% endif %}
				  </div> 
				   
				  <div class="clearfix"></div>
	               
	              <hr>
              </div>
              {% elsefor %}
              <div class="col-lg-12">
    <div class="alert alert-dismissable alert-danger">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <p>You have no post on iMall yet.</p>
    </div>
  </div>
              {% endfor %} 
	    </div>
	    {{ paginationUrl }}
	    </div>
	</div>
</div>

{{ partial("partials/footer") }}