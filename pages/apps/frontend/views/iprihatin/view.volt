<div class="container spacer_80">     
{% for iprihatin in iprihatins %}
<div class="row">
	<div class="col-lg-8"> 
		{{ content()}}
		
		<div class="panel panel-default"> 
			
			<div class="panel-body">
			<h4 class="panel-title">{{ link_to('iprihatin', 'iPrihatin')}}</h4>
			<hr>
			<h4>{{ iprihatin.title }}</h4>
			 
			<p>
			<span class="fa fa-clock-o"></span> Posted on {{ iprihatin.created }}</p>
			<hr>
			
			<div class="row">
			 <div class="col-xs-12">
			  <div id="jun_images" class="col-lg-8">
				{% if not (iprihatin.image is empty) %}
				    <img src="{{iprihatin_upload_dir}}{{iprihatin.image}}" class="img-responsive imall_image">
				{% else %}
					<img src="{{iprihatin_upload_dir}}no_photo.jpg" class="img-responsive imall_image">
				{% endif %}
			  </div>
			 </div>
			</div>
			
			<div class="jun_post_body">
			    <pre>{{ iprihatin.body }}</pre> 
		    </div>
			</div>
		</div>
		 
	</div>
 
	<div class="col-lg-4"> 
	 <div class="panel panel-success">
		<div class="panel-heading">
		  <h4 class="panel-title"><i class="fa fa-gift"></i> iPrihatin</h4>
		</div>
		<div class="panel-body text-justify"> 
		  {{image('images/sedekah.jpg', 'class': 'img-responsive')}}
		  <p class="text-justify">Dari Abu Hurairah : Sesungguhnya Rasulullah s.a.w bersabda "Tidaklah harta menjadi berkurang kerana sedekah, dan tidaklah seseorang yang memberi maaf kepada orang lain, melainkan Allah akan menambah kehormatan kepada dirinya; dan seseorang tiada bersikap merendah diri kerana Allah , melainkan ia akan diangkat darjatnya oleh Allah."
( HR Muslim dan Tirmidzi )</p>
		   
		</div>
	  </div> 
	</div>
</div>
{% endfor %}   
</div>