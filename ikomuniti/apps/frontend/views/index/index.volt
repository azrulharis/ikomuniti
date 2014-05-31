<script>
setInterval(function(){
        $("#blink").toggleClass("backgroundRed");
     },160)
</script>
<style>
.backgroundRed {
	color: #E03636;
}
</style>
{{ partial("partials/navigation") }}
{% for info in informations %}
  {% for user in users %}
<div class="row" style="margin-bottom: 10px;">
{% if my_profile == 0 %}
  <div class="col-lg-12">
    <div class="alert alert-dismissable alert-danger">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <p>You have not completed your profile information yet, please fill your information by clicking <b>{{ link_to('settings/profile', 'here')}}</b>.</p>
    </div>
  </div>
{% endif %}
  <div class="col-lg-4 col-xs-12">
    <h3><i class="fa fa-trophy"></i> Achievement: {{event}}</h3>
  </div>
  <div class="col-lg-4 col-xs-12"> 
	<h4 style="padding-top: 14px;">Status: 
	  {% if user.role == 3 %} iSahabat 
	  {% elseif user.role == 4 %} iKomuniti
	  {% elseif user.role == 5 %} iReseller
	  {% elseif user.role == 6 %} iCreator
	  {% elseif user.role == 7 %} iAccount 
	  {% elseif user.role == 8 %} iManager
	  {% elseif user.role == 9 %} iDeveloper
	  {% endif %}
	</h4> 
  </div>
   
  <div class="col-lg-4 pull-right text-right">
{% if user.role >= 1 %}    
{{ link_to('itakaful/index', '<button type="button" class="btn btn-primary btn-lg right-button">
  <i class="fa fa-umbrella"></i> iTakaful
</button>')}}

{{ link_to('imall/add', '<button type="button" class="btn btn-success btn-lg right-button">
  <i class="fa fa-plus-circle"></i> Post On iMall
</button>')}}
{% endif %}
{% if user.role == 0 %}
{{ link_to('isahabat/index', '<button type="button" class="btn btn-primary btn-lg right-button">
  <i class="glyphicon glyphicon-new-window"></i> Compare
</button>')}}

{{ link_to('isahabat/upgrade', '<button type="button" class="btn btn-success btn-lg right-button">
  <i class="glyphicon glyphicon-new-window"></i> Upgrade To iKomuniti
</button>')}}
{% endif %}
  </div>
  <hr>
</div><!-- /.row -->
        
{% if user.role == 3 %} 
    {{ partial("partials/isahabat_dashboard_box") }}
{% else %}
    {{ partial("partials/ikomuniti_dashboard_box") }}
{% endif %}
        
        <div class="row">
          
          <div class="col-lg-4">
            <div class="bs-example">
              <div class="list-group">
                <a href="#" class="list-group-item active">
                  <i class="fa fa-wheelchair"></i> iPrihatin
                </a>
                {% for iprihatin in iprihatins %}
                <a href="/ikomuniti/iprihatin/view/{{ iprihatin.slug }}" class="list-group-item">{{ iprihatin.title }}
				<p class="list-group-item-text">{{ iprihatin.body }}... </p>
				<span class="fa fa-clock-o"></span> On {{ iprihatin.created }}
				</a> 
                {% endfor %}
                <a href="/ikomuniti/iprihatin/index" class="list-group-item"> View All 
                      <i class="fa fa-arrow-circle-right"></i> 
              </a>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="bs-example wgreen">
              <div class="list-group">
                <a href="/ikomuniti/news/index" class="list-group-item active">
                  <i class="fa fa-bullhorn"></i>  iNews
                </a>
                {% for inews in news %}
                <a href="/ikomuniti/news/view/{{ inews.slug }}" class="list-group-item">{{ inews.title }}
				<p class="list-group-item-text">{{ inews.body }}...</p>
				<span class="fa fa-clock-o"></span> {{ inews.created }}
				</a> 
                {% endfor %}
                <a href="/ikomuniti/news/index" class="list-group-item"> View All 
                      <i class="fa fa-arrow-circle-right"></i> 
              </a>
              </div>
            </div> 
          </div>
          <div class="col-md-4 col-sm-6">
    	<div class="panel panel-primary">
           <a href="/ikomuniti/ioffer/index" class="list-group-item active">
                  <i class="fa fa-tags"></i>  iOffer
                </a>
   			  <div class="panel-body">
              {% for offer in offers %}
              <div class="clearfix"></div>
              <div class="col-xs-4 text-center">
              {{ image('uploads/ioffers/thumbnails/'~offer.image, 'class': 'img-responsive img-thumbnail pull-center')}}
			  </div>
              <p style="margin-left: 3px;"><b>{{ link_to('ioffer/view/'~offer.slug, offer.title) }}...</b></p>
              <span class="fa fa-clock-o"></span> {{ offer.created }}
              <div class="clearfix"></div>
              <hr>
              {% endfor %}
              
            </div>
         </div> 
    </div><!--/articles-->
    </div>
    
        </div> 

 
        {% endfor %}
{% endfor %}
{{ partial("partials/footer") }}