 <div class="container spacer_80">  
{% for post in posts %}     
<div class="row">
  <div class="col-lg-8">
          <div class="panel panel-default">
             
	        <div class="panel-body">   
			    
			  {{ content() }} 
			 
				<div class="row">
				  <div class="col-xs-12">     
					<h4>{{ link_to('ipartner/view/' ~ post.slug, post.title) }}</h4>
				  </div>	
				</div>
				<div class="row"> 
					<div class="col-xs-12">
						<div class="col-md-4 text-left">
						 <i class="fa fa-clock-o"></i> {{ post.created }}
						</div>
						<div class="col-md-4 text-left">
						  <i class="fa fa-tags"></i> Diskaun <b>{{ post.discount }} </b>
						</div>
						<div class="col-md-4 text-left">
						  
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
					{% if post.image != '' %}
					    <div id="jun_images" class="col-lg-8 text-center">
						<img src="{{image_dir~post.image}}" title="{{post.title|e}}" alt="{{post.title|e}}" data-src="holder.js/500x500/auto" class="img-responsive">
						</div> 
						
					{% endif %}
					</div>
				</div>
				 
				
				
				<div class="row">
					<div class="col-xs-12">
						<div class="span4 jun_post_body"> 
						    <pre>{{ post.description|e }}</pre> 
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
	<div class="col-lg-4">
      <div class="panel panel-default"> 
           <div class="panel-heading">
			  <h3 class="panel-title">iPartner Info</h3>
			</div>

        <div class="panel-body">   
				 <p><i class="fa fa-user"></i> iKomuniti <span class="pull-right">{{post.username}}</span></p><hr> 
				 <p><i class="fa fa-phone"></i> Phone <span class="pull-right">{{post.telephone}}</span></p><hr>   
				 <p><i class="fa fa-tag"></i> Discount <span class="pull-right">{{post.discount|e}}</span></p> <hr>    
				 <p><i class="fa fa-home"></i> <b>{{post.title|e}}</b></p>  
				 <i class="fa fa-map-marker"></i> {{post.address_one|e}} {{post.address_two|e}} {{post.postcode|e}} {{post.city|e}} {{post.region|e}} <hr>
			     <div class="text-center">
				   <a href="https://ishare.com.my/ikomuniti/ipartner/add" class="btn btn-success"><i class="fa fa-plus-square"></i> My iPartner</a> 
				   <a href="http://ishare.com.my/pages/register" class="btn btn-primary"><i class="fa fa-edit"></i> Daftar iKomuniti</a>
				   <hr>
				   <iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fishare.com.my&amp;width&amp;height=258&amp;colorscheme=light&amp;show_faces=true&amp;header=false&amp;stream=false&amp;show_border=false&amp;appId=473945646001405" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:258px;" allowTransparency="true"></iframe> 
				</div> 
		</div>
	  </div>
	</div>
	
</div>


{% endfor %}	
	
</div>		  