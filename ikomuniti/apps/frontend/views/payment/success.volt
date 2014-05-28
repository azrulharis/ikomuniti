{{ partial("partials/navigation") }}

<div class="row">   
	<div class="col-lg-12">
    	<div class="panel">
           <div class="panel-heading">
		     <h4>Payment Informations</h4>
		   </div>
   			<div class="panel-body"> 
   			  {{ content() }}
              <h4>Payment</h4>
              {{image('images/localbank.jpg', 'class': 'img-responsive img-thumbnail pull-left', 'style': 'margin-right:5px; max-width: 180px;')}} 
			  <p>All prices are in Ringgit Malaysia (MYR) and are subject to change without notice. You can pay using iPoint and currently accept direct payment from major bank in Malaysia including Maybank2u, CimbClicks, RHBonline, Alliance Bank, and Hong Leong Bank. You will be redirected to your preferred payment channel when you proceed to check out. </p>
			  <div class="clearfix"></div>
              <hr> 
              <h4>Delivery</h4>
              {{image('images/poslaju.jpg', 'class': 'img-responsive img-thumbnail pull-left', 'style': 'margin-right:5px; max-width: 180px;')}} 
              <p>All orders that have been paid before 2 pm will be sent to you at the same day. Orders that made on Saturday or Sunday will only be shipped on Monday of the following week. We provide both local shipping. All orders within Semenanjung Malaysia, Sabah and Sarawak are shipped using PosLaju. Poslaju is Malaysia Express Mail Service and delivers within 2 - 5 business days. Signature will be required when you received the parcel. Tracking numbers will also be provided after we have sent your parcel. </p> 
            </div>
         </div> 
    </div><!--/articles-->
</div>   
{{ partial("partials/footer") }}