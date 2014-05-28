

{{ partial("partials/navigation") }}
<div class="row">
    <div class="col-lg-8"> 
        {{ content()}}
    	<div class="panel panel-primary">
           <div class="panel-heading">iPrihatin</div>
   			<div class="panel-body">
   			
			      {{ link_to("gghadmin/iprihatin/index", "iPrihatin", "class": "jun_button") }}
				  {{ link_to("gghadmin/iprihatin/add", "New Post", "class": "jun_button") }}
				  {% for iprihatin in iprihatins %}
				  
				  
				    <div class="jun_view_iprihatin">
				    
				    {{ content()}}
					    
				        <h4>{{link_to("gghadmin/iprihatin/view/" ~ iprihatin.slug, iprihatin.title)}}</h4>
				        {% if not (iprihatin.image is empty) %}
						    {{ image("uploads/iprihatins/" ~ iprihatin.image, 'class': 'img-responsive imall_image') }} 
						{% endif %}
						   
				        <p>Tarikh {{iprihatin.created}}</p><p>Jumlah Sumbangan <b>RM{{iprihatin.amount}}</b></p>
				        {{ content() }}
				        <form action="" method="POST">
						  <div class="form-group">
					        <textarea name="body" class="form-control" >{{iprihatin.body}}</textarea>
						  </div>
						  <div class="form-group">
						      <input type="submit" name="submit" value="Save" class="btn btn-primary">  
						  </div>
						</form>
					         
					{% endfor %}
            </div> 
        </div> 
    </div>
	</div>
	<div class="col-lg-4"> 
		 <div class="bs-example wgreen">
          <div class="list-group">
            <a href="/ishare/isharephal/iprihatin/index" class="list-group-item active">
              <i class="glyphicon glyphicon-info-sign"></i>  iPrihatin
            </a>
            {% for right in rights %}
            <a href="/ishare/isharephal/gghadmin/iprihatin/view/{{ right.slug }}" class="list-group-item"><h4>{{ right.title }}</h4> 
			<p class="list-group-item-text">{{ right.body }}...</p>
			</a> 
            {% endfor %}
            <a href="/ishare/isharephal/gghadmin/iprihatin/index" class="list-group-item"> View All 
                  <i class="fa fa-arrow-circle-right"></i> 
          </a>
          </div>
        </div> 
	</div> 
</div>
{{ partial("partials/footer") }}