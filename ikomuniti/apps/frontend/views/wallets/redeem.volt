{{ partial("partials/navigation") }} 
<div class="row">
  <div class="col-lg-12">
          
      <div class="panel panel-primary">
          <div class="panel-heading">
		    <h3 class="panel-title">Withdraw iPoint</h3>
		  </div>
		  <div class="panel-body">    
		    <div class="bs-example">
              <ul class="breadcrumb" style="margin-bottom: 5px;">
                <li>{{ link_to("wallets/index", "iPoint", "class": "jun_button") }}</li> 
				<li>{{ link_to("wallets/histories", "History", "class": "jun_button") }}</li> 
                <li class="active">Withdraw</li>
                <li>{{ link_to("wallets/status", "Withdrawal Status", "class": "jun_button") }}</li>
                <li>{{ link_to("wallets/transfer", "Transfer", "class": "jun_button") }}</li>
              </ul>
            </div>
            <div class="alert alert-danger alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <p><b>Attention!, You are not allow to redeem iPoint if your current balance below insurance amount.</p>
            </div>
            <div class="panel panel-default">
              <div class="panel-body">
                {{ content() }}   
                
            <div class="form-group">
			{{ form('wallets/redeem', 'method': 'post') }} 
			  {% for user in users %}
				<div class="form-group">
				<label>Bank Name</label>
				    {{text_field('bank_name', 'value': user.bank_name, 'class': 'form-control', 'placeholder': 'Maybank/Cimb/Etc')}}	 
				</div>
				<div class="form-group"> 
				<label>Account Number</label>
				     {{text_field('account_number', 'value': user.bank_number, 'class': 'form-control', 'placeholder': '245346357353')}}
				</div>	
				<div class="form-group"> 
				<label>iPoint</label>
				     {{text_field('amount', 'size': 60, 'class': 'form-control', 'placeholder': '0.00')}}
				     {{hidden_field('DB8R4HAW4XB7Y8LMP6', 'value': csrfToken)}}
				</div>
				<div class="form-group"> 
				<label>Password</label>
				     {{password_field('password', 'size': 60, 'class': 'form-control')}}
				</div>		
			    <div class="form-group"> 
				<label>Transaction Password</label>
				     {{password_field('transaction_password', 'size': 60, 'class': 'form-control')}}
				</div> 
				<div class="form-group">
				    {{ submit_button('submit', 'value': 'Next Step', 'class': 'btn btn-primary') }}
				 </div>
			  {% endfor %}
		           </form>
		         </div>
              </div>
            </div>
		  </div>
	  </div>
  </div>
  
  <div class="col-lg-4">
  
  </div>
</div> 


  
{{ partial("partials/footer") }}