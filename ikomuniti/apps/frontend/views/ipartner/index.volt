{{ partial("partials/navigation") }} 
<div class="row">
	<div class="col-lg-12">  
  		<div class="panel-body">
		    {{ link_to('ipartner/index', '<i class="fa fa-plus"></i> My iPartner', 'class': 'btn btn-primary') }}  
			{{ link_to('ipartner/add', '<i class="fa fa-plus"></i> Post New iPartner', 'class': 'btn btn-success') }} 
	    </div>
	</div>
</div>
    <div class="row">
        <div class="col-lg-12">
          <div class="panel panel-primary"> 
	         <div class="panel-body">       
				  {{content()}}
			{% for post in posts %}
               <div class="row">
	              <div class="clearfix"></div>
	              <a href="/ikomuniti/ipartner/view/{{post.slug}}">
				  <div class="col-md-2 text-center">
				  {% if post.image != '' %}
				  	<img src="{{ipartner_thumb_dir ~ post.image}}" class="img-responsive img-thumbnail pull-center">
				  {% else %}
				    <img src="{{ipartner_thumb_dir}}no_photo.jpg" class="img-responsive img-thumbnail pull-center">
				  {% endif %}
				  </div>
	              <div class="col-md-7 text-left">
				  <h4><b>{{ post.title|e }}</b></h4>
				  </div>
				  </a> 
				  <div class="col-md-3 text-left">
				   <i class="fa fa-clock-o"></i> {{ post.created }}<br/>
				   
				   <i class="fa fa-home"></i> {{post.category}}
				  </div> 
				  <div class="col-md-7 text-left"> 
				    <p>{{ post.body|e }}...</p>
					<i class="fa fa-tags"></i> Discount {{ post.discount|e }}<br/>
				  </div>
				  <div class="col-md-2 text-left">
				     <p>&nbsp;</p>
				  </div>
				  <div class="col-md-7 text-left" style="margin-top: 10px;">
				     
				  </div> 
				  <div class="col-md-3 text-left" style="margin-top: 10px;">
				    
				  </div> 
				   
				  <div class="clearfix"></div>
	               
	              <hr>
              </div>
              {% elsefor %}
              <div class="col-lg-12">
    <div class="alert alert-dismissable alert-danger">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <p>You have no post on iPartner yet.</p>
    </div>
  </div>
              {% endfor %} 
              </div>
        </div>
    </div>
</div> 
{{ partial("partials/footer") }}