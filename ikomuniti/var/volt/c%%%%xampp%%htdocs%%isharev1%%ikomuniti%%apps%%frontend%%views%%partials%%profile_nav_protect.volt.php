<?php echo $this->tag->stylesheetLink('css/profile.css'); ?>
<?php foreach ($navigations as $nav) { ?>
<div id="wrapper">
      <!-- Sidebar -->
      <nav class="navbar navbar-default navbar-fixed-top" role="navigation"> 
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <?php echo $this->tag->linkTo(array('index', $this->tag->image(array('images/logo.png')), 'class' => 'navbar-brand')); ?>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse jun_line">
        

          <ul class="nav navbar-nav navbar-right navbar-user">
            <li class="dropdown messages-dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> Messages <?php if ($count_inbox > 0) { ?><span class="badge badge-error"><?php echo $count_inbox; ?></span><?php } ?> <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li class="dropdown-header"><?php if ($count_inbox > 0) { ?> <?php echo $count_inbox; ?> New Messages <?php } ?></li>
                
                <?php foreach ($messages_nav as $msg) { ?> 
				<li class="message-preview">
	              <a href="<?php echo $path; ?>messages/view/<?php if ($msg->message_id == 0) { ?><?php echo $msg->m_id; ?><?php } else { ?><?php echo $msg->message_id; ?><?php } ?>">
	                <span class="avatar"><img src="http://placehold.it/50x50"></span>
	                <span class="name"><?php echo $this->escaper->escapeHtml($msg->from_username); ?>:</span>
	                <span class="message"><?php echo $this->escaper->escapeHtml($msg->body); ?>...</span>
	                <span class="time"><i class="fa fa-clock-o"></i> <?php echo $msg->time; ?> <?php echo $msg->created; ?></span>
	              </a>
	            </li>
	            <li class="divider"></li> 
			    <?php } ?>
			    
                <li><?php echo $this->tag->linkTo(array('messages/index', 'View iMail <span class=\'badge\'>' . $count_inbox . '</span>')); ?></li>   
              </ul>
            </li>
            <li class="dropdown alerts-dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> Notification <?php if ($count_notification > 0) { ?><span class="badge badge-error"><?php echo $count_notification; ?></span><?php } ?> <b class="caret"></b></a>
              <ul class="dropdown-menu">
              <?php foreach ($notifications_nav as $notificate) { ?> 
                <li><?php echo $this->tag->linkTo(array('notifications/view/' . $notificate->id, '<span class=\'label label-info\'>' . $this->escaper->escapeHtml($notificate->body) . '</span>')); ?></li> 
              <?php } ?>
                <li class="divider"></li>
                <li><?php echo $this->tag->linkTo(array('notifications/index', 'View All')); ?></li>
              </ul>
            </li>
            
            <li class="dropdown user-dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $nav->username; ?> <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#"><i class="fa fa-user"></i> Profile</a></li> 
                <li class="divider"></li>
                <li><?php echo $this->tag->linkTo(array('users/logout', '<i class=\'fa fa-power-off\'></i> Log Out')); ?></li>
              </ul>
            </li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </nav>
<?php } ?>
 <div class="profile_container">
