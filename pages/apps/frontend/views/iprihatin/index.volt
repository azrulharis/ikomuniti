 <div class="container spacer_80">    
	<div class="row">
	    <div class="col-lg-8">  
	    
	    
    	<div class="panel panel-default">
       		 <div class="col-lg-12 content_heading"><h4><i class="fa fa-wheelchair"></i> iPrihatin </h4><hr></div>
   			<div class="panel-body">
   			    {{ content() }}
				 
			   {% for iprihatin in iprihatins %}
               <div class="row">
	              <div class="clearfix"></div>
	              <a href="iprihatin/view/{{iprihatin.slug}}">
				  <div class="col-md-2 col-lg-2 col-sm-12 col-xs-12 text-center">
				  {% if iprihatin.image != '' %}
				  	<img src="{{iprihatin_thumb_dir ~ iprihatin.image}}" class="img-responsive img-thumbnail pull-center" width="120">
				  {% else %}
				  	<img src="{{iprihatin_thumb_dir}}no_photo.jpg" class="img-responsive img-thumbnail pull-center" width="120">
				  {% endif %}
				  </div>
	              <div class="col-md-10 col-lg-10 col-sm-12 col-xs-12 text-left">
				  <h4>{{ iprihatin.title|e }}</h4>
				  </div>
				  </a> 
				  <div class="col-md-10 col-lg-10 col-sm-12 col-xs-12 text-left">
				    <p>{{ iprihatin.body|e }}...</p>
				  </div>
				  <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12 text-left">
				  <p><i class="fa fa-clock-o"></i> {{ iprihatin.created|e }}</p> 
				  </div> 
				   
				   
				  <div class="clearfix"></div>
	               
	              <hr>
              </div>
              {% endfor %}
                <div class="row">
					{{ paginationUrl }}
				</div>
            </div> 
    	</div>  
<!-- panel right -->
 </div>   
            
            
	      <div class="col-lg-4">
		    <div class="panel panel-success"> 
				<div class="panel-body text-justify"> 
                <h4><i class="fa fa-gift"></i> iPrihatin</h4>
                <p>Mewujudkan suasana saling bantu-membantu antara satu sama lain dalam menghulurkan bantuan kepada mereka yang kurang bernasib baik. Komuniti boleh menghulurkan sumbangan hanya dengan 1 klik menggunakan iPoint.</p>
				<hr>
				<h4><i class="fa fa-shopping-cart"></i> iMall</h4>
                <p>iMall merupakan platform pengiklanan bagi meningkatkan hasil jualan atau menjana pendapatan sampingan dikalangan Komuniti iShare. Komuniti iShare boleh mengiklankan seberapa banyak produk atau perkhidmatan secara percuma.</p>
				<hr>
				   <iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fishare.com.my&amp;width&amp;height=258&amp;colorscheme=light&amp;show_faces=true&amp;header=false&amp;stream=false&amp;show_border=false&amp;appId=473945646001405" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:258px;" allowTransparency="true"></iframe>
				</div>
			</div> 
	    </div>
	</div><!-- End row -->     
</div><!-- /.container -->







