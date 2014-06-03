<?php echo $this->partial('partials/navigation'); ?> 
<div class="row">
	<div class="col-lg-12">  
  		<div class="panel-body">
		    <?php echo $this->tag->linkTo(array('ipartner/index', '<i class="fa fa-plus"></i> My iPartner', 'class' => 'btn btn-primary')); ?>  
			<?php echo $this->tag->linkTo(array('ipartner/add', '<i class="fa fa-plus"></i> Post New iPartner', 'class' => 'btn btn-success')); ?> 
	    </div>
	</div>
</div>
<div class="row">
  <div class="col-lg-12"> 
      <div class="panel panel-primary">  
		  <div class="panel-body">    
            <div class="alert alert-info alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <p><b>Step 1 of 3: Fill Up the Insert Ad Form</b>Your ad will be reviewed according to the rules of iPartner. Please post your ads in the correct category. iPartner reserves the right to edit or remove images or content that do not follow the rules and regulations.</p>
            </div>
            <div class="panel panel-default">
              <div class="panel-body">
                <?php echo $this->getContent(); ?>   
                
            <div class="form-group">
			<?php echo $this->tag->form(array('ipartner/add', 'method' => 'post')); ?> 
				<div class="form-group">
				<label>Region</label>
					<select name="region_id" class="form-control" id="selectregion">
					<option value="0">Select Region</option>				
					<?php foreach ($regions as $region) { ?>
					    <option value="<?php echo $region->id; ?>"><?php echo $region->name; ?></option>
					<?php } ?>
					</select>
				</div>
				<div class="form-group"> 
				<label>Category</label>
				    <select name="category_id" class="form-control" id="category"> 
					    <option value="0">Select Categories</option>
					    <?php foreach ($categories as $category) { ?>
					        <option value="<?php echo $category->id; ?>" <?php if ($category->type == 1) { ?>class="jun_select_parent" value=""disabled<?php } ?>><?php echo $category->name; ?></option>
					    <?php } ?>
					</select>
				</div>	
				 
				<div class="form-group">
				    <?php echo $this->tag->submitButton(array('submit', 'value' => 'Next Step', 'class' => 'btn btn-primary')); ?>
				 </div>
		           </form>
		         </div>
              </div>
            </div>
		  </div>
	  </div>
  </div>
</div> 
<?php echo $this->partial('partials/footer'); ?>
 
 
 
 