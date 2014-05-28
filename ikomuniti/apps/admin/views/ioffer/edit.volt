{{ partial("partials/navigation") }} 
<div class="row">
  <div class="col-lg-8">
          
      <div class="panel panel-primary">
          <div class="panel-heading">
		    <h3 class="panel-title">Edit iOffer</h3>
		  </div>
		  <div class="panel-body">    
		    <div class="bs-example">
			  <ul class="breadcrumb" style="margin-bottom: 5px;">
			    <li>{{ link_to("gghadmin/ioffer/index", "iOffer") }}</li>
				<li class="active">Edit iOffer</li>  
			    <li>{{ link_to("gghadmin/ioffer/order", "Orders") }}</li>
			    <li>{{ link_to("gghadmin/ioffer/histories", "Histories") }}</li> 
			  </ul>
			</div>  
            
            <div class="panel panel-default">
              <div class="panel-body">
                {{ content() }}   
                
            <div class="form-group">
			{% for post in posts %}	
			{{ form('gghadmin/ioffer/edit/'~post.id, 'method': 'post') }} 
			 
				<div class="form-group"> 
					<label>Title</label>
					    {{text_field('title', 'class': 'form-control', 'size': 16, 'value': post.title)}}
				 	
				</div>	
			    <div class="form-group"> 
					<label>Price RM</label>
					    {{text_field('price', 'class': 'form-control', 'size': 16, 'value': post.price)}}
				 	
				</div> 
				<div class="form-group"> 
					<label>Total Stock</label>
					    {{text_field('stock', 'class': 'form-control', 'size': 16, 'value': post.stock)}}
					 	
				</div> 
				<div class="form-group"> 
					<label>Description</label>
					    {{text_area('body', 'class': 'form-control', 'col': 40, 'value': post.body)}}
				 	
				</div> 
				 
				<div class="form-group">
				    {{ submit_button('submit', 'value': 'Save', 'class': 'btn btn-primary') }}
				 </div>
			  
		      </form>
			  {% endfor %}
		         </div>
              </div>
            </div>
		  </div>
	  </div>
  </div>
</div> 
{{ partial("partials/footer") }}
 
 
 
 