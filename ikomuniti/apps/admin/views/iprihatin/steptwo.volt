{{ javascript_include("js/jquery.form.min.js") }}
<script type="text/javascript">
$(document).ready(function() { 
	var options = { 
			target:   '#output',   // target element(s) to be updated with server response 
			beforeSubmit:  beforeSubmit,  // pre-submit callback 
			success:       afterSuccess,  // post-submit callback 
			resetForm: true        // reset the form after successful submit 
		}; 
		
	 $('#MyUploadForm').submit(function() { 
			$(this).ajaxSubmit(options);  			
			// always return false to prevent standard browser submit and page navigation 
			return false; 
		}); 
}); 

function afterSuccess()
{
	$('#submit-btn').show(); //hide submit button
	$('#loading-img').hide(); //hide submit button

}

//function to check file size before uploading.
function beforeSubmit(){
    //check whether browser fully supports all File API
   if (window.File && window.FileReader && window.FileList && window.Blob)
	{
		
		if( !$('#imageInput').val()) //check empty input filed
		{
			$("#output").html("Are you kidding me?");
			return false
		}
		
		var fsize = $('#imageInput')[0].files[0].size; //get file size
		var ftype = $('#imageInput')[0].files[0].type; // get file type
		

		//allow only valid image file types 
		switch(ftype)
        {
            case 'image/png': case 'image/gif': case 'image/jpeg': case 'image/pjpeg':
                break;
            default:
                $("#output").html("<b>"+ftype+"</b> Unsupported file type!");
				return false
        }
		
		//Allowed file size is less than 1 MB (1048576)
		if(fsize>1048576) 
		{
			$("#output").html("<b>"+bytesToSize(fsize) +"</b> Too big Image file! <br />Please reduce the size of your photo using an image editor.");
			return false
		}
				
		$('#submit-btn').hide(); //hide submit button
		$('#loading-img').show(); //hide submit button
		$("#output").html("");  
	}
	else
	{
		//Output error to older unsupported browsers that doesn't support HTML5 File API
		$("#output").html("Please upgrade your browser, because your current browser lacks some new features we need!");
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
.profile_img {
	
}

.profile_img img {
	width: 180px;
}
</style>


{{ partial("partials/navigation") }}
<div class="row">
    <div class="col-lg-8"> 
    	<div class="panel panel-primary">
           <div class="panel-heading">iPrihatin</div>
   			<div class="panel-body">
   			
			      {{ link_to("gghadmin/iprihatin/index", "iPrihatin", "class": "jun_button") }}
				  {{ link_to("gghadmin/iprihatin/add", "New Post", "class": "jun_button") }}
				  {% for iprihatin in iprihatins %}
				  
				  
				    <div class="jun_view_iprihatin"> 
				    {{ content()}}
					    
				        <h4>{{link_to("gghadmin/iprihatin/view/" ~ iprihatin.slug, iprihatin.title)}}</h4> 
				        <p>Tarikh {{iprihatin.created}}</p><p>Jumlah Sumbangan <b>RM{{iprihatin.amount}}</b></p>
				        {{ link_to("gghadmin/iprihatin/edit/" ~  iprihatin.slug, "Edit This Post", "class": "btn btn-danger") }}
				        <pre>{{iprihatin.body}}</pre>
					         
					
					
				<div class="row">
					<div class="col-xs-12">
					    <div id="upload-wrapper">
							<form action="{{urlajax}}" method="post" enctype="multipart/form-data" id="MyUploadForm">
							<input name="ImageFile" id="imageInput" type="file" class="col-md-6"/>
							<input type="hidden" name="post_id" value="{{iprihatin.id}}"> 
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
			  <div class="form-group">
			    <a href="?ref=save" class="btn btn-success">Save</a>
			  </div>
             {% endfor %}
        </div> 
    </div>
	</div>
	<div class="col-lg-4"> 
		 <div class="bs-example wgreen">
          <div class="list-group">
            <a href="/ishare/isharephal/iprihatin/index" class="list-group-item active">
              <i class="glyphicon glyphicon-info-sign"></i>  iPrihatin
            </a>
            {% for right in rights %}
            <a href="/ishare/isharephal/gghadmin/iprihatin/view/{{ right.slug }}" class="list-group-item"><h4>{{ right.title }}</h4> 
			<p class="list-group-item-text">{{ right.body }}...</p>
			</a> 
            {% endfor %}
            <a href="/ishare/isharephal/gghadmin/iprihatin/index" class="list-group-item"> View All 
                  <i class="fa fa-arrow-circle-right"></i> 
          </a>
          </div>
        </div> 
	</div> 
</div>
{{ partial("partials/footer") }}