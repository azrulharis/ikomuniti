{{ partial("partials/navigation") }} 
<div class="row">
  <div class="col-lg-12">
          
      <div class="panel panel-primary">
          <div class="panel-heading">
		    <h3 class="panel-title">Transfer iPoint</h3>
		  </div>
		  <div class="panel-body">    
		    <div class="bs-example">
              <ul class="breadcrumb" style="margin-bottom: 5px;">
                <li>{{ link_to("wallets/index", "iPoint", "class": "jun_button") }}</li> 
				<li>{{ link_to("wallets/histories", "History", "class": "jun_button") }}</li> 
				<li>{{ link_to("wallets/redeem", "Withdraw", "class": "jun_button") }}</li> 
				<li>{{ link_to("wallets/status", "Withdrawal Status", "class": "jun_button") }}</li>
                <li class="active">Transfer</li>
              </ul>
            </div>
             
            <div class="panel panel-default">
              <div class="panel-body">
                {{ content() }}   
                
            <div class="form-group">
			    {{ form('wallets/transfer', 'method': 'post') }} 
			   
				<div class="form-group">
				<label>Recipient Username</label>
				    {{text_field('recipient_username', 'class': 'form-control', 'placeholder': 'username')}}	 
				</div>
				<div class="form-group"> 
				<label>Remark</label>
				     {{text_area('remark', 'class': 'form-control', 'placeholder': 'Enter your remark')}}
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
		           </form>
		         </div>
              </div>
            </div>
		  </div>
	  </div>
  </div>
   
</div> 


  
{{ partial("partials/footer") }}