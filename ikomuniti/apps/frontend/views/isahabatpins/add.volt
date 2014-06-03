<div class="jun_view_ads">
{{ partial("partials/user_left") }}
<div class="jun_right line">
  <div class="jform_post jun_view">
      <h4>iPrihatin Post</h4>
      
      <div class="bs-example">
        <ul class="breadcrumb" style="margin-bottom: 5px;">
		  {{ link_to("epins/index", "My iPin") }} 
	      {{ link_to("epins/transfer", "Transfer iPin") }} 
		  {{ link_to("epins/track", "Track") }}
		</ul>
	</div>
	  
	<div class="jun_label">
		{{ content()}}
     <h4>Generate New iPin</h4>
     {{  form('epins/index', 'method': 'post') }}
      <label>
	    <p>Count </p>{{ text_field("count", "size": 14, "placeholder": "3, 10, 100") }}
	</label>
	<label> 
	    <p>&nbsp;</p>{{ submit_button('submit', 'value': 'Generate') }}
	</label>
	</form>
  </div> 
  	
  </div>
</div>
</div>