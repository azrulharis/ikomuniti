
{{ partial("partials/navigation") }}

<div class="row">

	<div class="col-lg-8">
		<div class="panel panel-primary">
			<div class="panel-heading">iPrihatin</div>
   			<div class="panel-body">
	        {{ link_to("gghadmin/iprihatin/index", "iPrihatin", "class": "btn btn-primary") }}
				  {{ link_to("gghadmin/iprihatin/add", "New Post", "class": "btn btn-success") }}
			 
			{{ content()}}	 
			<div class="jun_reply_message">    
				<form action="" method="POST" enctype="multipart/form-data" >
				<div class="form-group">
				<label>Title</label>
				 {{ text_field("title", "size": 45, "class": "form-control", "placeholder": "iPrihatin title...") }}
				 </div>
				 <div class="form-group">
				 <label>Body</label>
				<textarea name="body" class="form-control" placeholder="Type your message..."></textarea>
				</div> 
				<div class="form-group"> 
				<input class="btn btn-success" name="Submit" type="submit" value="Post" onClick="submitForm(this)"> 
				</div>
				</form>
			</div> </div> 
		</div>
	</div>
	
		<div class="col-lg-4"> 
		 <div class="bs-example wgreen">
          <div class="list-group">
            <a href="/ikomuniti/gghadmin/iprihatin/index" class="list-group-item active">
              <i class="glyphicon glyphicon-info-sign"></i>  iPrihatin
            </a>
            {% for right in rights %}
            <a href="/ikomuniti/gghadmin/iprihatin/view/{{ right.slug }}" class="list-group-item"><h4>{{ right.title }}</h4> 
			<p class="list-group-item-text">{{ right.body }}...</p>
			</a> 
            {% endfor %}
            <a href="/ikomuniti/gghadmin/iprihatin/index" class="list-group-item"> View All 
                  <i class="fa fa-arrow-circle-right"></i> 
          </a>
          </div>
        </div> 
	</div> 
</div>

{{ partial("partials/footer") }}

