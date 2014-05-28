{{ partial("partials/navigation") }}
<div class="row">
    <div class="col-lg-8"> 
    	<div class="panel panel-primary">
           <div class="panel-heading">iPrihatin</div>
   			<div class="panel-body">
   			
			      {{ link_to("gghadmin/iprihatin/index", "iPrihatin", "class": "btn btn-primary") }}
				  {{ link_to("gghadmin/iprihatin/add", "New Post", "class": "btn btn-success") }}
				  {% for iprihatin in iprihatins %}
				  
				  
				    <div class="jun_view_iprihatin"> 
				    {{ content()}}
					    
				        <h4>{{link_to("gghadmin/iprihatin/view/" ~ iprihatin.slug, iprihatin.title)}}</h4>
				        {% if not (iprihatin.image is empty) %}
						    {{ image("uploads/iprihatins/" ~ iprihatin.image, 'class': 'img-responsive imall_image') }} 
						{% endif %}
						   
				        <p>Tarikh {{iprihatin.created}}</p><p>Jumlah Sumbangan <b>RM{{iprihatin.amount}}</b></p>
				        {{ link_to("gghadmin/iprihatin/edit/" ~  iprihatin.slug, "Edit This Post", "class": "btn btn-danger") }}
				        <pre>{{iprihatin.body}}</pre>
					         
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