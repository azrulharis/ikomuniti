{{ partial("partials/navigation") }} 
    <div class="row">
        <div class="col-lg-12">
          <div class="panel panel-primary">
            <div class="panel-heading">
		     <h3 class="panel-title">iMall</h3>
		    </div>
	        <div class="panel-body imall_table">
			      <ul class="pager">
				      <li>{{ link_to("imall/index", "iMall", "class": "jun_button") }}</li> 
				      <li>{{ link_to("imall/myads", "My Ads", "class": "jun_button jun_button_current") }}</li>
					  <li>{{ link_to("imall/add", "New Ad", "class": "jun_button") }}</li>
				  </ul>
	              
				  {{content()}}
	        </div>
</div>
</div></div> 
{{ partial("partials/footer") }}