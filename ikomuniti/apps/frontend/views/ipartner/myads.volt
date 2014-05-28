{{ partial("partials/navigation") }} 
    <div class="row">
        <div class="col-lg-12">
          <div class="panel panel-primary">
            <div class="panel-heading">
		     <h3 class="panel-title">My iPartner Ads</h3>
		    </div>
	        <div class="panel-body">
			    <div class="bs-example">
                   <ul class="breadcrumb" style="margin-bottom: 5px;">
				      <li>{{ link_to("ipartner/index", "iPartner") }}</li> 
				      <li>{{ link_to("ipartner/myads", "My Ads") }}</li>
					  <li>{{ link_to("ipartner/add", "New Ad") }}</li>
				  </ul>
				</div>
	              
				  {{content()}}
			{% for post in posts %}
               <div class="row">
	              <div class="clearfix"></div>
	              <a href="/ishare/isharephal/ipartner/view/{{post.slug}}">
				  <div class="col-md-2 text-center">
				  {% if post.image != '' %}
				  	<img src="{{ipartner_thumb_dir ~ post.image}}" class="img-responsive img-thumbnail pull-center">
				  {% else %}
				    <img src="{{ipartner_thumb_dir}}no_photo.jpg" class="img-responsive img-thumbnail pull-center">
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
				    <i class="glyphicon glyphicon-star"></i> Discount <b>{{ post.discount }}</b>
				  </div> 
				  <div class="col-md-3 text-left" style="margin-top: 10px;">
				    <i class="glyphicon glyphicon-th-large"></i> Category {{post.category}}
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