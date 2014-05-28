{{ partial("partials/navigation") }} 
<div class="row">
  <div class="col-lg-8">
          
      <div class="panel panel-primary">
          <div class="panel-heading">
		    <h3 class="panel-title">Add New iOffer</h3>
		  </div>
		  <div class="panel-body">    
		    <div class="bs-example">
			  <ul class="breadcrumb" style="margin-bottom: 5px;">
			    <li>{{ link_to("gghadmin/ioffer/index", "iOffer") }}</li>
				<li class="active">Add iOffer</li>  
			    <li>{{ link_to("gghadmin/ioffer/order", "Orders") }}</li>
			    <li>{{ link_to("gghadmin/ioffer/histories", "Histories") }}</li> 
			  </ul>
			</div>  
            <div class="alert alert-info alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <p><b>Step 1 of 3: Fill Up the Insert Ad Form</b> Make sure you fill all product detail.</p>
            </div>
            <div class="panel panel-default">
              <div class="panel-body">
                {{ content() }}   
                
            <div class="form-group">
			{{ form('gghadmin/ioffer/add', 'method': 'post') }} 
				 
				<div class="form-group"> 
					<label>Title</label>
					    {{text_field('title', 'class': 'form-control', 'size': 16, 'placeholder': 'Enter iOffer product title')}}
				 	
				</div>	
			    <div class="form-group"> 
					<label>Price RM</label>
					    {{text_field('price', 'class': 'form-control', 'size': 16, 'placeholder': '0.00')}}
				 	
				</div>
				<div class="form-group"> 
					<label>Market Price RM</label>
					    {{text_field('market_price', 'class': 'form-control', 'size': 16, 'placeholder': '0.00')}} 
				</div>  
				<div class="form-group"> 
					<label>Commission (Separate By Comma)</label>
					    {{text_field('commission', 'class': 'form-control', 'size': 16, 'placeholder': '15,10,5,10')}}
				 	
				</div> 
				<div class="form-group"> 
					<label>Total Stock</label>
					    {{text_field('stock', 'class': 'form-control', 'size': 16, 'placeholder': 'Enter product stock')}}
					 	
				</div> 
				<div class="form-group"> 
					<label>Description</label>
					    {{text_area('body', 'class': 'form-control', 'col': 40)}}
				 	
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
 
 
 
 