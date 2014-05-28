{% if is_login == 1 %}
    {{ partial("partials/profile_nav_protect") }}
{% else %}
    {{ partial("partials/profile_nav_public") }}
{% endif %}

{% for profile in profiles %} 
<div class="row"> 
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="cover">  
			<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 profile_image">
				<img class="img-responsive img-thumbnail pull-center" src="{{ profile_path ~ profile.profile_image }}" alt="{{profile.username|e}}" title="{{profile.username|e}}"/>
			</div>
    		<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 profile_name">
	        <h4>{% if has_profile == 1 %}{{profile.display_name|e}}{%else%}{{profile.username|e}}{%endif %}</h4>
	        <p><i class="fa fa-clock-o"></i> Join since {{ profile.created }}</p>
	        {% if is_login == 1 %}
				{% if my_username != profile.username|e %}
				    {{ link_to('messages/index?ref='~profile.username|e, '<i class="fa fa-envelope-o"></i> Send Message', 'class': 'btn btn-default')}}
				{% endif %}
	        {% endif %}
	         
    		</div>	
    		<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 profile_image">
			   <h3 class="pull-center"> 
				"{% if has_profile == 1 %}
				  {{profile.quote|e}}{%else%}Lets join iShare socialpreneur program and get free Roadtax and Insurance every year!.
				{%endif %}"            
				</h3>
			</div>
		</div>
    </div> 
</div><!-- end row --> 
<div class="row"> 
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="profile-nav">  
            
		</div>
    </div> 
</div><!-- end row --> 

<div class="row">
    {{ content() }}
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 profile-left">
		<div class="panel-profile left-panel">
            <div class="profile-header">
              <h4><i class="fa fa-tags"></i> Info</h4>
            </div>
		    <div class="panel-body">
		    {% if has_profile == 1 %}
				<p><i class="fa fa-suitcase"></i> <span>{{profile.job}}</span> at <span>{{profile.company|e}}</span></p><hr> 
				<p><i class="fa fa-home"></i> Live in <span>{{profile.location|e}}</span></p><hr>
				<p><i class="fa fa-map-marker"></i> From <span>{{profile.hometown|e}}</span></p><hr>
				<p><i class="fa fa-certificate"></i> Went to <span>{{profile.school|e}}</span></p><hr>
				{% if profile.college != '' %}<p><i class="fa fa-flask"></i> High Education <span>{{profile.college|e}}</span></p><hr>{% endif%}
				<p><i class="fa fa-gift"></i> Born on <span>{{profile.dob}}</span></p><hr>
				{% if profile.website != '' %}<p><i class="fa fa-desktop"></i> Website <span><a href="http://{{profile.website}}" target="_blank">{{profile.website}}</a></span></p>{% endif%} 
		    {%else%}	
			    <p><i class="fa fa-times"></i> <span>{{profile.username|e}}</span> has nothing to share</p>	
			{%endif%}
			</div>
         </div> 
         
         <div class="panel-profile left-panel">
            <div class="profile-header">
              <h4><i class="fa fa-shopping-cart"></i> {% if has_profile == 1 %}{{profile.display_name|e}}{%else%}{{profile.username|e}}{%endif %} iMall</h4>
            </div>
		    <div class="panel-body ads"> 
		      {% for ad in ads %}
		        {% if ad.image != '' %}
	                <li class="col-md-6 col-lg-6 col-xs-12">
					    <img class="img-responsive" src="{{ thumb_dir ~ ad.image }}" alt="{{ad.title|e}}" title="{{ad.title|e}}"/>
					</li>
	            {% else %}
	                <li class="col-md-6 col-lg-6 col-xs-12">
					    <img class="img-responsive" src="{{ thumb_dir }}no_photo.jpg" alt="{{ad.title|e}}" title="{{ad.title|e}}"/>
					</li>
	            {% endif %} 
		      {% elsefor %} 
		          <p><i class="fa fa-times"></i> <span>
				  {% if has_profile == 1 %}
				    {{profile.display_name|e}}
				  {%else%}
				    {{profile.username|e}}
				  {%endif %}
				  </span> has no ads</p>
		      {% endfor %}
			</div>
         </div> 
         
    </div>
    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
	    <div class="panel-profile">
            
		    <div class="panel-body"> 
                
                {% for wall in walls %} 
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 wall">
                   <p>{% if profile.profile_image != '' %}
	                    <img class="img-responsive pull-left" src="{{ profile_path ~ profile.profile_image }}" width="50px"/> 
	            	{% else %} 
					    <img class="img-responsive pull-left" src="{{ profile_path }}nophoto.jpg"  width="50px"/> 
					{% endif %}
					<span>{% if has_profile == 1 %}{{profile.display_name|e}}{%else%}{{profile.username|e}}{%endif %}</span> 
					<i class="fa fa-clock-o"></i> On {{wall.created}}<br/>
					{% if wall.type == 6 %} 
					  Has receive renewal commission.
					{% elseif wall.type == 1 %}
					  Has renew insurance and roadtax with iShare.
					{% endif %}
					</p>
				</div>
				<div class="clearfix"></div>
				<hr>
	            {% endfor %} 
            </div>
        </div> 
    </div>  
    
    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
	    <div class="panel-profile"> 
	        <div class="profile-header">
                <h4><i class="fa fa-bullhorn"></i> Sponsor Ads</h4>
            </div>
		    <div class="panel-body"> 
                <!-- nuffnang -->
<script type="text/javascript">
        nuffnang_bid = "f20bae427dae947f35ce14e4f2dbfc72";
        document.write( "<div id='nuffnang_ss'></div>" );
        (function() {	
                var nn = document.createElement('script'); nn.type = 'text/javascript';    
                nn.src = 'http://synad2.nuffnang.com.my/ss.js';    
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(nn, s.nextSibling);
        })();
</script>
<!-- nuffnang-->
                        
            </div>
        </div> 
    </div> 
</div>
 
 
{% endfor %} 
{{ partial("partials/footer_profile") }}