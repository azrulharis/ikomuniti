{{ partial("partials/navigation") }} 
<div class="row">
	<div class="col-lg-12">  
  		<div class="panel-body">
		    {{ link_to('ipartner/index', '<i class="fa fa-plus"></i> My iPartner', 'class': 'btn btn-primary') }}  
			{{ link_to('ipartner/add', '<i class="fa fa-plus"></i> Post New iPartner', 'class': 'btn btn-success') }} 
	    </div>
	</div>
</div>
<div class="row">
  <div class="col-lg-12"> 
      <div class="panel panel-primary">  
		  <div class="panel-body">    
            <div class="alert alert-info alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <p><b>Step 1 of 3: Fill Up the Insert Ad Form</b>Your ad will be reviewed according to the rules of iPartner. Please post your ads in the correct category. iPartner reserves the right to edit or remove images or content that do not follow the rules and regulations.</p>
            </div>
            <div class="panel panel-default">
              <div class="panel-body">
                {{ content() }}   
                
            <div class="form-group">
			{{ form('ipartner/add', 'method': 'post') }} 
				<div class="form-group">
				<label>Region</label>
					<select name="region_id" class="form-control" id="selectregion">
					<option value="0">Select Region</option>				
					{% for region in regions %}
					    <option value="{{ region.id }}">{{region.name}}</option>
					{% endfor %}
					</select>
				</div>
				<div class="form-group"> 
				<label>Category</label>
				    <select name="category_id" class="form-control" id="category"> 
					    <option value="0">Select Categories</option>
					    {% for category in categories %}
					        <option value="{{ category.id }}" {%if category.type == 1 %}class="jun_select_parent" value=""disabled{% endif %}>{{category.name}}</option>
					    {% endfor %}
					</select>
				</div>	
				 
				<div class="form-group">
				    {{ submit_button('submit', 'value': 'Next Step', 'class': 'btn btn-primary') }}
				 </div>
		           </form>
		         </div>
              </div>
            </div>
		  </div>
	  </div>
  </div>
</div> 
{{ partial("partials/footer") }}
 
 
 
 