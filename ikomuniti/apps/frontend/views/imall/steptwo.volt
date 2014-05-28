{{ partial("partials/navigation") }} 
<div class="row">
	<div class="col-lg-12">  
  		<div class="panel-body">
		    {{ link_to('imall/index', '<i class="fa fa-plus"></i> My Ads', 'class': 'btn btn-primary') }}  
			{{ link_to('imall/add', '<i class="fa fa-plus"></i> Post On iMall', 'class': 'btn btn-success') }} 
	    </div>
	</div>
</div>
<div class="row">
  <div class="col-lg-8">
          
      <div class="panel panel-primary"> 
		  <div class="panel-body">    
            <div class="alert alert-info alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <p><b>Step 2 of 3: Fill Up the Title and Description</b> Your ad will be reviewed according to the rules of iMall. After approval, it will be published for a period of 90 days. Please post your ads in the correct category. iMall reserves the right to edit or remove images or content that do not follow the rules and regulations.</p>
            </div>
            <div class="panel panel-default">
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
			    <label>Ad Type: </label>
			        {% if type == 1 %} 
					    For sale
					{% elseif type == 2 %}
					    For Rent
					{% elseif type == 3 %}
					    Wanted
					{% elseif type == 4 %}
					    Wanted To Rent
					{% endif %}
			  </div>
			  {% if type == 1 %}
			  <div class="form-group"> 
					<label>Price RM <span class="red">*</span></label>
					{{text_field('price', 'class': 'form-control', 'size': 16, 'placeholder': '0.00')}}
			  </div> 	
			  <div class="form-group">
			    <label>Item Condition <span class="red">*</span></label>
					    <select name="item_condition" class="form-control">
						<option value="0">Item Condition</option>
						<option value="New">New</option>
						<option value="Used">Used</option>
						</select>
			   </div>	
			   {% endif %}
				
				<div class="form-group">
				<label>Item Location <span class="red">*</span></label>
				  {{text_field('location', 'size': 60, 'class': 'form-control', 'placeholder': 'Petaling Jaya')}}
				</div>
				<div class="form-group">
				<label>Title <span class="red">*</span></label>
				  {{text_field('title', 'size': 60, 'class': 'form-control', 'placeholder': 'Proton Preve Turbo 2013 Auto')}}
				</div>
				<div class="form-group">
				<label>Description<span class="red">*</span></label>
				  {{text_area('body', 'class': 'form-control', 'cols': 40)}}
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
   
 
  <div class="col-lg-4">
    <h4>Rules on iMall</h4>
   <div class="bs-example">
      <div class="list-group">
        <a href="#" class="list-group-item">
          <h4 class="list-group-item-heading">Description</h4>
          <p class="list-group-item-text">The ad heading has to describe the item or the service advertised, no company names or urls are allowed. No unnecessary characters are allowed in the heading. The item or service has to be described in the ad text, it is not allowed to merely link to another page. Ad texts are not allowed to be copied from other advertisers, these are protected under copyright laws. It&#39;s not allowed to use search words or keywords in the ad text. Only ads in Bahasa Malaysia and English are allowed.</p>
        </a>
        <a href="#" class="list-group-item">
          <h4 class="list-group-item-heading">Solely marketing</h4>
          <p class="list-group-item-text">It&#39;s only allowed to advertise sales, rentals, jobs and services. To use the ad for pure marketing purposes, i.e. not offering any concrete goods, jobs or services, is not allowed.</p>
        </a>
        <a href="#" class="list-group-item">
          <h4 class="list-group-item-heading">Categorising</h4>
          <p class="list-group-item-text">The ad has to be placed in the category that describes the item or service the best (the ad will be moved to the right category when possible). Good and services that do not fit in the same category must be placed in separate ads. For sale-ads have to placed under &#34;For sale&#34; and wanted-ads under "Wanted to buy". &#34;To let&#34; and "Wanted to rent" are available under certain categories. In other categories, to let-ads should be placed under "For Sale" and wanted to rent-ads under &#34;Wanted&#34;.</p>
        </a>
        <!--
        <a href="#" class="list-group-item">
          <h4 class="list-group-item-heading">No multiple items in 1 ad</h4>
          <p class="list-group-item-text">You are required to place only one property or vehicle per ad. We would therefore like to advise you to divide your properties or vehicles and place them in separate ads.</p>
        </a>
        <a href="#" class="list-group-item">
          <h4 class="list-group-item-heading">No duplicates</h4>
          <p class="list-group-item-text">It is not allowed to place ads with the same item, service or job more than once. Delete the old ad before you place the new one. Consequently, it&#39;s not allowed to place ads with the same items, services or jobs in different categories or regions.</p>
        </a>
        
        <a href="#" class="list-group-item">
          <h4 class="list-group-item-heading">Links</h4>
          <p class="list-group-item-text">Links in the ad have to be relevant to the item or service advertised. Same general rules for the ad applies also for the link. It is not allowed to link to another auction or classified site.</p>
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
	          <li>Image was downloaded from Mudah.my website.</li>
	          <li>Image not clear.Image was reused from previous ad.</li> 
	        </ol>

        </a>
         -->
      </div>
    </div>

  </div>
</div>
{{ partial("partials/footer") }}