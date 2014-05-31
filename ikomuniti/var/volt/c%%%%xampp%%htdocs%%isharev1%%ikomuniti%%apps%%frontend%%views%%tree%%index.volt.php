<?php echo $this->partial('partials/navigation'); ?>       
<?php echo $this->tag->stylesheetLink('dist/themes/default/style.css'); ?> 
    <?php echo $this->tag->javascriptInclude('dist/jquery.jstree.js'); ?>
<div class="row">
	<div class="col-lg-12"> 
		<?php echo $this->getContent(); ?>
		
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
			                        url = "<?php echo $urlajax; ?>";
			                    } else {
			                        nodeId = node.attr('id');
			                        url = "<?php echo $ajaxurlsecond; ?>?id=" + nodeId;
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
 
<?php echo $this->partial('partials/footer'); ?>