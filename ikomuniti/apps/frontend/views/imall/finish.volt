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
		    {{ link_to('imall/index', '<i class="fa fa-plus"></i> My Ads', 'class': 'btn btn-primary') }}  
			{{ link_to('imall/add', '<i class="fa fa-plus"></i> Post On iMall', 'class': 'btn btn-success') }} 
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
						 <i class="glyphicon glyphicon-time"></i> {{ post.created }}
						</div>
						<div class="col-md-4 text-left">
						  <p>Price RM<b>{{ post.price }}</b></p>
						</div>
						<div class="col-md-4 text-left">
						 <i class="glyphicon glyphicon-th-large"></i>  Ad Status: Pending
							
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
					{% if post.image != '' %}
					    <div id="jun_images" class="col-lg-8 text-center">
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
 
   <div class="bs-example">
      <div class="list-group">
        <a href="#" class="list-group-item">
          <h4 class="list-group-item-heading">Description</h4>
          <p class="list-group-item-text">The ad heading has to describe the item or the service advertised, no company names or urls are allowed. No unnecessary characters are allowed in the heading. The item or service has to be described in the ad text, it is not allowed to merely link to another page. Ad texts are not allowed to be copied from other advertisers, these are protected under copyright laws. It&#39;s not allowed to use search words or keywords in the ad text. Only ads in Bahasa Malaysia and English are allowed.</p>
        </a>
        <a href="#" class="list-group-item">
          <h4 class="list-group-item-heading">Solely marketing</h4>
          <p class="list-group-item-text">It&#39;s only allowed to advertise sales, rentals, jobs and services. To use the ad for pure marketing purposes, i.e. not offering any concrete goods, jobs or services, is not allowed.</p>
        </a>
        <a href="#" class="list-group-item">
          <h4 class="list-group-item-heading">Categorising</h4>
          <p class="list-group-item-text">The ad has to be placed in the category that describes the item or service the best (the ad will be moved to the right category when possible). Good and services that do not fit in the same category must be placed in separate ads. For sale-ads have to placed under &#34;For sale&#34; and wanted-ads under "Wanted to buy". &#34;To let&#34; and "Wanted to rent" are available under certain categories. In other categories, to let-ads should be placed under "For Sale" and wanted to rent-ads under &#34;Wanted&#34;.</p>
        </a>
        <!--
        <a href="#" class="list-group-item">
          <h4 class="list-group-item-heading">No multiple items in 1 ad</h4>
          <p class="list-group-item-text">You are required to place only one property or vehicle per ad. We would therefore like to advise you to divide your properties or vehicles and place them in separate ads.</p>
        </a>
        <a href="#" class="list-group-item">
          <h4 class="list-group-item-heading">No duplicates</h4>
          <p class="list-group-item-text">It is not allowed to place ads with the same item, service or job more than once. Delete the old ad before you place the new one. Consequently, it&#39;s not allowed to place ads with the same items, services or jobs in different categories or regions.</p>
        </a>
        
        <a href="#" class="list-group-item">
          <h4 class="list-group-item-heading">Links</h4>
          <p class="list-group-item-text">Links in the ad have to be relevant to the item or service advertised. Same general rules for the ad applies also for the link. It is not allowed to link to another auction or classified site.</p>
        </a>
        
        <a href="#" class="list-group-item">
          <h4 class="list-group-item-heading">Images</h4>
          <p class="list-group-item-text">Images in the ad have to be relevant to the item or service advertised. Company logotypes are prohibited as images except for categories &#34;Services&#34;, &#34;Jobs&#34; and &#34;Businesses for Sale&#34;. It is not allowed to use images from other advertisers without consent. These are protected under copyright laws. Images showing models displaying underwear or bathing wear are not allowed.</p>
          <p class="list-group-item-text">Image content are not suitable such as:</p>
          <ol>
	          <li>Image too small.m</li>
	          <li>Image contain Watermark (with username, company name, email address, telephone number, link of logo)</li>
	          <li>Image not clear.</li>
	          <li>Not suitable image.</li>
	          <li>Image is not JPEG format.</li>
	          <li>Image was downloaded from Mudah.my website.</li>
	          <li>Image not clear.Image was reused from previous ad.</li> 
	        </ol>

        </a>
         -->
      </div>
    </div>

  </div>
</div>


{% endfor %}			 
{{ partial("partials/footer") }}