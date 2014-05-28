<script> 
$(function(){
    //insert record 
    $('#reply').click(function(){
        var js_token = $('#token').val();
        var js_message_id= $('#message_id').val();
        var js_message_to_id = $('#message_to_id').val();
        var js_message_from_id = $('#message_from_id').val();
        var js_message = $('#message').val(); 
        //syntax - $.post('filename', {data}, function(response){});
        $.post('{{ajaxreply}}',{
		    action: "reply", 
			    post_token:js_token, 
			    post_message_id:js_message_id, 
				post_message_to_id:js_message_to_id, 
				post_message_from_id:js_message_from_id, 
				post_message:js_message
		}, function(res) {
		    setTimeout("scrollFix();", 100);
		    $('#result').html(res);
			$("#message").val('');
        });        
    }); 
        
    //show records
    $('#show').click(function(){
        $.post('{{ajaxreply}}',{action: "show"},function(res){
            $('#result').html(res);
        });        
    });
}); 

function scrollFix() {   
  var objDiv = document.getElementById("inbox_scroller");
  objDiv.scrollTop = objDiv.scrollHeight; 
}
window.onload = function() { scrollFix(); }
</script> 
{{ partial("partials/navigation") }}
<div class="row">
    <div class="col-lg-8"> 
    	<div class="panel panel-primary">
           <div class="panel-heading">
		    <h3 class="panel-title">Conversation</h3>
		  </div>
   			<div class="panel-body">
              {{ image('glyphicons/png/glyphicons_122_message_in.png', 'class': 'img-circle pull-right') }} {{ link_to('messages/index', 'Inbox') }}
              <div class="clearfix"></div>
               {% for message in messages %} 
	              <div class="clearfix"></div>
	              <div id="inbox_scroller">
				  <p>
				  {{ link_to("profile/" ~ message.username, image('uploads/profiles/'~message.image, 'width': '60', 'class': 'img-responsive img-thumbnail pull-left', 'style': 'margin-right:5px;') ~ '<b>'~message.username~'</b>') }} 
				  {%if my_username == message.username %}
				      <span class="fa fa-share"></span> {{ link_to("profile/" ~ message.sender_username, message.sender_username) }} 
				  {% endif %}
	              <span class="fa fa-clock-o"></span> {{ message.created }} {{ message.time }}</p>
	              <pre>{{ message.body|e }}</pre>
	              <div class="clearfix"></div> 
              {% endfor %}
              
              {% for reply in replys %} 
	              <div class="clearfix"></div>
	              <p>{{ link_to("profile/" ~ reply.username, image('uploads/profiles/'~reply.image, 'width': '60', 'class': 'img-responsive img-thumbnail pull-left', 'style': 'margin-right:5px;') ~  '<b>'~reply.username~'</b>') }} 
	              <span class="fa fa-clock-o"></span>  {{ reply.created }} {{ reply.time }}</p> 
	              <pre>{{ reply.body|e }}</pre>
	              <div class="clearfix"></div> 
              {% endfor %}
                <div id="result"></div>
              </div>
              <div class="form-group" style="padding-left:48px;"> 
                <input type="hidden" name="token" value="{{ token }}" id="token">
                <input type="hidden" name="id" value="{{ message.m_id }}" id="message_id">
                <input type="hidden" name="to_user_id" value="{% if message.from_id == my_id %}{{ message.to_id }}{% else %}{{ message.from_id }}{% endif %}" id="message_to_id">
                <input type="hidden" name="from_user_id" value="{{ my_id }}" id="message_from_id">
				<textarea  class="form-control" name="reply" placeholder="Type your message..." id="message"></textarea>
				<input type="submit" name="reply" value="Reply" class="btn btn-primary" id="reply"> 
			  </div>
            </div> 
        </div>
	 
    </div>

    <div class="col-lg-4 col-sm-6">
    	<div class="panel panel-primary">
           <div class="panel-heading">
		    <h3 class="panel-title">iMail Inbox</h3>
		  </div>
   			<div class="panel-body">
              {{ image('glyphicons/png/glyphicons_122_message_in.png', 'class': 'img-circle pull-right') }} {{ link_to('messages/index', 'Inbox') }}
              <div class="clearfix"></div>
               {% for inbox in inboxs %}
              <hr>
              <div {% if user_id == inbox.to_id %}{% if inbox.is_read == 0 %}class="warning"{% endif %}{% endif %}{% if inbox.m_id == param %}style="background: #D5E0EA"{%endif%}>
	              <div class="clearfix"></div>
	              <p>{% if user_id != inbox.to_id %}
				  {{ link_to("profile/" ~ inbox.to_username, image('uploads/profiles/'~inbox.to_image, 'class': 'img-responsive img-thumbnail pull-left', 'style': 'margin-right:5px; width: 60px;') ~ '<b>'~inbox.to_username~'</b>') }} 
				  {% else %}
				  {{ link_to("profile/" ~ inbox.username, image('uploads/profiles/'~inbox.image, 'class': 'img-responsive img-thumbnail pull-left', 'style': 'margin-right:5px; width: 60px;') ~ '<b>'~inbox.username~'</b>') }}
				  {% endif %} 
	              <span class="glyphicon glyphicon-time"></span> {{ inbox.created ~ inbox.time }}</p> 
	              <p>{{ link_to('messages/view/'~inbox.m_id, inbox.body) }}... </p>
	              <div class="clearfix"></div>
              </div>
              {% endfor %}
            </div> 
        </div> 
    </div> 
    
</div>
{{ partial("partials/footer") }}