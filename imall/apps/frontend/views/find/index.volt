<script type="text/javascript">
	$(document).ready(function() {
	    $(".category").change(function() {
	        var category=$(this).val();
	        var dataString = 'category='+ category;
	        $.ajax ({
	            type: "POST",
	            url: "search_option.php",
	            data: dataString,
	            cache: false,
	            success: function(html) {
	               $(".search_option").html(html);
	            } 
	        });
	     });
	}); 
</script> 
{{ javascript_include("js/offcanvas.js") }} 
{{ stylesheet_link("css/offcanvas.css") }} 
<div class="header_bg">
<div class="container"> 
		<div class="header">
	        {{ link_to('index', image('/img/logo.png')) }}
	        <a href="{{ikomuniti_dir}}/imall/add" class="btn btn-success pull-right"><i class="fa fa-plus-circle"></i> Sell Your Item</a>
	    </div><!-- Header--> 
</div> 
</div>
 
<div class="container space-top">
    
    <div class="row search_form">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">           
      {{ form('find', 'method': 'get')}}
            <div class="form-group col-lg-4 col-sm-3 col-md-4 col-xs-12">
                <input size="32" class="form-control" name="title" id="title" type="text" placeholder="Search..." value="{{ query|e }}"/>
            </div>
			<div class="form-group col-lg-4 col-sm-4 col-md-4 col-xs-12">
				<select name="category" class="form-control category" id="category">
					<option value="986750">All Categories</option>
					{% for cat in categories %}
		<option value="{{ cat.id }}" {% if cat_id == cat.id %}selected{%endif%} {% if cat.type == 1 %}class="option_parent"{%endif %}>{{cat.name}}</option>
					{% endfor %}
				</select>
			</div>
			<div class="form-group col-lg-3 col-sm-3 col-md-3 col-xs-12">
				<select name="region" class="form-control" id="selectId"> 
				    {% for top in tops %}
				        <option value="{{ top.id }}">{{ top.name }}</option>
						<option value="112" {% if region_id == 112 %}selected{%endif%}>Neighbouring Region</option>
						<option value="102" {% if region_id == 102 %}selected{%endif%}>Entire Malaysia</option>
						<option value="x"disabled>Select Region</option>
				    {% endfor %}
				    {% for region in regions %}
				        <option value="{{ region.id }}" {% if region_id == region.id %}selected{%endif%}>{{ region.name }}</option>
				    {% endfor %} 
				</select>
			</div>
			<div class="form-group col-lg-1 col-sm-1 col-md-12 col-xs-12">
				 <input type="submit" name="submit" value="Search" class="btn btn-success pull-left">
			</div>
          </form>
          </div>
      </div>
      
      <div class="row row-offcanvas row-offcanvas-right">

        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9"> 
        <!-- nuffnang -->
<script type="text/javascript">
        nuffnang_bid = "f20bae427dae947f35ce14e4f2dbfc72";
        document.write( "<div id='nuffnang_lb'></div>" );
        (function() {	
                var nn = document.createElement('script'); nn.type = 'text/javascript';    
                nn.src = 'http://synad2.nuffnang.com.my/lb.js';    
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(nn, s.nextSibling);
        })();
</script>
<!-- nuffnang-->
        
          {{ content() }}
		  {% for post in posts %} 
	          <div class="row"> 
	            <div class="col-xs-12 col-sm-2 col-lg-2 col-md-2 jun_image"> 
				  {% if post.image != '' %}
				  	<img src="{{imall_thumb_image_dir ~ post.image}}" class="img-responsive img-thumbnail pull-center">
				  {% else %}
				    <img src="{{imall_thumb_image_dir}}no_photo.jpg" class="img-responsive img-thumbnail pull-center">
				  {% endif %}
				</div>
				<div class="col-sm-8 col-lg-8 col-md-8 col-xs-12 jun_content">
	                <h4>{{ link_to('ads/'~post.slug, post.title|e)}}</h4>
					 
	            </div>
	            <div class="col-sm-2 col-lg-2 col-md-2 col-xs-12 jun_content_right"> 
					<p><i class="fa fa-clock-o"></i> {{ post.created }}<br/> 
	            </div><!--/span-->  
	            <div class="col-sm-8 col-lg-4 col-md-4 col-xs-12 jun_content"> 
					<p><i class="fa fa-bars"></i> {{ post.category }} 
	            </div>
	            <div class="col-sm-8 col-lg-4 col-md-4 col-xs-12 jun_content"> 
					<p><i class="fa fa-map-marker"></i> {{ post.location }}</p>
	            </div>
	            <div class="col-sm-12 col-lg-2 col-md-2 col-xs-12">  
					{% if post.price != 0 %}
					    <p><i class="fa fa-tag"></i> <b>RM{{post.price}}</b></p>
					{% endif %} 
	            </div><!--/span-->  
	          </div><!--/row-->
	          <hr>
	      {% elsefor %}
	          <div class="alert alert-danger">
		        There is no product to show.
		      </div>
          {% endfor %}
          
          
          
        </div><!--/span-->

        <div class="col-xs-6 col-sm-3 col-lg-3 col-md-3 sidebar-offcanvas" id="sidebar" role="navigation">  
		  <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-bullhorn"></i> Sponsor Ads</h3>
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
                        
            </div>
          </div>
        </div><!--/span-->
      </div><!--/row-->
	  
	  </div><!--/.container-->
	  
    <div class="container"> 
    <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
              {{ paginationUrl }}
          </div>
    </div><!--/row-->
    </div> 
      <hr>

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

    

 

