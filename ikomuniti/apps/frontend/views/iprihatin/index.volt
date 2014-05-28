{{ partial("partials/navigation") }} 
<div class="row">
	<div class="col-md-12 col-sm-12">
    	<div class="panel panel-primary">
       		<a href="/ishare/isharephal/ioffer/index" class="list-group-item active">
            	<i class="glyphicon glyphicon-info-sign"></i>  iPrihatin
            </a>
   			<div class="panel-body">
   			    {{ content() }}
				 
			   {% for iprihatin in iprihatins %}
               <div class="row">
	              <div class="clearfix"></div>
	              <a href="/ikomuniti/iprihatin/view/{{iprihatin.slug}}">
				  <div class="col-md-2 text-center">
				  {% if iprihatin.image != '' %}
				  	<img src="{{iprihatin_thumb_dir ~ iprihatin.image}}" class="img-responsive img-thumbnail pull-center" width="120">
				  {% else %}
				  	<img src="{{iprihatin_thumb_dir}}no_photo.jpg" class="img-responsive img-thumbnail pull-center" width="120">
				  {% endif %}
				  </div>
	              <div class="col-md-6 text-left">
				  <h4>{{ iprihatin.title }}</h4>
				  </div>
				  </a>
				  <div class="col-md-1 text-left">
				  <h4></h4> 
				  </div>
				  <div class="col-md-3 text-left">
				  <h4><i class="fa fa-clock-o"></i> {{ iprihatin.created }}</h4> 
				  </div> 
				  <div class="col-md-7 text-left">
				    <p>{{ iprihatin.body }}...</p>
				  </div>
				  <div class="col-md-2 text-left">
				     <p>&nbsp;</p>
				  </div>
				  <div class="col-md-10 text-left">
				     
				  </div> 
				  
				   
				  <div class="clearfix"></div>
	               
	              <hr>
              </div>
              {% endfor %}
                <div class="row">
					{{ paginationUrl }}
				</div>
            </div> 
    	</div> 
	</div>
</div>
{{ partial("partials/footer") }}








