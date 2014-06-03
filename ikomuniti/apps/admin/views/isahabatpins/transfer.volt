<script type="text/javascript">
$(document).ready(function()
{
    $('#username').autocomplete(
    {
        source: "{{urlajax}}",
        minLength: 2
    });
});
</script>
{{ partial("partials/navigation") }} 
    <div class="row">
        <div class="col-lg-12">
          
      <div class="panel panel-primary">
        <div class="panel-heading">
		  <h3 class="panel-title">Transfer iSahabat iPin</h3>
		</div>
		  <div class="panel-body">  
			<div class="bs-example">
			  <ul class="breadcrumb" style="margin-bottom: 5px;">
			    <li>{{ link_to("gghadmin/isahabatpins/index", "iSahabat iPin") }}</li>
				<li>{{ link_to("gghadmin/isahabatpins/add", "Add iSahabat iPin") }}</li>
			    <li class="active">Transfer iSahabat iPin</li>
			    <li>{{ link_to("gghadmin/isahabatpins/viewuseripin", "View iSahabat iPin") }}</li>
			    <li>{{ link_to("gghadmin/isahabatpins/track", "Track") }}</li> 
			  </ul>
			</div>
			
		{{ content()}}
        {% if hide == 0 %}
        {{  form('gghadmin/isahabatpins/transfer', 'method': 'post') }} 
        
		<div class="form-group">
            <label>Jumlah iPin</label>{{ text_field("count", "class": "form-control") }}
		</div>
		
		<div class="form-group"> 
		    <label>Username penerima</label>{{ text_field("username", "id": "username", "class": "form-control") }}
		</div>
		
		<div class="form-group"> 
		    <label>Kod Transaksi</label>{{ password_field("master_key", "class": "form-control") }}
		</div>
		
		<div class="form-group"> 
		    {{ submit_button('submit', 'value': 'Langkah Seterusnya', 'class': 'btn btn-primary') }}
		 </div>
		</form>
		{% endif %}
 </div>
   
	</div>
    </div>
  </div>
</div> 
 

{{ partial("partials/footer") }}