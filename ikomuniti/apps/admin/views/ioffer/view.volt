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
{% for post in posts %}     
<div class="row">
        <div class="col-lg-8">
          <div class="panel panel-primary">
            <div class="panel-heading">
		     <h3 class="panel-title">Add iOffer > Finish</h3>
		    </div>
	        <div class="panel-body imall_table"> 
			<div class="bs-example">
			  <ul class="breadcrumb" style="margin-bottom: 5px;">
			    <li>{{ link_to("gghadmin/ioffer/index", "iOffer") }}</li>
				<li class="active">Add iOffer > Finish</li>  
			    <li>{{ link_to("gghadmin/ioffer/order", "Orders") }}</li>
			    <li>{{ link_to("gghadmin/ioffer/histories", "Histories") }}</li> 
			  </ul>
			</div>  
	    {{ content() }}
		<div class="big_box jun_label">	 
			 
			 
				<div class="jun_top_ads">     
					<h3>{{ link_to('view/' ~ post.title, post.title) }}</h3>
					
				</div>
				<table>
				<tr><td>
				
				{% if post.image != '' %}
				    <div id="jun_images" class="col-lg-8">{{ image('uploads/ioffers/images/'~post.image, 'title': post.title, 'alt': post.title, 'data-src': 'holder.js/500x500/auto', 'class': 'img-responsive')}}</div>
				{% endif %}
				</td></tr>
				<tr><td>
			    {% if thumbnail == 1 %} 
				    <div class="thumbImage"><ul class="jun_thumbnails thumbnails">
			        {% for thumb in thumbs %}
			             
				        <li id="{{ thumb.image_name }}" class="span4">
						<img class="img-thumbnail" src="{{ ioffer_thumb_dir ~ thumb.image_name }}"/></li>
			             
				    {% endfor %}
					</ul></div>
				{% endif %}
				</td></tr>
				<tr><td>
				<div class="span4 jun_post_body"> 
				    <pre>{{ post.body }}</pre>
				 
				     
				</div>
				</td></tr>
				</table>
		        
        </div>	
	</div>
     
    </div>
  </div>
  <div class="col-lg-4">
      <div class="panel panel-primary">
        <div class="panel-heading">
	     <h3 class="panel-title">Purchase</h3>
	    </div>
        <div class="panel-body">
			
		</div>
	  </div>
	</div>
</div>
{% endfor %}

			 
{{ partial("partials/footer") }}