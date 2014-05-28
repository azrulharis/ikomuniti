{{ partial("partials/navigation") }}       
{{ stylesheet_link("dist/themes/default/style.css") }} 
    {{ javascript_include("dist/jquery.jstree.js") }}
<div class="row">
	<div class="col-lg-12"> 
		{{ content()}}
		
		<div class="panel panel-success">
			<div class="panel-heading">
			<h3 class="panel-title">iTree</h3>
			</div>
			
			<div class="panel-body">
			  <div style="max-height: 680px; overflow: auto;">
			  	<ul id="tree_root_1"></ul>
			  </div>
			  <script> 
			      $(function() { 
				  $("#tree_root_1").jstree({ 
					"plugins" : ["themes", "json_data", "ui", "cookie"],
			        "json_data" : {
			            "ajax" : {
			                "type": 'GET',
			                "url": function (node) {
			                    if (node == -1) {
			                        url = "{{ urlajax }}";
			                    } else {
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
	 
</div>
 
{{ partial("partials/footer") }}