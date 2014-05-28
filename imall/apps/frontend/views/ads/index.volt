<script>
$("document").ready(function() {
	$("ul.jun_thumbnails li").click(function () {
		$("#jun_images").load('{{urlajax}}', {'id': $(this).attr('id')});
		$("ul.jun_thumbnails li").removeClass('jun_highlight');
		$(this).addClass('jun_highlight');
	});
});

$(function(){
    //insert record
    $('#message_send').click(function(){          
        var js_xmt = $('#messsage_xmt').val();
        var js_id = $('#messsage_id').val();
        var js_xmd = $('#messsage_xmd').val();
        var js_name = $('#messsage_name').val();
        var js_phone = $('#messsage_phone').val();
        var js_email = $('#messsage_email').val(); 
        var js_body = $('#messsage_body').val();  
        var js_uxmt = $('#messsage_uxmt').val(); 
        //syntax - $.post('filename', {data}, function(response){}); 
        $.post('{{ajaxMessage}}',{
		    action: "message_send", 
			    post_xmt:js_xmt, 
			    post_id:js_id, 
			    post_xmd:js_xmd,
				post_name:js_name, 
				post_phone:js_phone, 
				post_email:js_email,
				post_body:js_body,
				post_uxmt:js_uxmt
		}, function(res) {
            $('#result').html(res);
        });        
    });

    //show records
    $('#show').click(function(){
        $.post('{{ajaxMessage}}',{action: "show"},function(res){
            $('#result').html(res);
        });        
    });
});
 $(function() {
    $('#contact_form').click(function() {
    $('.contact_form').toggle();
    return false;
    }); 
});
</script>  
{{ stylesheet_link("css/view-ads.css") }}
<div class="header_bg">
<div class="container"> 
		<div class="header">
	        {{ link_to('index', image('/img/logo.png')) }}
	        <a href="{{ikomuniti_dir}}/imall/add" class="btn btn-success pull-right"><i class="fa fa-plus-circle"></i> Sell Your Item</a>
	    </div><!-- Header--> 
</div> 
</div>
{% for post in posts %}   
<div class="container space-top"> 
    <div class="row"> 
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 view-ad">  
			  {{ content() }} 
			  
				  <div class="col-xs-12">     
					<h3>{{ link_to('ads/' ~ post.url, post.title) }}</h3>
				  </div>  
					<div class="col-xs-12">
						<div class="col-md-3 text-left">
						 <i class="fa fa-clock-o"></i> {{ post.created }}
						</div>
						<div class="col-md-3 text-left">
						  <i class="fa fa-tag"></i> Price RM{{ post.price }} 
						</div>
						<div class="col-md-6 text-left">
						 <i class="fa fa-bars"></i> Category {{post.category}}
						</div>
					</div> 
					<div class="col-xs-12">
					{% if post.image != '' %}
					    <div id="jun_images"> 
						<img class="img-responsive" src="{{ image_dir ~ post.image }}" alt="{{post.title}}" title="{{post.title}}"/>
						</div>
					{% endif %}
					</div>
					
					<div class="col-xs-12">
				    {% if thumbnail == 1 %} 
					    <div class="thumbImage"><ul class="jun_thumbnails thumbnails">
				        {% for thumb in thumbs %}
				             
					        <li id="{{ thumb.image_name }}" class="span4">
							<img class="img-thumbnail" src="{{ thumb_dir ~ thumb.image_name }}"/></li>
				             
					    {% endfor %}
						</ul></div>
					{% endif %}
					</div>
					 
					<div class="col-xs-12"> 
					  <div class="ads-info">
						  <p class="col-xs-12 col-lg-6">Region: <b>{{post.region}}</b></p>
						  <p class="col-xs-12 col-lg-6">Location: <b>{{post.location}}</b></p> 
					 
				          <p class="col-xs-12 col-lg-6">Price: <b>{{post.price}}</b></p> 
				          <p class="col-xs-12 col-lg-6">Condition:<b>{{post.cond}}</b></p> 
					 
						  <p class="col-xs-12 col-lg-6">Category: <b>{{post.category}}</b></p> 
				          <p class="col-xs-12 col-lg-6">Post On: <b>{{post.created}}</b></p> 
						   
				          <p class="col-xs-12 col-lg-12">Address: <b>{{post.address}}</b></p> 
			          </div>
					</div> 
					<div class="col-xs-12">
						<div class="span4 jun_post_body"> 
						    <pre>{{ post.body }}</pre>
						 
						</div>     
					</div>  
					<div class="col-xs-12 contact-seller">
					    <h4 class="col-lg-4 col-xs-12"><i class="fa fa-user"></i> {{post.username}}</h4>
 						<h4 class="col-lg-4 col-xs-12"><i class="fa fa-phone-square"></i> {{post.telephone}}</h4>
 						<h4 id="contact_form" class="col-lg-4 col-xs-12"><i class="fa fa-envelope"></i> <a href="">Contact This Seller</a></h4>
						<div class="contact_form" style="display:none;"> 
						    <div id="result" class="col-lg-12 col-md-12 col-xs-12"></div>
						    <div class="form-group">
							    <label class="col-lg-3">Name</label>
							    <div class="form-group col-lg-9">
							      <input type="text" name="name" class="form-control" id="messsage_name" placeholder="Enter your name...">
							    </div>
							</div>
							<div class="form-group">
							    <label class="col-lg-3">Phone Number</label>
							    <div class="form-group col-lg-9">
							      <input type="text" name="phone" class="form-control" id="messsage_phone" placeholder="0123456789">
							    </div>
							</div>
							<div class="form-group">
							    <label class="col-lg-3">Email</label>
							    <div class="form-group col-lg-9">
							      <input type="text" name="email" class="form-control" id="messsage_email" placeholder="name@email.com">
							    </div>
							</div>
							<div class="form-group">
							    <label class="col-lg-3">Message</label>
							    <div class="form-group col-lg-9">
							      <textarea name="name" class="form-control" id="messsage_body" placeholder="Enter your message..."></textarea>
							      <input type="hidden" name="token" id="messsage_xmt" value="{{token_value}}">
							      <input type="hidden" name="xmd" id="messsage_xmd" value="{{post.u_id}}">
							      <input type="hidden" name="mxd" id="messsage_id" value="{{post.id}}">
							      <input type="hidden" name="uxmt" id="messsage_uxmt" value="{{post.url}}">
							    </div>
							</div>
							<div class="form-group">
							    <label class="col-lg-3"></label>
							    <div class="form-group col-lg-9">
							      <input type="submit" name="submit" value="Send" id="message_send" class="btn btn-success">
							    </div>
							</div>
						</div>     
					</div>  
					  
  
  </div>
  <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
      <div class="panel panel-primary">
           <div class="box blue">
               <h2><i class="fa fa-bullhorn"></i> Free Ads</h2>
               <h4>Enjoy unlimited free ads service by joining our cummunity program.</h4>  
               <a href="{{register}}" class="btn btn-default pull-center"><i class="fa fa-pencil-square"></i> Register Now</a>
           </div>
        
	  </div>
	  <!-- Seller Info -->
	  <div class="panel">
        <div class="panel-heading">
		   <i class="fa fa-bookmark"></i> Seller Info
		</div>
		<div class="panel-body">
		<!-- nuffnang -->
<script type="text/javascript">
        nuffnang_bid = "f20bae427dae947f35ce14e4f2dbfc72";
        document.write( "<div id='nuffnang_ss'></div>" );
        (function() {	
                var nn = document.createElement('script'); nn.type = 'text/javascript';    
                nn.src = 'http://synad2.nuffnang.com.my/ss.js';    
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(nn, s.nextSibling);
        })();
</script>
<!-- nuffnang-->
                        
		
		  <div class="user-profile"> 
			    
	          <img class="img-responsive" src="{{ profile_image_path ~ post.profile_image }}"/>  
			  <p><i class="fa fa-user"></i> {{ post.name }} </p>
	          <p><i class="fa fa-envelope"></i> Email {{ post.email }}</p>
	          <p><i class="fa fa-clock-o"></i> Join on {{ post.since }}</p> 
          </div>
        </div>
   	  <!-- End seller info -->
   	  
   	  <!-- Seller ads -->
   	  {% if other_ad == 1 %} 
   	    <div class="panel-heading">
		   <i class="fa fa-bookmark"></i> Others Ad
		</div>
        <div class="seller-ad">
	        <ul>
			  {% for ad in ads %}
	            {% if ad.image != '' %}
	                <li class="col-md-6 col-lg-6 col-xs-12">
					    <img class="img-responsive" src="{{ thumb_dir ~ ad.image }}" alt="{{ad.title}}" title="{{ad.title}}" height="80"/>
					</li>
	            {% else %}
	                <li class="col-md-6 col-lg-6 col-xs-12">
					    <img class="img-responsive" src="{{ thumb_dir }}no_photo.jpg" alt="{{ad.title}}" title="{{ad.title}}" height="80"/>
					</li>
	            {% endif %} 
			  {% endfor %}
	        </ul>
		</div>
		{% endif %}
		<!-- End seller ads -->
	  </div>
	  
	  
	   
	  
	</div>
</div>
{% endfor %} 
</div>

 <footer> 
          <div class="col-lg-3 col-xs-12 col-md-3 col-sm-6">
              <ul>
                  <h3><i class="fa fa-home"></i> Utama</h3>
                  <li><a href="index.html">Home</a></li>
                  <li><a href="mengenai.html">Mengenai iShare</a></li>
                  <li><a href="kelebihan.html">Kelebihan iShare</a></li>
                  <li><a href="igaleri.html">Galeri</a></li>
                  <li><a href="hubungi.html">Hubungi</a></li>
              </ul>
          </div>
          <div class="col-lg-2 col-xs-12 col-md-3 col-sm-6">
              <ul>
                  <h3><i class="fa fa-info"></i> iShare</h3>
                  <li><a href="iprihatin.html">iPrihatin</a></li> 
                  <li><a href="http://ishare.com.my/imall">iMall</a></li>
                  <li><a href="ireseller.html">iReseller</a></li>
                  <li><a href="https://ishare.com.my/ikomuniti">iKomuniti</a></li>
                  <li><a href="http://ishare.com.my/users/register">Daftar</a></li>
              </ul>
          </div>
          <div class="col-lg-4 col-xs-12 col-md-3 col-sm-6">
          	  <ul>
          	      <h3><i class="fa fa-briefcase"></i> Partner</h3>
                  <li><a href="http://gmn.com.my">Global Medic Network Sdn Bhd</a></li>
				  <li><a href="http://tourismnetwork.com.my/v1">Global Tourism Network Sdn Bhd</a></li>
				  <li><a href="http://fairpark.com.my">Fairpark Corporation Sdn Bhd</a></li>
				  <li><a href="http://synergyrider.com">Fairpark Synergy Sdn Bhd</a></li>
				  <li><a href="http://wardrobe2u.com">Wardrobe2u Boutique</a></li>
              </ul>
          </div>
          <div class="col-lg-3 col-xs-12 col-md-3 col-sm-6">
              <ul>
                  <h3><i class="fa fa-external-link"></i>  Pautan</h3>
                  <li><a href="http://www.takaful-ikhlas.com.my" target="_blank">Takaful Ikhlas</a></li>
                  <li><a href="http://www.crp.com.my" target="_blank">Car Replacement Program</a></li>
                  <li><a href="https://www.touchngo.com.my/" target="_blank">Touch n Go</a></li>
                  <li><a href="http://www.jpj.gov.my/pertanyaan-saman-notis" target="_blank">Semak Saman JPJ</a></li>
				  <li><a href="https://www.rilek.com.my/webapps/pdrm/csform.php" target="_blank">Semak Saman Polis</a></li>
              </ul>
          </div> 
          <div class="col-lg-12">
              <p>Copyright &copy; 2014 Global Group Holdings Sdn Bhd</p>
          </div> 
      </footer>