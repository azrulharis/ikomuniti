 <div class="container spacer_80">    
	<div class="row">
	    <div class="col-lg-8">  
		 
    	<div class="panel panel-default">
       		 <div class="col-lg-12 content_heading"><h4><i class="fa fa-tags"></i> iReseller</h4><hr></div>
   			<div class="panel-body">
   			    {{ content() }} 
			   {% for post in posts %}
               <div class="row">
	              <div class="clearfix"></div> 
				  <div class="col-md-2 text-center">
				  <img src="{{path ~ post.profile_image}}" class="img-responsive img-thumbnail pull-center">
				  </div>
	              <div class="col-md-6 text-left">
				  <h4>{{ post.name }}</h4>
				  </div> 
				  <div class="col-md-4 text-left">
				    <p><i class="fa fa-user"></i> <b>{{post.username}}</b></p>
				  </div> 
				  <div class="col-md-10 text-left">
				    <p>{{ post.location }}</p><p><i class="fa fa-phone"></i> <b>{{post.phone}}</b></p>
				  </div>
				      
				  <div class="clearfix"></div>
	               
	              <hr>
              </div>
              {% endfor %}
            </div> 
    	</div>  
    	 
    	
<!-- panel right -->
 </div>    
	      <div class="col-lg-4">
		    <div class="panel panel-success"> 
				<div class="panel-body text-justify">
				<h4><i class="fa fa-tags"></i> iOffer</h4>
                <p>iOffer merupakan produk yang ditawarkan oleh iShare kepada Komuniti dengan harga yang sangat-sangat berpatutan. Komuniti boleh membuat pembelian secara dalam talian menggunakan iPoint, Online Banking ataupun Kad Kredit.</p>
                <a href="http://ishare.com.my/pages/ioffer" class="btn btn-success"><i class="fa fa-tags"></i> iOffer</a>
				<hr> 
                <h4><i class="fa fa-home"></i> iPartner</h4>
                <p>iPartner merupakan Direktori Perniagaan yang dibangunkan khas untuk Komuniti iShare yang mempunyai kedai fizikal dan ingin menawarkan diskaun kepada Komuniti iShare menggunakan Kad iShare Touch n Go. Inisiatif ini diharapkan dapat membantu Komuniti mempertingkatkan hasil dan daya saing dalam perniagaan mereka.</p>    <a href="http://ishare.com.my/pages/ipartner" class="btn btn-primary"><i class="fa fa-home"></i> iPartner</a>
				<hr>
				   <iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fishare.com.my&amp;width&amp;height=258&amp;colorscheme=light&amp;show_faces=true&amp;header=false&amp;stream=false&amp;show_border=false&amp;appId=473945646001405" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:258px;" allowTransparency="true"></iframe>
				</div>
			</div> 
	    </div>
	</div><!-- End row -->     
</div><!-- /.container -->