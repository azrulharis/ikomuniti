<script>
  $(function() {
	$("#dob").datepicker({
	    changeMonth: true,
        changeYear: true, 
		dateFormat: "yy-mm-dd", 
		stepMonths: 12,
		minDate: new Date(1930, 11 - 1, 6),
        yearRange: '1930:2010'
		});
	});
</script>
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
    <div class="col-lg-12">
      
      <div class="panel panel-primary">
        <div class="panel-heading">
		  <h3 class="panel-title">iSetting</h3>
		</div>
		  <div class="panel-body">
		    <div class="bs-example">
			  <ul class="breadcrumb" style="margin-bottom: 5px;">
			    <li class="active">Profile</li>
			    <li>{{ link_to("settings/personal", "Personal Informations") }}</li> 
			    <li>{{ link_to("settings/vehicle", "Vehicle Informations") }}</li> 
			    <li>{{ link_to("settings/account", "Account Settings") }}</li> 
			  </ul>
			</div>
			
			<div class="alert alert-info alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              Remember! This information will be accessible by others iKomuniti. You can view your profile by clicking {{ link_to('profile/'~username, 'Here')}}
            </div>
            <div class="row">
			<div class="col-xs-12">
			    <div id="upload-wrapper">
					<form action="{{urlajax}}" method="post" enctype="multipart/form-data" id="MyUploadForm">
					<input name="ImageFile" id="imageInput" type="file" class="col-md-6"/>
					<input type="hidden" name="user_id" value="{{nav.id}}">
					<input type="hidden" name="{{upload_token_name}}" value="{{upload_token}}">
					<input type="submit" id="submit-btn" value="Upload"/>
					 
					<div class="bs-example">
		              <div class="progress progress-striped active" id="loading-img" style="display: none">
		                <div class="progress-bar" style="width: 45%"></div>
		              </div>
		            </div>
					</form> 
					<div id="output" class="profile_img">{{image('uploads/profiles/large/'~nav.profile_image, 'class':'img-responsive img-thumbnail pull-center')}}</div> 
				 </div>  
			  </div>
		 </div>
			{{ content() }} 
			{{ form('settings/profile', 'method': 'post') }}
			{% for user in profiles %} 
			  	 
				<div class="form-group">
				<label>Display Name</label>: {{ text_field("display_name", "value": user.display_name, "class": "form-control") }}
				</div> 
				<div class="form-group">
				<label>Current Location</label>: {{ text_field("location", "value": user.location, "class": "form-control", "placeholder": "Bandar Baru Bangi") }}
				</div>
				<div class="form-group">
				<label>Hometown</label>: {{ text_field("from", "value": user.hometown, "class": "form-control", "placeholder": "Air Hitam Muar Johor") }}
				</div>
				
				<div class="form-group">
				<label>Work Position</label>: {{ text_field("job", "value": user.job, "class": "form-control", "placeholder": "Teacher") }}
				</div>
				<div class="form-group">
				<label>Company / Department</label>: {{ text_field("company", "value": user.company, "class": "form-control", "placeholder": "Kem Pendidikan Malaysia")}}
				</div>
				<div class="form-group">
				<label>Date Of Birth</label>: {{ text_field("dob", "value": user.dob, "class": "form-control", "placeholder": "YYYY-MM-DD", "id": "dob")}}
				</div>
				<div class="form-group">
				<label>High School</label>: {{ text_field("high_school", "value": user.high_school, "class": "form-control", "placeholder": "SMT Batu Pahat")}}
				</div>
				<div class="form-group">
				<label>College</label>: {{ text_field("college", "value": user.college, "class": "form-control", "placeholder": "UTM Skudai")}}
				</div>
				<div class="form-group">
				<label>Favorite Quote</label>: {{ text_area("about", "value": user.about, "class": "form-control", "placeholder": "Enter your favorite quote...")}}
				</div>
				<div class="form-group">
				<label>Website</label>:  {{ text_field("website", "value": user.website, "class": "form-control", "placeholder": "www.mywebsite.com")}}
				                        {{ hidden_field(token_name, "value": token_value) }}
				</div>
				 
				<div class="form-group">
				 {{ submit_button('submit', 'name': 'submit', 'value': 'Update', 'class': 'btn btn-primary') }}
				</div>
			  {% elsefor %}
				
				<div class="form-group">
				<label>Display Name</label>: {{ text_field("display_name", "class": "form-control", "placeholder": "Your name display on public") }}
				</div> 
				<div class="form-group">
				<label>Current Location</label>: {{ text_field("location", "class": "form-control", "placeholder": "Bandar Baru Bangi") }}
				</div>
				<div class="form-group">
				<label>Hometown</label>: {{ text_field("from",  "class": "form-control", "placeholder": "Air Hitam Muar Johor") }}
				</div>
				
				<div class="form-group">
				<label>Work Position</label>: {{ text_field("job", "class": "form-control", "placeholder": "Teacher") }}
				</div>
				<div class="form-group">
				<label>Company / Department</label>: {{ text_field("company", "class": "form-control", "placeholder": "Kem Pendidikan Malaysia")}}
				</div>
				<div class="form-group">
				<label>Date Of Birth</label>: {{ text_field("dob", "class": "form-control", "placeholder": "YYYY-MM-DD", "id": "dob")}}
				</div>
				<div class="form-group">
				<label>High School</label>: {{ text_field("high_school", "class": "form-control", "placeholder": "SMT Batu Pahat")}}
				</div>
				<div class="form-group">
				<label>College</label>: {{ text_field("college", "class": "form-control", "placeholder": "UTM Skudai")}}
				</div>
				<div class="form-group">
				<label>Favorite Quote</label>: {{ text_area("about", "class": "form-control", "placeholder": "Enter your favorite quote...")}}
				</div>
				<div class="form-group">
				<label>Website  </label>: Http://{{ text_field("website", "class": "form-control", "placeholder": "www.mywebsite.com")}}
				                        {{ hidden_field(token_name, "value": token_value) }}
				</div>
				 
				<div class="form-group">
				 {{ submit_button('submit', 'name': 'submit', 'value': 'Save', 'class': 'btn btn-primary') }}
				</div>
			  {% endfor %}
			</form> 
	      </div>
	  </div>
    </div>
</div> 
{{ partial("partials/footer") }}

