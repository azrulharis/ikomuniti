{{ javascript_include("js/jquery.form.min.js") }}
<script type="text/javascript">
$(document).ready(function() { 
	var options = { 
		target:   '#output',   // target element(s) to be updated with server response 
		beforeSubmit:  beforeSubmit('imageInput', 'output', 'submit-btn', 'loading-img'),  // pre-submit callback 
		success:       afterSuccess('submit-btn', 'loading-img'),  // post-submit callback 
		resetForm: true        // reset the form after successful submit 
	}; 
	
	var options2 = { 
		target:   '#second_output',   // target element(s) to be updated with server response 
		beforeSubmit:  beforeSubmit('imageInput2', 'second_output', 'submit-btn2', 'loading-img2'),  // pre-submit callback 
		success:       afterSuccess('submit-btn2', 'loading-img2'),  // post-submit callback 
		resetForm: true        // reset the form after successful submit 
	}; 
	
	var options3 = { 
		target:   '#third_output',   // target element(s) to be updated with server response 
		beforeSubmit:  beforeSubmit('imageInput3', 'third_output', 'submit-btn3', 'loading-img3'),  // pre-submit callback 
		success:       afterSuccess('submit-btn3', 'loading-img3'),  // post-submit callback 
		resetForm: true        // reset the form after successful submit 
	}; 
	
	var options4 = { 
		target:   '#last_output',   // target element(s) to be updated with server response 
		beforeSubmit:  beforeSubmit('imageInput4', 'last_output', 'submit-btn4', 'loading-img4'),  // pre-submit callback 
		success:       afterSuccess('submit-btn4', 'loading-img4'),  // post-submit callback 
		resetForm: true        // reset the form after successful submit 
	}; 
		
	$('#MyUploadForm').submit(function() { 
		$(this).ajaxSubmit(options);  			
		// always return false to prevent standard browser submit and page navigation 
		return false; 
	});
	$('#MyUploadForm2').submit(function() { 
		$(this).ajaxSubmit(options2);  			
		// always return false to prevent standard browser submit and page navigation 
		return false; 
	}); 
	$('#MyUploadForm3').submit(function() { 
		$(this).ajaxSubmit(options3);  			
		// always return false to prevent standard browser submit and page navigation 
		return false; 
	}); 
	$('#MyUploadForm4').submit(function() { 
		$(this).ajaxSubmit(options4);  			
		// always return false to prevent standard browser submit and page navigation 
		return false; 
	});  
}); 

function afterSuccess(param, response)
{
	$('#'+param).show(); //hide submit button
	$('#'+response).hide(); //hide submit button
    //$('#submit-btn').show(); //hide submit button
	//$('#loading-img').hide(); //hide submit button
}

//function to check file size before uploading.
function beforeSubmit(imageInput, output, submitbtn, loadingimg){
    //check whether browser fully supports all File API
   if (window.File && window.FileReader && window.FileList && window.Blob)
	{
		
		if(!$('#'+imageInput).val()) //check empty input filed 
		{
			$('#'+output).html("");
			return false
		}
		
		var fsize = $('#'+imageInput)[0].files[0].size; //get file size
		var ftype = $('#'+imageInput)[0].files[0].type; // get file type
		

		//allow only valid image file types 
		switch(ftype)
        {
            case 'image/png': case 'image/gif': case 'image/jpeg': case 'image/pjpeg':
                break;
            default:
                $('#'+output).html("<b>"+ftype+"</b> Unsupported file type!");
				return false
        }
		
		//Allowed file size is less than 1 MB (1048576)
		if(fsize>2097152) 
		{
			$('#'+output).html("<b>"+bytesToSize(fsize) +"</b> Too big Image file! <br />Please reduce the size of your photo using an image editor.");
			return false
		}
				
		$('#'+submitbtn).hide(); //hide submit button
		$('#'+loadingimg).show(); //hide submit button
		$('#'+output).html("");  
	}
	else
	{
		//Output error to older unsupported browsers that doesn't support HTML5 File API
		$('#'+output).html("Please upgrade your browser, because your current browser lacks some new features we need!");
		return false;
	}
}

//function to format bites bit.ly/19yoIPO
function bytesToSize(bytes) {
   var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
   if (bytes == 0) return '0 Bytes';
   var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
   return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
}

</script>
<style>
#upload-wrapper {
	width: 100%; 
	margin-top: 10px; 
	border-radius: 10px;
	box-shadow: 1px 1px 3px #AAA;
}
#upload-wrapper h3 {
	padding: 0px 0px 10px 0px;
	margin: 0px 0px 20px 0px;
	margin-top: -30px;
	border-bottom: 1px dotted #DDD;
}
#upload-wrapper input[type=file] {
	border: 1px solid #DDD;
	padding: 6px;
	background: #FFF;
	border-radius: 5px;
}
#upload-wrapper #submit-btn, #submit-btn2, #submit-btn3, #submit-btn4 {
	border: none;
	padding: 8px 10px;
	background: #61BAE4;
	border-radius: 5px;
	color: #FFF;
}
</style>
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
			<h3>{{post.title}}</h3>
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
				    <i class="glyphicon glyphicon-th-large"></i>  Ad Status: 
					{% if post.status == 1 %} 
					    <span class="green"><b>Active</b></span> 
					{% elseif post.status == 0 %} 
						<span class="yellow"><b>Pending</b></span> 
					{% elseif post.status == 2 %}  
						<span class="red"><b>Reject</b></span> 
					{% endif %}  
				</div>
			</div>
		</div> 
	    
		<div class="row">
			<div class="col-xs-12">
				<div class="span4 jun_post_body"> 
				    <pre>{{ post.description }}</pre>
				</div>     
			</div>
		</div>
	    <div class="row">
			<div class="col-xs-12">
			    <div id="upload-wrapper">
					<form action="{{urlajax}}" method="post" enctype="multipart/form-data" id="MyUploadForm">
					<input name="ImageFile" id="imageInput" type="file" class="col-md-6"/>
					<input type="hidden" name="post_id" value="{{post.id}}">
					<input type="hidden" name="{{upload_token_name}}" value="{{upload_token}}">
					<input type="submit" id="submit-btn" value="Upload"/>
					 
					<div class="bs-example">
		              <div class="progress progress-striped active" id="loading-img" style="display: none">
		                <div class="progress-bar" style="width: 45%"></div>
		              </div>
		            </div>
					</form> 
					<div id="output"></div> 
				 </div>  
			  </div>
		 </div>
		 
		 <div class="row">
			<div class="col-xs-12">
			    <div id="upload-wrapper">
					<form action="{{urlajax}}" method="post" enctype="multipart/form-data" id="MyUploadForm2">
					<input name="ImageFile" id="imageInput2" type="file" class="col-md-6"/>
					<input type="hidden" name="post_id" value="{{post.id}}">
					<input type="hidden" name="{{upload_token_name}}" value="{{upload_token}}">
					<input type="submit" id="submit-btn2" value="Upload"/>
					 
					<div class="bs-example">
		              <div class="progress progress-striped active" id="loading-img2" style="display: none">
		                <div class="progress-bar" style="width: 45%"></div>
		              </div>
		            </div>
					</form> 
					<div id="second_output"></div> 
				 </div>  
			  </div>
		 </div>
	  	 
		   <div class="row">
			<div class="col-xs-12">
			    <div id="upload-wrapper">
					<form action="{{urlajax}}" method="post" enctype="multipart/form-data" id="MyUploadForm3">
					<input name="ImageFile" id="imageInput3" type="file" class="col-md-6"/>
					<input type="hidden" name="post_id" value="{{post.id}}">
					<input type="hidden" name="{{upload_token_name}}" value="{{upload_token}}">
					<input type="submit" id="submit-btn3" value="Upload"/>
					 
					<div class="bs-example">
		              <div class="progress progress-striped active" id="loading-img3" style="display: none">
		                <div class="progress-bar" style="width: 45%"></div>
		              </div>
		            </div>
					</form> 
					<div id="third_output"></div> 
				 </div>  
			  </div>
		 </div>
		 
		 <div class="row">
			<div class="col-xs-12">
			    <div id="upload-wrapper">
					<form action="{{urlajax}}" method="post" enctype="multipart/form-data" id="MyUploadForm4">
					<input name="ImageFile" id="imageInput4" type="file" class="col-md-6"/>
					<input type="hidden" name="post_id" value="{{post.id}}">
					<input type="hidden" name="{{upload_token_name}}" value="{{upload_token}}">
					<input type="submit" id="submit-btn4" value="Upload"/>
					 
					<div class="bs-example">
		              <div class="progress progress-striped active" id="loading-img4" style="display: none">
		                <div class="progress-bar" style="width: 45%"></div>
		              </div>
		            </div>
					</form> 
					<div id="last_output"></div> 
				 </div>  
			  </div>
		 </div>  
		 
		 <div class="row">
			<div class="col-xs-12">
			    {{ link_to('imall/finish/'~post.url, 'Finish', 'class': 'btn btn-success')}} 
		    </div>
		 </div>  
		 
	  </div>  
    </div>  
  </div>
   <div class="col-lg-4">
    <h4>Rules on iMall</h4>

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