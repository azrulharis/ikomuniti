{{ stylesheet_link("css/cover.css") }} 
<!-- Just for debugging purposes. Dont actually copy this line! -->
    <!--[if lt IE 9]>{{ javascript_include("js/ie8-responsive-file-warning.js") }}<![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
<div class="site-wrapper">

      <div class="site-wrapper-inner">

        <div class="cover-container"> 
          <div class="masthead clearfix">
            <div class="inner">
              <h3 class="masthead-brand">{{ image('/img/logo.png')}}</h3>
              <ul class="nav masthead-nav">
                <li class="active"><a href="#">Home</a></li>
                <li><a href="#">Post New Ad</a></li>
                <li><a href="#">Contact</a></li>
              </ul>
            </div>
          </div>  
          <div class="row home_top"> 
	          <div class="col-lg-4 col-xs-12">
		          <a href="" class="btn btn-success pull-left"><i class="fa fa-bullhorn"></i> Sell Your Item</a> 
		      </div>
		      <div class="col-lg-8 col-xs-12">
		          <h4>Enjoy Our Free Advertising Program Build For iShare Community.</h4>
		      </div>
		      <div class="col-lg-12">
		          {{ content() }}
		      </div>
          </div>
          <div class="row home_form">
            {{ form('find', 'method': 'get')}}
            <div class="form-group col-lg-4">
                <input size="32" class="form-control" name="title" id="title" type="text" placeholder="Search..."/>
            </div>
			<div class="form-group col-lg-4">
				<select name="category" class="form-control category" id="category">
					<option value="986750">All Categories</option>
					{% for cat in categories %}
						<option value="{{ cat.id }}">{{cat.name}}</option>
					{% endfor %}
				</select>
			</div>
			<div class="form-group col-lg-3">
				<select name="region" class="form-control" id="selectId"> 
				<option value="x">Select Region</option>
				<option value="1">Johor</option>
				<option value="2">Melaka</option>
				<option value="3">Negeri Sembilan</option>
				<option value="4">Selangor</option>
				<option value="5">Kuala Lumpur</option>
				<option value="6">Pahang</option>
				<option value="7">Perak</option>
				<option value="8">Kedah</option>
				<option value="9">Pulau Pinang</option>
				<option value="10">Perlis</option>
				<option value="11">Terengganu</option>
				<option value="12">Kelantan</option>
				<option value="13">Sabah</option>
				<option value="14">Sarawak</option>
				</select>
			</div>
            
            <div class="form-group col-lg-1">
				 <input type="submit" name="submit" value="Search" class="btn btn-success pull-left">
			</div>
			</form>
          </div>
		  <div class="row">  
	        <div class="col-lg-12 col-md-12 col-xs-12">
	           <h1><a href="http://112.137.167.189/kelebihan.html" class="btn btn-primary"><i class="fa fa-star"></i> Join iShare Community</a></h1>
			</div>
	             
	           <div class="col-lg-4 col-xs-12 col-md-4 col-sm-6">
           <div class="box">
               <img src="images/voucher.png" class="img-thumbnail pull-center">
                <h2><i class="fa fa-tags"></i> Free Voucher</h2>
               
           </div>
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4 col-xs-12 col-md-4 col-sm-6">
            <div class="box">
                <img src="images/imall.jpg" class="pull-center img-thumbnail" width="240" height="180">
                <h2><i class="fa fa-shopping-cart"></i> Free Ads</h2>
                
            </div>
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4 col-xs-12 col-md-4 col-sm-6">
           <div class="box">
               <img src="images/towing_trans.png" class="pull-center img-thumbnail" width="240" height="200">
               <h2><i class="fa fa-truck"></i> Free Towing</h2>
               
           </div>
        </div><!-- /.col-lg-4 -->    
	            
          </div> 

        </div>

      </div>

    </div>