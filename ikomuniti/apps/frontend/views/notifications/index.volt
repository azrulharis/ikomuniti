{{ partial("partials/navigation") }}
<div class="row">         
 
  <div class="col-lg-12">
    <div class="bs-example wgreen">
      <div class="list-group">
        <a href="/ikomuniti/notifications/index" class="list-group-item active">
          <i class="glyphicon glyphicon-info-sign"></i> Notifications
        </a>
        {% for notification in notifications %}
        <a href="/ikomuniti/notifications/view/{{ notification.id }}" class="list-group-item"> 
		<p class="list-group-item-text">{{ notification.body }}...</p>
		<span class="glyphicon glyphicon-time"></span> On {{ notification.created }}
		</a> 
        {% endfor %}
        <a href="/ikomuniti/notifications/index" class="list-group-item"> View All 
              <i class="fa fa-arrow-circle-right"></i> 
      </a>
      </div>
    </div> 
  </div>
  
</div> 
{{ partial("partials/footer") }}