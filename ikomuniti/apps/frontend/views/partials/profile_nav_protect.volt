{{ stylesheet_link("css/profile.css") }}
{% for nav in navigations %}
<div id="wrapper">
      <!-- Sidebar -->
      <nav class="navbar navbar-default navbar-fixed-top" role="navigation"> 
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          {{ link_to("index", image('images/logo.png'), "class": "navbar-brand") }}
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse jun_line">
        

          <ul class="nav navbar-nav navbar-right navbar-user">
            <li class="dropdown messages-dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> Messages {% if count_inbox > 0 %}<span class="badge badge-error">{{ count_inbox }}</span>{% endif %} <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li class="dropdown-header">{% if count_inbox > 0 %} {{ count_inbox }} New Messages {% endif %}</li>
                
                {%  for msg in messages_nav %} 
				<li class="message-preview">
	              <a href="{{ path }}messages/view/{% if msg.message_id == 0 %}{{ msg.m_id }}{% else %}{{ msg.message_id }}{% endif %}">
	                <span class="avatar"><img src="http://placehold.it/50x50"></span>
	                <span class="name">{{ msg.from_username|e }}:</span>
	                <span class="message">{{ msg.body|e }}...</span>
	                <span class="time"><i class="fa fa-clock-o"></i> {{ msg.time }} {{ msg.created }}</span>
	              </a>
	            </li>
	            <li class="divider"></li> 
			    {% endfor %}
			    
                <li>{{ link_to("messages/index", "View iMail <span class='badge'>"~ count_inbox ~ "</span>") }}</li>   
              </ul>
            </li>
            <li class="dropdown alerts-dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> Notification {% if count_notification > 0 %}<span class="badge badge-error">{{ count_notification }}</span>{% endif %} <b class="caret"></b></a>
              <ul class="dropdown-menu">
              {% for notificate in notifications_nav %} 
                <li>{{ link_to("notifications/view/"~notificate.id, "<span class='label label-info'>" ~ notificate.body|e ~ "</span>") }}</li> 
              {% endfor %}
                <li class="divider"></li>
                <li>{{ link_to("notifications/index", "View All") }}</li>
              </ul>
            </li>
            
            <li class="dropdown user-dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> {{ nav.username }} <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#"><i class="fa fa-user"></i> Profile</a></li> 
                <li class="divider"></li>
                <li>{{ link_to("users/logout", "<i class='fa fa-power-off'></i> Log Out") }}</li>
              </ul>
            </li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </nav>
{% endfor %}
 <div class="profile_container">
