<script>
$("document").ready(function() {
	$("ul.jun_thumbnails li").click(function () {
		$("#jun_images").load('{{urlajax}}', {'id': $(this).attr('id')});
		$("ul.jun_thumbnails li").removeClass('jun_highlight');
		$(this).addClass('jun_highlight');
	});
});
 
</script>
  
{% for post in posts %}    
<div class="container spacer_80">  
<div class="row">
        <div class="col-lg-8">
          <div class="panel panel-default">
             
	        <div class="panel-body imall_table"> 
			<div class="bs-example">
			  <ul class="breadcrumb" style="margin-bottom: 5px;">
			    <li>{{ link_to("ioffer", "iOffer") }}</li> 
			  </ul>
			</div>  
	    
		<div class="big_box jun_label">	 
			  {{ content() }} 
			 
				<div class="row">
				  <div class="col-xs-12">     
					<h3>{{ link_to('ioffer/view/' ~ post.slug, post.title|e) }}</h3>
				  </div>	
				</div>
				<div class="row"> 
					<div class="col-xs-12">
						<div class="col-md-4 text-left">
						 <i class="fa fa-clock-o"></i> {{ post.created }}
						</div>
						<div class="col-md-4 text-left">
						  <p><i class="fa fa-tag"></i> <span style="color: #FF0000; text-decoration:line-through">{{ post.market_price|e }}</span> RM<b>{{ post.price|e }}</b></p>
						</div>
						<div class="col-md-4 text-left">
						 <i class="fa fa-bars"></i> Available Stock {{ post.stock }}
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
					{% if post.image != '' %}
					    <div id="jun_images" class="col-lg-8">
						<img src="{{image_dir~post.image}}" title="{{post.title|e}}" alt="{{post.title|e}}" data-src="holder.js/500x500/auto" class="img-responsive">
						</div>
					{% endif %}
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
				    {% if thumbnail == 1 %} 
					    <div class="thumbImage"><ul class="jun_thumbnails thumbnails">
				        {% for thumb in thumbs %}
				             
					        <li id="{{ thumb.image_name }}" class="span4">
							<img class="img-thumbnail" src="{{ ioffer_thumb_dir ~ thumb.image_name }}"/></li>
				             
					    {% endfor %}
						</ul></div>
					{% endif %}
					</div>
				</div>
				
				<div class="row">
					<div class="col-xs-12">
						<div class="span4 jun_post_body"> 
						    <pre>{{ post.body|e }}</pre>
						 
						</div>     
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						 <div id="fb-root"></div>
							<script>(function(d, s, id) {
							  var js, fjs = d.getElementsByTagName(s)[0];
							  if (d.getElementById(id)) return;
							  js = d.createElement(s); js.id = id;
							  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=473945646001405&version=v2.0";
							  fjs.parentNode.insertBefore(js, fjs);
							}(document, 'script', 'facebook-jssdk'));</script>   
							
							<div class="fb-share-button" data-href="{{web_host }}ioffer/view/{{post.slug}}" data-type="button_count"></div> 
					</div>
				</div>
		       
        </div>	
	</div> 
    </div>
    

  
  </div>
  <div class="col-lg-4">
      <div class="panel panel-default">
          
        <div class="panel-body">
	       <p><i class="fa fa-tag"></i> Price <span class="pull-right" style="color: #FF0000; text-decoration:line-through">{{ post.market_price }}</span> <b>RM{{ post.price }}</b></p>      
		   <p><i class="fa fa-bars"></i> Available Stock <span class="pull-right">{{ post.stock }}</span></p>	     
		   <p><i class="fa fa-clock-o"></i> Created <span class="pull-right">{{ post.created }}</span></p>	
		   <hr>
		   <div class="text-center">
		   <a href="https://ishare.com.my/ikomuniti/ioffer/view/{{post.slug}}" class="btn btn-success"><i class="fa fa-shopping-cart"></i> Add To Cart</a> 
		   <a href="http://ishare.com.my/pages/register" class="btn btn-primary"><i class="fa fa-edit"></i> Daftar iKomuniti</a> 
		   </div> 
		   <div class="clearfix"></div>
		   <div id="jun_images" style="margin-top: 20px;">
		   {{ image('images/localbank.jpg', 'class': 'img-responsive')}}
		   {{ image('images/poslaju.jpg', 'class': 'img-responsive')}}
		   </div>
		   
		      
		</div>
	  </div>
	  
	</div>
</div>
</div>
{% endfor %} 
 