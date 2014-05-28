{{ partial("partials/navigation") }} 
<div class="row">
	<div class="col-lg-12">  
  		<div class="panel-body">
		    {{ link_to('gghadmin/ipartner/index', 'Active Ads', 'class': 'btn btn-success') }} 
			{{ link_to('gghadmin/ipartner/pending', 'Pending Ads', 'class': 'btn btn-danger') }}
	    </div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">  
	  <div class="panel panel-primary"> 
  		<div class="panel-body">  
  		     {{ content() }}
		     {% for post in posts %}
               <div class="row">
	              <div class="clearfix"></div>
	              <a href="{{admin_path}}ipartner/view/{{post.url}}?id={{post.id}}">
				  <div class="col-md-2 text-center">
				  {% if post.image != '' %}
				    {{ image('uploads/ipartners/images/'~post.image, 'title': post.title|e, 'alt': post.title|e, 'data-src': 'holder.js/500x500/auto', 'width':140)}} 
				  {% else %}
				    {{ image('uploads/ipartners/images/no_photo.jpg', 'title': post.title|e, 'alt': post.title|e, 'data-src': 'holder.js/500x500/auto', 'width':140)}} 
				  {% endif %}
				  </div>
	              <div class="col-md-6 text-left">
				  <h4><b>{{ post.title|e }}</b></h4>
				  </div>
				  </a>
				  <div class="col-md-1 text-left">
				  <h4></h4> 
				  </div>
				  <div class="col-md-3 text-left">
				  <h4><i class="fa fa-clock-o"></i> {{ post.created }}</h4> 
				  </div> 
				  <div class="col-md-7 text-left">
				    <p>{{ post.description|e }}...</p>
				  </div>
				  <div class="col-md-2 text-left">
				     <p>&nbsp;</p>
				  </div>
				  <div class="col-md-4 text-left" style="margin-top: 10px;">
				    <i class="fa fa-bookmark"></i> {{post.category}}
				  </div> 
				  <div class="col-md-3 text-left" style="margin-top: 10px;">
				    <i class="fa fa-user"></i> {{post.username}}
				  </div> 
				  <div class="col-md-3 text-left" style="margin-top: 10px;">
				    {% if post.discount != 0 %}<i class="fa fa-star"></i> <b>{{post.discount|e}}</b>{% endif %}
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