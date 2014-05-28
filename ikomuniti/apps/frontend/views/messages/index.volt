{{ partial("partials/navigation") }}
<div class="row">
    <div class="col-lg-12">
        {{ content() }}
    </div>
</div>
<div class="row">
   <div class="col-lg-6">  
    	<div class="panel panel-primary">
          <div class="panel-heading">
		    <h3 class="panel-title">iMail Inbox</h3>
		  </div>
		  <div class="panel-body">
              {{ image('glyphicons/png/glyphicons_122_message_in.png', 'class': 'img-circle pull-right') }} {{ link_to('messages/index', 'Inbox') }}
              <div class="clearfix"></div>
               {% for message in messages %}
              <hr>
              <div {% if user_id == message.to_id %}{% if message.is_read == 0 %}class="panel panel-warning" style="background: #F3E2EA"{% endif %}{% endif %}>
	              <div class="clearfix"></div>
	              <p>
				  {% if user_id != message.to_id %}
				  {{ link_to("profile/" ~ message.to_username, image('uploads/profiles/'~message.to_image, 'class': 'img-responsive img-thumbnail pull-left', 'style': 'margin-right:5px; width: 60px;') ~ '<b>'~message.to_username~'</b>') }} 
				  {% else %}
				  {{ link_to("profile/" ~ message.username, image('uploads/profiles/'~message.image, 'class': 'img-responsive img-thumbnail pull-left', 'style': 'margin-right:5px; width: 60px;') ~ '<b>'~message.username~'</b>') }}
				  {% endif %}
	              <span class="fa fa-clock-o"></span> {{ message.created ~ ' ' ~ message.time }}</p> 
	              {% if message.message_id == 0 %}
				      <p>{{ link_to('messages/view/'~message.m_id, message.body) }}... </p>
				  {% else %}
				      <p>{{ link_to('messages/view/'~message.message_id, message.body) }}... </p>
				  {% endif %}
	              <div class="clearfix"></div>
              </div>
              {% endfor %}
            </div>
            
        </div> 
    </div>    
	
	
	<div class="col-lg-6">
          
      <div class="panel panel-primary">
          <div class="panel-heading">
		    <h3 class="panel-title">Compose iMail</h3>
		  </div>
		  <div class="panel-body">    
		     
            
            <div class="panel panel-default">
              <div class="panel-body"> 
                
            <div class="form-group">
			{{ form('messages/index', 'method': 'post') }} 
				<div class="form-group">
				<label>iKomuniti Username</label>
					<input type="text" name="username" class="form-control" value="{{ref_username}}">
				</div>
				<div class="form-group"> 
				<label>Message</label>
				    <textarea name="message" class="form-control"></textarea>
				</div>	
				 
				<div class="form-group">
				    {{ submit_button('submit', 'value': 'Send', 'class': 'btn btn-primary') }}
				 </div>
		           </form>
		         </div>
              </div>
            </div>
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