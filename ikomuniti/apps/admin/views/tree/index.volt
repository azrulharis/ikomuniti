{{ partial("partials/navigation") }}       
{{ stylesheet_link("dist/themes/default/style.css") }} 
    {{ javascript_include("dist/jquery.jstree.js") }}
<div class="row">
	<div class="col-lg-8"> 
		{{ content()}}
		
		<div class="panel panel-success">
			<div class="panel-heading">
			<h3 class="panel-title">iTree</h3>
			</div>
			
			<div class="panel-body">
			  <h4>admin</h4>
			  <ul id="tree_root_1"></ul>
			  <script>
			      $(function() {

				  $("#tree_root_1").jstree({ 
					"plugins" : ["themes", "json_data", "ui", "cookie"],
			        "json_data" : {
			            "ajax" : {
			                "type": 'GET',
			                "url": function (node) {
			                    
			                    if (node == -1)
			                    {
			                        url = "{{ urlajax }}";
			                    }
			                    else
			                    {
			                        nodeId = node.attr('id');
			                        url = "{{ajaxurlsecond}}?id=" + nodeId;
			                    }
			
			                    return url;
			                },
			                "success": function (new_data) {
			                    return new_data;
			                }
			            }
			        } 
			        
			    });
			    });
		 
			    </script>
			</div>
		</div>
		  
	</div>
 
	<div class="col-lg-4"> 
		 <div class="bs-example wgreen">
          <div class="list-group">
            <a href="/ishare/isharephal/news/index" class="list-group-item active">
              <i class="glyphicon glyphicon-info-sign"></i>  
            </a> 
            <a href="/ishare/isharephal/news/view/" class="list-group-item"><h4></h4>
			<p class="list-group-item-text"></p>
			</a>  
            <a href="/ishare/isharephal/news/index" class="list-group-item"> 
                  <i class="fa fa-arrow-circle-right"></i> 
          </a>
          </div>
        </div> 
	</div>
</div>
 
{{ partial("partials/footer") }}