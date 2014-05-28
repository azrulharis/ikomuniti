{{ partial("partials/navigation") }} 
<div class="row">
  <div class="col-lg-12">
          
      <div class="panel panel-primary">
          <div class="panel-heading">
		    <h3 class="panel-title">Step Two</h3>
		  </div>
		  <div class="panel-body">    
		    <div class="alert alert-dismissable alert-info">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              Dont close or leave this page. Please enter TAC Code that we sent to your Phone to complete this transaction.
            </div>

                {{ content() }}   
                 
				{{ form('wallets/steptwo', 'method': 'post', 'class': 'form-horizontal', 'role': 'form') }} 
				   {% for recipient in recipients %}
					<div class="form-group">
					    <label class="col-sm-4">Recipient Username:</label>
					    <div class="col-sm-8">
					      <p class="form-control-static">{{ recipient.username }}</p>
					    </div>
					</div>
					<div class="form-group">
					    <label class="col-sm-4">Recipient Name:</label>
					    <div class="col-sm-8">
					      <p class="form-control-static">{{ recipient.name }}</p>
					    </div>
					</div>	
					<div class="form-group">
					    <label class="col-sm-4">Recipient Reg Number:</label>
					    <div class="col-sm-8">
					      <p class="form-control-static">{{ recipient.reg_number }}</p>
					    </div>
					</div>
					<div class="form-group">
					    <label class="col-sm-4">iPoint:</label>
					    <div class="col-sm-8">
					      <p class="form-control-static">{{ amount }}</p>
					    </div>
					</div>
					<div class="form-group">
					    <label class="col-sm-4">TAC</label>
					    <div class="col-sm-8">
					     {{text_field('tac', 'size': 60, 'class': 'form-control')}}
					    </div>
					</div>	 
					<div class="form-group">
					<label class="col-sm-4"></label>
					    <div class="col-sm-8"> 
						{{ submit_button('submit', 'name': 'submit', 'value': 'Submit', 'class': 'btn btn-primary') }}
						</div>
					</div> 
					{% endfor %}
		        </form> 
		  </div>
	  </div>
  </div>
   
</div> 


  
{{ partial("partials/footer") }}