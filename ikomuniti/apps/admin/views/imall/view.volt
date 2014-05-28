<script>
$("document").ready(function() {
	$("ul.jun_thumbnails li").click(function () {
		$("#jun_images").load('{{urlajax}}', {'id': $(this).attr('id')});
		$("ul.jun_thumbnails li").removeClass('jun_highlight');
		$(this).addClass('jun_highlight');
	});
});
</script>
 

{{ partial("partials/navigation") }} 
<div class="row">
	<div class="col-lg-12">  
  		<div class="panel-body">
		    {{ link_to('gghadmin/imall/index', 'Active Ads', 'class': 'btn btn-success') }} 
			{{ link_to('gghadmin/imall/pending', 'Pending Ads', 'class': 'btn btn-danger') }}
	    </div>
	</div>
</div>
{% for post in posts %}     
<div class="row">
  <div class="col-lg-8">
          <div class="panel panel-primary"> 
	        <div class="panel-body">   
			  {{ content() }} 
			 
				<div class="row">
				  <div class="col-xs-12">     
					<h3>{{ link_to('imall/view/' ~ post.title, post.title) }}</h3>
				  </div>	
				</div>
				<div class="row"> 
					<div class="col-xs-12">
						<div class="col-md-4 text-left">
						 <i class="fa fa-clock-o"></i> {{ post.created }}
						</div>
						<div class="col-md-4 text-left">
						  <p>Price RM<b>{{ post.price }}</b></p>
						</div>
						<div class="col-md-4 text-left">
						 <i class="fa fa-gear"></i>  Ad Status: 
							{% if post.status == 1 %} 
							    <span class="yellow"><b>Pending</b></span> 
							{% elseif post.status == 0 %} 
								<span class="yellow"><b>Not Complete</b></span> 
							{% elseif post.status == 2 %}
								<span class="green"><b>Active</b></span> 
							{% elseif post.status == 3 %}  
								<span class="red"><b>Reject</b></span> 
							{% endif %}  
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
					{% if post.image != '' %}
					    <div id="jun_images" class="col-lg-8">
						{{ image('uploads/imall/images/'~post.image, 'title': post.title, 'alt': post.title, 'data-src': 'holder.js/500x500/auto', 
						'class': 'img-responsive')}}</div>
					 
						
					{% endif %}
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
				    {% if thumbnail == 1 %} 
					    <div class="thumbImage"><ul class="jun_thumbnails thumbnails">
				        {% for thumb in thumbs %}
				             
					        <li id="{{ thumb.image_name }}" class="span4">
							<img class="img-thumbnail" src="{{ thumb_image_dir ~ thumb.image_name }}"/></li>
				             
					    {% endfor %}
						</ul></div>
					{% endif %}
					</div>
				</div>
				
				<div class="row imall_item_info">
					<div class="col-md-4">
						 <i class="fa fa-user"></i> iKomuniti: {{post.username}}    
					</div>
					<div class="col-md-4">
						 <i class="fa fa-phone-square"></i> Phone: {{post.telephone}}      
					</div>
					<div class="col-md-4">
						 <i class="fa fa-archive"></i> Available Stock: {{post.stock}}      
					</div>
					<div class="col-md-4">
						 <i class="fa fa-tag"></i> Price: RM{{post.price}}      
					</div>
					<div class="col-md-4">
						 <i class="fa fa-thumb-tack"></i> Location: {{post.location}}      
					</div>
					<div class="col-md-4">
						 <i class="fa fa-cog"></i> Condition: {{post.condition}}      
					</div>
				</div>
				
				<div class="row">
					<div class="col-xs-12">
						<div class="span4 jun_post_body"> 
						    <pre>{{ post.description }}</pre> 
						</div>     
					</div>
				</div>
		     </div>  
        </div>	  
    </div>
	<div class="col-lg-4">
      <div class="panel panel-primary"> 
        <div class="panel-body"> 
            <h4>Rules</h4>
		    <p>Pure Marketing ads are not allowed.</p><hr>
		    <p>The ad should be placed in the category that best describes what is being advertised</p><hr>
		    <p>No multiple items in 1 ad</p><hr>
		    <p>Rules concerning pets and animals</p> <hr>
			<p>No duplicate ads</p> <hr>
			<p>Pirated goods and forged items, including fake "luxury" bags, "branded" clothes and gears, CD/VCD/DVD, computer/game-console software, are not allowed. All items advertised must be original; we suggest that you include the necessary document(s) in the ad to certify the authenticity of the item. </p><hr>
			<p>Services offered or wanted must follow applicable laws and regulations of Malaysia for the given profession. Services should always be placed in the services category.</p><hr>
			
			<h4>Administrator Action</h4>
			<form action="" method="post">
			<div class="form-group">
			  <label>Action</label>
			  <select name="action" class="form-control">
			    <option value="0">Select</option>
			    <option value="2">Activate</option>
			    <option value="3">Reject</option>
			  </select>
			</div>
			<div class="form-group">
			  <label>Reason</label>
			  <select name="reason_list" class="form-control">
			    <option value="0">Select</option>
			    <option value="Pure Marketing ads are not allowed">Pure Marketing</option>
			    <option value="Image not clear">Image not clear</option>
			    <option value="Duplicate ad">Duplicate ad</option>
			    <option value="Pirated goods and forged items">Pirated goods</option>
			    <option value="Rules concerning pets and animals">Rules concerning pets and animals</option>
			    <option value="Multiple items in 1 ad">Multiple items in 1 ad</option>
			    <option value="We do not accept any ads related to auction or bidding">Bidding and auction</option>
			    <option value="Ads featuring goods that are prohibited from sale according to Malaysian laws are not allowed">Illegal goods</option>
			    <option value="1">Other</option>
			  </select>
			</div>
			<div class="form-group">
			  <label>Reason (If Other)</label>
			  <textarea name="reason" class="form-control"></textarea>
			  <input type="hidden" name="user_id" value="{{post.user_id}}">
			</div>
			<div class="form-group">
			  <input type="submit" name="submit" value="Submit" class="btn btn-primary">
			</div>
			</form>
		</div>
	  </div>
	</div>
	
</div>


{% endfor %}			 
{{ partial("partials/footer") }}