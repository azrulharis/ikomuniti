{{ content() }}
{% if success == 1 %}
{% for reply in replys %} 
  <div class="clearfix"></div>
  <p>{{ link_to("profile/" ~ reply.username, image('uploads/profiles/'~reply.image, 'class': 'img-responsive img-thumbnail pull-left', 'style': 'margin-right:5px;') ~  '<b>'~reply.username~'</b>') }} 
  <span class="glyphicon glyphicon-time"></span>  {{ reply.created }} {{ reply.time }}</p> 
  <pre>{{ reply.body|e }}</pre>
  <div class="clearfix"></div> 
{% endfor %}
{% endif %}