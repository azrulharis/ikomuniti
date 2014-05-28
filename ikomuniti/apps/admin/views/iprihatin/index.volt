

{{ partial("partials/navigation") }}
<div class="row">
    <div class="col-lg-12"> 
        {{ content()}}
    	<div class="panel panel-primary">
           <div class="panel-heading">iPrihatin</div>
   			<div class="panel-body"> 
   			
   			{{ link_to("gghadmin/iprihatin/index", "iPrihatin", "class": "btn btn-primary") }}
				  {{ link_to("gghadmin/iprihatin/add", "New Post", "class": "btn btn-success") }}
              {% for iprihatin in iprihatins %} 
               
	              <div class="clearfix"></div>
	              <h4>{{link_to("gghadmin/iprihatin/view/" ~ iprihatin.slug, iprihatin.title)}} </h4>
	              </p><span class="fa fa-clock-o"></span> {{iprihatin.created}}</p> 
	              <p>{{iprihatin.body}}</p>
	              {{ link_to("gghadmin/iprihatin/edit/" ~ iprihatin.slug, "Edit", "class": "btn btn-primary") }} &nbsp;
				   {{ link_to("gghadmin/iprihatin/delete/" ~ iprihatin.slug, "Delete", "class": "btn btn-danger") }}
	              <div class="clearfix"></div><hr>
               
              {% endfor %}
            </div>
            
        </div> 
    </div> 
</div>
<div class="row">
    <div class="col-lg-12">  
	    {{ paginationUrl }} 
    </div>
</div>
{{ partial("partials/footer") }}