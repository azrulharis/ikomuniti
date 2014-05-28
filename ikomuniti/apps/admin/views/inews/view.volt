{{ partial("partials/navigation") }} 

<div class="row">
	<div class="col-lg-8"> 
		{{ content()}}
		{% for inews in news %} 
		<div class="panel panel-success">
			<div class="panel-heading">
			<h3 class="panel-title">iNews -> {{ inews.title }}</h3>
			</div>
			<div class="panel-body">
			
			<h3>{{ inews.title }}</h3>
			 
			<p>
			<span class="fa fa-clock-o"></span> Posted on {{ inews.created }}</p>
			<hr>
			<div class="jun_post_body">
			    <pre>{{ inews.body }}</pre> 
		    </div>
			</div>
		</div>
		{% endfor %}  
	</div>
 
	<div class="col-lg-4"> 
		 <div class="bs-example wgreen">
          <div class="list-group">
            <a href="/ikomuniti/gghadmin/inews/index" class="list-group-item active">
              <i class="glyphicon glyphicon-info-sign"></i>  iNews
            </a>
            {% for news in right_news %}
            <a href="/ikomuniti/gghadmin/inews/view/{{ news.slug }}" class="list-group-item"><h4>{{ news.title }}</h4>
			<p class="list-group-item-text">{{ news.body }}...</p>
			</a> 
            {% endfor %}
            <a href="/ikomuniti/gghadmin/inews/index" class="list-group-item"> View All 
                  <i class="fa fa-arrow-circle-right"></i> 
          </a>
          </div>
        </div> 
	</div>
</div>
 
{{ partial("partials/footer") }}