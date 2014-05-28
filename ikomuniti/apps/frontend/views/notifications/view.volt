{{ partial("partials/navigation") }}
<div class="row">         
 
  <div class="col-lg-12">
    <div class="bs-example wgreen">
      <div class="list-group">
        <a href="/ikomuniti/notifications/index" class="list-group-item active">
          <i class="fa fa-warning"></i> Notifications
        </a>
        {% for notification in notifications %}
        <a href="/ikomuniti/notifications/view/{{ notification.id }}" class="list-group-item"> 
		<p class="list-group-item-text">{{ notification.body }}</p>
		<span class="fa fa-time"></span> On {{ notification.created }}
		</a> 
        {% endfor %}
        <a href="/ikomuniti/notifications/index" class="list-group-item"> Back 
              <i class="fa fa-arrow-circle-right"></i> 
      </a>
      </div>
    </div> 
  </div>
  
</div> 
{{ partial("partials/footer") }}