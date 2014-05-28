{{ partial("partials/navigation") }} 
    <div class="row">
        <div class="col-lg-12">
          
      <div class="panel panel-primary">
        <div class="panel-heading">
		  <h3 class="panel-title">iPin informations</h3>
		</div>
	  <div class="panel-body">
	  
	  <div class="bs-example">
        <ul class="breadcrumb" style="margin-bottom: 5px;">
	    <li>{{ link_to("epins/index", "My iPin") }}</li> 
	    <li class="active">Transfer iPin</li>
	    <li>{{ link_to("epins/track", "Track") }}</li>
	  </ul>
	  </div>
		 
		 
		 <div class="form-group">
			{{ content() }}
			{% if hide == 0 %}
			{{  form('epins/transfer', 'method': 'post') }} 
			<div class="form-group">
	        <label>iPin Total</label> {{ text_field("count", "class": "form-control", "size": 24) }}
			</div>
			<div class="form-group">
			<label>Recipient Username </label>{{ text_field("username", "class": "form-control", "size": 24, "id": "username") }}
			</div>
			<div class="form-group">
			<label>Transaction Code </label>{{ password_field("master_key", "class": "form-control", "size": 24) }}
			</div>
			<div class="form-group">
			 {{ submit_button('submit', 'value': 'Next Step', 'class': 'btn btn-primary') }} 
			 </div>
			</form> 
			{% endif %}
	    </div>
</div>
	  </div>
</div></div> 
{{ partial("partials/footer") }}