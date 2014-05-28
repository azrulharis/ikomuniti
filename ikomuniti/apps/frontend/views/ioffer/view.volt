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
    $('#addToCart').click(function(){
        var js_token = $('#ioffer_token').val();
        var js_ioffer_id = $('#ioffer_id').val();
        var js_ioffer_title = $('#ioffer_title').val();
        var js_ioffer_price = $('#ioffer_price').val();
        var js_ioffer_quantity = $('#ioffer_quantity').val(); 
        //syntax - $.post('filename', {data}, function(response){});
        $.post('{{ajaxCartUrl}}',{
		    action: "addToCart", 
			    post_token:js_token, 
			    post_ioffer_id:js_ioffer_id, 
				post_ioffer_title:js_ioffer_title, 
				post_ioffer_price:js_ioffer_price, 
				post_ioffer_quantity:js_ioffer_quantity
		}, function(res) {
            $('#result').html(res);
        });        
    });

    //show records
    $('#show').click(function(){
        $.post('{{ajaxCartUrl}}',{action: "show"},function(res){
            $('#result').html(res);
        });        
    });
});
</script>
 
{{ partial("partials/navigation") }} 
{% for post in posts %}    
<div class="row">
        <div class="col-lg-8">
          <div class="panel panel-primary">
             
	        <div class="panel-body imall_table"> 
			<div class="bs-example">
			  <ul class="breadcrumb" style="margin-bottom: 5px;">
			    <li>{{ link_to("ioffer/index", "iOffer") }}</li> 
			  </ul>
			</div>  
	    
		<div class="big_box jun_label">	 
			  {{ content() }} 
			 
				<div class="row">
				  <div class="col-xs-12">     
					<h3>{{ link_to('view/' ~ post.title, post.title) }}</h3>
				  </div>	
				</div>
				<div class="row"> 
					<div class="col-xs-12">
						<div class="col-md-4 text-left">
						 <i class="glyphicon glyphicon-time"></i> {{ post.created }}
						</div>
						<div class="col-md-4 text-left">
						  <p>Price <span style="color: #FF0000; text-decoration:line-through">{{ post.market_price }}</span> RM<b>{{ post.price }}</b></p>
						</div>
						<div class="col-md-4 text-left">
						 <i class="glyphicon glyphicon-th-large"></i> Available Stock {{ post.stock }}
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
					{% if post.image != '' %}
					    <div id="jun_images" class="col-lg-8">
						{{ image('uploads/ioffers/images/'~post.image, 'title': post.title, 'alt': post.title, 'data-src': 'holder.js/500x500/auto', 
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
							<img class="img-thumbnail" src="{{ ioffer_thumb_dir ~ thumb.image_name }}"/></li>
				             
					    {% endfor %}
						</ul></div>
					{% endif %}
					</div>
				</div>
				
				<div class="row">
					<div class="col-xs-12">
						<div class="span4 jun_post_body"> 
						    <pre>{{ post.body }}</pre>
						 
						</div>     
					</div>
				</div>
		       
        </div>	
	</div> 
    </div>
    

  
  </div>
  <div class="col-lg-4">
      <div class="panel panel-primary">
          
        <div class="panel-body">
	            
			    <h4>Market Price<span class="pull-right" style="color: #FF0000; text-decoration:line-through">RM{{ post.market_price }}</span></h4>
			    <hr>
			    <h4>Price<span class="pull-right">RM{{ post.price }}</span></h4><span>
			    <hr>
			    <h4>In Stock<span class="pull-right">{{ post.stock }}</span></h4>
                <hr>
				<input type="hidden" name="ioffer_token" value="{{field_value}}" id="ioffer_token" class="form-control"/>
				<input type="hidden" name="ioffer_id" value="{{ post.id }}" id="ioffer_id"/>
				<input type="hidden" name="ioffer_title" value="{{ post.title }}" id="ioffer_title"/>
				<input type="hidden" name="ioffer_price" value="{{ post.price }}" id="ioffer_price"/> 
 				<div class="input-group">
                <div class="input-group-btn">
                    <button class="btn btn-primary" id="addToCart"><i class="fa fa-shopping-cart"></i> Add To Cart</button> 
                </div>
                    <input type="text" class="form-control" placeholder="Enter Quantity" value="1" id="ioffer_quantity">
                </div> 
			     
		    </div>
	  </div>
	  <div class="panel panel-primary">
        <div class="panel-heading">
		   <h4><i class="fa fa-shopping-cart"></i>  Shopping Cart</h4>
		</div>
		<div class="panel-body">
          <ul class="list-group" id="result">
              {{viewCart}} 
          </ul>
          {{ link_to("ioffer/index", "Continue Shopping", "class": "btn btn-success") }}
          {{ link_to("ioffer/viewcart", "View Cart", "class": "btn btn-primary") }} 
        </div>
   	  </div>
	   
	  
	</div>
</div>
{% endfor %} 
<!--<div class="row">
    <div class="col-lg-4 col-md-2 col-sm-4 col-xs-6">
      <div class="rec-banner blue">
        <div class="banner"> <i class="fa fa-thumbs-up"></i>
          <h3>Guarantee</h3>
          <p>100% Money Back Guarantee*</p>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-2 col-sm-4 col-xs-6">
      <div class="rec-banner red">
        <div class="banner"> <i class="fa fa-tags"></i>
          <h3>Affordable</h3>
          <p>Convenient &amp; affordable prices for you</p>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-2 col-sm-4 col-xs-6">
      <div class="rec-banner orange">
        <div class="banner"> <i class="fa fa-headphones"></i>
          <h3>24/7 Support</h3>
          <p>We support everything we sell</p>
        </div>
      </div>
    </div>
  </div>
 
  <div class="row">
    <div class="col-lg-4 col-md-2 col-sm-4 col-xs-6">
      <div class="rec-banner lightblue">
        <div class="banner"> <i class="fa fa-female"></i>
          <h3>Summer Sale</h3>
          <p>Upto 50% off on all women wear</p>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-2 col-sm-4 col-xs-6">
      <div class="rec-banner darkblue">
        <div class="banner"> <i class="fa fa-gift"></i>
          <h3>Surprise Gift</h3>
          <p>Value $50 on orders over $700</p>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-2 col-sm-4 col-xs-6">
      <div class="rec-banner black">
        <div class="banner"> <i class="fa fa-truck"></i>
          <h3>Free Shipping</h3>
          <p>All over in world over $100</p>
        </div>
      </div>
    </div> 
  </div>
    -->
			 
{{ partial("partials/footer") }}