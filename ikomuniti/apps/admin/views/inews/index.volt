{{ partial("partials/navigation") }} 
<div class="row">
{{ content()}}
  <div class="col-lg-6">
	  <div class="panel panel-primary">
	    <div class="panel-heading">
		  <h4 class="panel-title">iNews</h4>
		</div>
	      <div class="panel-body">  
      		
		    <div class="table-responsive">
		      <table class="table table-bordered table-hover table-striped tablesorter"> 
			     
				{% for inews in news %}
				<tr>
				    
					<td><p>{{ link_to('gghadmin/inews/view/'~inews.slug, inews.title) }}</p></td>
					<td><p>{{inews.body}}</p></td>
					<td><p>{{inews.created}}</p></td>  
				</tr>
				{% endfor %}
				</table>
			</div> 
		  </div>
		</div>
	</div>
	<div class="col-lg-6">
	  <div class="panel panel-primary">
	    <div class="panel-heading">
		  <h4 class="panel-title">Add iNews</h4>
		</div>
	      <div class="panel-body">  
	        <form action="" method="POST">
      		 <div class="form-group">
      		   <label>Title</label>
      		   <input type="text" name="title" class="form-control">
      		 </div>
      		 <div class="form-group">
      		   <label>Visibility</label>
      		   <select name="visible" class="form-control">
      		       <option value="">Select</option>
      		       <option value="0">Display to login users</option>
      		       <option value="1">Display iNews to public</option>
      		       </select>
      		 </div>
      		 <div class="form-group">
      		   <label>News</label>
      		   <textarea name="body" class="form-control"></textarea>
      		 </div>
      		 <div class="form-group"> 
      		   <input type="submit" name="submit" value="Publish" class="btn btn-primary">
      		 </div>
      		 </form>
		  </div>
		</div>
	</div>
</div>
<div class="row">
   <div class="col-lg-12">
	{{ paginationUrl }}
  </div>
</div> 
{{ partial("partials/footer") }}