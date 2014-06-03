<?php echo $this->partial('partials/navigation'); ?>
<div class="row">
    <div class="col-lg-12">
        <?php echo $this->getContent(); ?>
    </div>
</div>
<div class="row">
   <div class="col-lg-6">  
    	<div class="panel panel-primary">
          <div class="panel-heading">
		    <h3 class="panel-title">iMail Inbox</h3>
		  </div>
		  <div class="panel-body">
              <?php echo $this->tag->image(array('glyphicons/png/glyphicons_122_message_in.png', 'class' => 'img-circle pull-right')); ?> <?php echo $this->tag->linkTo(array('messages/index', 'Inbox')); ?>
              <div class="clearfix"></div>
               <?php foreach ($messages as $message) { ?>
              <hr>
              <div <?php if ($user_id == $message->to_id) { ?><?php if ($message->is_read == 0) { ?>class="panel panel-warning" style="background: #F3E2EA"<?php } ?><?php } ?>>
	              <div class="clearfix"></div>
	              <p>
				  <?php if ($user_id != $message->to_id) { ?>
				  <?php echo $this->tag->linkTo(array('profile/' . $message->to_username, $this->tag->image(array('uploads/profiles/' . $message->to_image, 'class' => 'img-responsive img-thumbnail pull-left', 'style' => 'margin-right:5px; width: 60px;')) . '<b>' . $message->to_username . '</b>')); ?> 
				  <?php } else { ?>
				  <?php echo $this->tag->linkTo(array('profile/' . $message->username, $this->tag->image(array('uploads/profiles/' . $message->image, 'class' => 'img-responsive img-thumbnail pull-left', 'style' => 'margin-right:5px; width: 60px;')) . '<b>' . $message->username . '</b>')); ?>
				  <?php } ?>
	              <span class="fa fa-clock-o"></span> <?php echo $message->created . ' ' . $message->time; ?></p> 
	              <?php if ($message->message_id == 0) { ?>
				      <p><?php echo $this->tag->linkTo(array('messages/view/' . $message->m_id, $message->body)); ?>... </p>
				  <?php } else { ?>
				      <p><?php echo $this->tag->linkTo(array('messages/view/' . $message->message_id, $message->body)); ?>... </p>
				  <?php } ?>
	              <div class="clearfix"></div>
              </div>
              <?php } ?>
            </div>
            
        </div> 
    </div>    
	
	
	<div class="col-lg-6">
          
      <div class="panel panel-primary">
          <div class="panel-heading">
		    <h3 class="panel-title">Compose iMail</h3>
		  </div>
		  <div class="panel-body">    
		     
            
            <div class="panel panel-default">
              <div class="panel-body"> 
                
            <div class="form-group">
			<?php echo $this->tag->form(array('messages/index', 'method' => 'post')); ?> 
				<div class="form-group">
				<label>iKomuniti Username</label>
					<input type="text" name="username" class="form-control" value="<?php echo $ref_username; ?>">
				</div>
				<div class="form-group"> 
				<label>Message</label>
				    <textarea name="message" class="form-control"></textarea>
				</div>	
				 
				<div class="form-group">
				    <?php echo $this->tag->submitButton(array('submit', 'value' => 'Send', 'class' => 'btn btn-primary')); ?>
				 </div>
		           </form>
		         </div>
              </div>
            </div>
		  </div>
	  </div>
  </div>
    
</div>
<div class="row">
    <div class="col-lg-8">  
	    <?php echo $paginationUrl; ?> 
    </div>
</div>
<?php echo $this->partial('partials/footer'); ?>