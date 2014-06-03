 
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
          <ul class="nav navbar-nav side-nav">
            <li><a href="<?php echo $path; ?>index"><i class="fa fa-home"></i> iDashboard</a></li> 
            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-usd"></i> iPoint <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo $path; ?>wallets/index"><i class="fa fa-money"></i> iPoint Balance</a></li>
                <li><a href="<?php echo $path; ?>wallets/histories"><i class="fa fa-bars"></i> Transaction History</a></li> 
                <li><a href="<?php echo $path; ?>wallets/redeem"><i class="fa fa-level-down"></i> Withdraw iPoint</a></li>
                <li><a href="<?php echo $path; ?>wallets/status"><i class="fa fa-random"></i> Withdrawal Status</a></li>
				<li><a href="<?php echo $path; ?>wallets/transfer"><i class="fa fa-exchange"></i> Transfer iPoint</a></li> 
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bookmark"></i> iAds <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo $path; ?>iprihatin/index"><i class="fa fa-wheelchair"></i> iPrihatin</a></li>
				<li><a href="<?php echo $path; ?>imall/index"><i class="fa fa-shopping-cart"></i> iMall</a></li>
                <li><a href="<?php echo $path; ?>ipartner/index"><i class="fa fa-tag"></i> iPartner</a></li>  
                <li><a href="<?php echo $path; ?>ioffer/index"><i class="fa fa-tags"></i> iOffer</a></li> 
                <li><a href="<?php echo $path; ?>news/index"><i class="fa fa-info-circle"></i> iNews</a></li> 
                <li><a href="<?php echo $path; ?>itools/index"><i class="fa fa-bullhorn"></i> iTool</a></li> 
              </ul>
            </li>
            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-unlock-alt"></i> iPin <b class="caret"></b></a>
              <ul class="dropdown-menu">
			    <li><a href="<?php echo $path; ?>epins/index"><i class="fa fa-key"></i> iPin</a></li>
			    <li><a href="<?php echo $path; ?>isahabatpins/index"><i class="fa fa-key"></i> iSahabat iPin</a></li>
			  </ul>
            </li>
			
            <li><a href="<?php echo $path; ?>itakaful/index"><i class="fa fa-umbrella"></i> iTakaful</a></li>
            
            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> iKomuniti <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo $path; ?>activations/index"><i class="fa fa-plus-square"></i> Activate iKomuniti</a></li>
                <li><a href="<?php echo $path; ?>isahabatactivations/index"><i class="fa fa-plus-square"></i> Activate iSahabat</a></li>
                <li><a href="<?php echo $path; ?>tree/index"><i class="fa fa-sitemap"></i> iTree</a></li> 
                <li><a href="http://ishare.com.my/pages/register" target="_blank"><i class="fa fa-pencil-square"></i> iRegister</a></li> 
              </ul>
            </li>
            <li><a href="<?php echo $path; ?>messages/index"><i class="fa fa-comments"></i> iMail</a></li> 
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cogs"></i> iSetting <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo $path; ?>settings/profile"><i class="fa fa-edit"></i> Profile Informations</a></li>
                <li><a href="<?php echo $path; ?>settings/personal"><i class="fa fa-edit"></i> Personal Informations</a></li>
                <li><a href="<?php echo $path; ?>settings/vehicle"><i class="fa fa-edit"></i> Vehicle Informations</a></li>
                <li><a href="<?php echo $path; ?>settings/account"><i class="fa fa-edit"></i> Account Setting</a></li> 
              </ul>
            </li>
          </ul>

          <ul class="nav navbar-nav navbar-right navbar-user">
          <li><a href="http://ishare.com.my/imall" target="_blank"><i class="fa fa-tags"></i> iMall</a></li> 
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
                <li><a href="<?php echo $path; ?>profile/<?php echo $nav->username; ?>"><i class="fa fa-user"></i> Profile</a></li> 
                <li class="divider"></li>
                <li><?php echo $this->tag->linkTo(array('users/logout', '<i class=\'fa fa-power-off\'></i> Log Out')); ?></li>
              </ul>
            </li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </nav>
<?php } ?>
      <div id="page-wrapper">  