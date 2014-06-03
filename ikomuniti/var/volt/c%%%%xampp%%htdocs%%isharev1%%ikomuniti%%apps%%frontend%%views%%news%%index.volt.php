<?php echo $this->partial('partials/navigation'); ?> 
<div class="row">
  <div class="col-lg-12">
	  <div class="panel panel-primary">
	    <div class="panel-heading">
		  <h3 class="panel-title">iNews</h3>
		</div>
	      <div class="panel-body">  
      		<?php echo $this->getContent(); ?>
		    <div class="table-responsive">
		      <table class="table table-bordered table-hover table-striped tablesorter"> 
			     
				<?php foreach ($news as $inews) { ?>
				<tr>
				    
					<td><p><?php echo $this->tag->linkTo(array('news/view/' . $inews->slug, $inews->title)); ?></p></td>
					<td><p><?php echo $inews->body; ?></p></td>
					<td><p><?php echo $inews->created; ?></p></td> 
					<td><p><?php echo $this->tag->linkTo(array('news/view/' . $inews->slug, 'View', 'class' => 'btn btn-primary')); ?></p></td> 
				</tr>
				<?php } ?>
				</table>
			</div> 
		  </div>
		</div>
	</div>
</div>
<div class="row">
   <div class="col-lg-12">
	<?php echo $paginationUrl; ?>
  </div>
</div> 
<?php echo $this->partial('partials/footer'); ?>