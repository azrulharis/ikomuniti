{{ partial("partials/navigation") }} 
<div class="row">
  <div class="col-lg-8"> 
      <div class="panel panel-primary"> 
		  <div class="panel-body">  
            <div class="alert alert-info alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <p><b>Step 2 of 3: Fill Up the Title and Description</b> Your ad will be reviewed according to the rules of iMall. After approval, it will be published for a period of 90 days. Please post your ads in the correct category. iMall reserves the right to edit or remove images or content that do not follow the rules and regulations.</p>
            </div> 
              <div class="panel-body">
                {{ content() }}   
			<form method="post" action="" enctype="multipart/form-data">
			  <div class="form-group"> 
				<label>Region: </label>
				    {% for region in regions %}
						{{ region.name }}
					{% endfor %}
			  </div>
			  <div class="form-group">	
				<label>Category: </label>
				    {% for category in categories %}
				        {{category.name}}
					{% endfor %}
			 </div>		
			  
			  <div class="form-group"> 
					<label>Discount for iKomuniti(RM / %)</label>
					{{text_field('discount', 'class': 'form-control', 'size': 16, 'placeholder': 'Price or Percent')}}
			  </div> 
				<div class="form-group">
					<label>Business Name <span class="red">*</span></label>
				  	{{text_field('title', 'size': 60, 'class': 'form-control', 'placeholder': 'Kedai Makan Mak Limah')}}
				</div>
				<div class="form-group">
					<label>Business Address <span class="red">*</span></label>
				  	{{text_field('address_one', 'size': 60, 'class': 'form-control', 'placeholder': 'No 38-1, Jalan 7/7B')}}
				</div>
				<div class="form-group">
					<label>Business Address Line 2</label>
					  {{text_field('address_two', 'size': 60, 'class': 'form-control', 'placeholder': 'Seksyen 7')}}
				</div>
				<div class="form-group">
					<label>City</label>
					  {{text_field('city', 'size': 60, 'class': 'form-control', 'placeholder': 'Bandar Baru Bangi')}}
				</div>
				<div class="form-group">
				<label>Postcode <span class="red">*</span></label>
				  	{{text_field('postcode', 'size': 60, 'class': 'form-control', 'placeholder': '43650')}}
				</div>
				
				<div class="form-group">
				<label>Description<span class="red">*</span></label>
				  {{text_area('body', 'class': 'form-control', 'cols': 40)}}
				</div>
				
				<div class="form-group">
				<label>Image (Optional)</label><input type="file" name="ImageFile"/> 
				</div>
				 
				 
				<div class="form-group">
				 {{ submit_button('submit', 'value': 'Next Step', 'class': 'btn btn-primary') }}
				 </div>
		        </form>
              </div>
            </div>
		  </div>
	  </div> 
  <div class="col-lg-4"> 
   <div class="bs-example">
      <div class="list-group">
        <a href="#" class="list-group-item">
          <h4 class="list-group-item-heading">Description</h4>
          <p class="list-group-item-text">The ad heading has to describe the item or the service advertised, no company names or urls are allowed. No unnecessary characters are allowed in the heading. The item or service has to be described in the ad text, it is not allowed to merely link to another page. Ad texts are not allowed to be copied from other advertisers, these are protected under copyright laws.</p>
        </a> 
        <a href="#" class="list-group-item">
          <h4 class="list-group-item-heading">No duplicates</h4>
          <p class="list-group-item-text">It is not allowed to place ads with the same item, service or job more than once. Delete the old ad before you place the new one. Consequently, it&#39;s not allowed to place ads with the same items, services or jobs in different categories or regions.</p>
        </a>
        
        <a href="#" class="list-group-item">
          <h4 class="list-group-item-heading">Images</h4>
          <p class="list-group-item-text">Images in the ad have to be relevant to the item or service advertised. Company logotypes are prohibited as images except for categories &#34;Services&#34;, &#34;Jobs&#34; and &#34;Businesses for Sale&#34;. It is not allowed to use images from other advertisers without consent. These are protected under copyright laws. Images showing models displaying underwear or bathing wear are not allowed.</p>
          <p class="list-group-item-text">Image content are not suitable such as:</p>
          <ol>
	          <li>Image too small.m</li>
	          <li>Image contain Watermark (with username, company name, email address, telephone number, link of logo)</li>
	          <li>Image not clear.</li>
	          <li>Not suitable image.</li>
	          <li>Image is not JPEG format.</li> 
	          <li>Image not clear.Image was reused from previous ad.</li> 
	        </ol>

        </a>
         </div>
      </div>
    </div> 
</div>
{{ partial("partials/footer") }}