{{ partial("partials/navigation") }}
<div class="row">
    <div class="col-lg-8"> 
    	<div class="panel panel-default">
           <div class="panel-heading"><h4>iMail</h4></div>
   			<div class="panel-body">
              {{ image('glyphicons/png/glyphicons_123_message_out.png', 'class': 'img-circle pull-right') }} {{ link_to('messages/sentitems', 'Outbox') }}
              <div class="clearfix"></div>
               {% for outbox in outboxs %}
              <hr>
              <div>
	              <div class="clearfix"></div>
	              <p>{{ link_to("profile/" ~ outbox.username, image('uploads/profiles/'~outbox.image, 'class': 'img-responsive img-thumbnail pull-left', 'style': 'margin-right:5px;') ~ outbox.username) }} 
	              <span class="glyphicon glyphicon-time"></span> {{ outbox.created ~ outbox.time }}</p> 
	              <p>{{ link_to('messages/view/'~outbox.id, outbox.body) }}... </p>
	              <div class="clearfix"></div>
              </div>
              {% endfor %}
            </div> 
        </div> 
    </div>

    <div class="col-lg-4 col-sm-6">
        <div class="panel panel-default">
           <div class="panel-heading"><h4>iMail</h4></div>
   			<div class="panel-body">
              {{ image('glyphicons/png/glyphicons_122_message_in.png', 'class': 'img-circle pull-right') }} {{ link_to('messages/index', 'Inbox') }}
              <div class="clearfix"></div>
               {% for message in messages %}
              <hr>
              <div {% if message.is_read == 0 %}class="warning"{% endif %}>
	              <div class="clearfix"></div>
	              <p>{{ link_to("profile/" ~ message.username, image('uploads/profiles/'~message.image, 'class': 'img-responsive img-thumbnail pull-left', 'style': 'margin-right:5px;') ~ message.username) }} 
	              <span class="glyphicon glyphicon-time"></span> {{ message.created ~ message.time }}</p> 
	              <p>{{ link_to('messages/view/'~message.id, message.body) }}... </p>
	              <div class="clearfix"></div>
              </div>
              {% endfor %}
            </div> 
        </div> 	
    </div>  
</div>
<div class="row">
    <div class="col-lg-8">  
	    {{ paginationUrl }} 
    </div>
</div>
{{ partial("partials/footer") }}