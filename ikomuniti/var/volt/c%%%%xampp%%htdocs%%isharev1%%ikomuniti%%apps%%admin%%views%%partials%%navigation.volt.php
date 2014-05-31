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
          <?php echo $this->tag->linkTo(array('gghadmin/index', $this->tag->image(array('images/logo.png')), 'class' => 'navbar-brand')); ?>
        </div>

        <!-- class="active" Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse jun_line">
          <ul class="nav navbar-nav side-nav">
            <li><a href="<?php echo $admin_path; ?>index"><i class="fa fa-home"></i> iDashboard</a></li>
            <li><a href="<?php echo $admin_path; ?>insuran/manage"><i class="fa fa-umbrella"></i> iTakaful</a></li>
            
            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-sitemap"></i> iKomuniti <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo $admin_path; ?>activations/index"><i class="fa fa-plus-circle"></i> Activate iKomuniti</a></li>
                <li><a href="<?php echo $admin_path; ?>tree/index"><i class="fa fa-sitemap"></i> iTree</a></li> 
                <li><a href="<?php echo $admin_path; ?>users/view"><i class="fa fa-users"></i> iKomuniti</a></li> 
                <li><a href="<?php echo $admin_path; ?>isahabat/index"><i class="fa fa-user"></i> iSahabat</a></li> 
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-briefcase"></i> iAccount <b class="caret"></b></a>
              <ul class="dropdown-menu">
            	<li><a href="<?php echo $admin_path; ?>wallets/index"><i class="fa fa-money"></i> iPoint</a></li>
            	<li><a href="<?php echo $admin_path; ?>epins/index"><i class="fa fa-unlock"></i> iPin</a></li>
            	<li><a href="<?php echo $admin_path; ?>withdrawals/index"><i class="fa fa-random"></i> Withdrawals</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bookmark-o"></i>  iAds <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo $admin_path; ?>imall/index"><i class="fa fa-shopping-cart"></i> iMall</a></li>
                <li><a href="<?php echo $admin_path; ?>ioffer/index"><i class="fa fa-tag"></i> iOffer</a></li>
                <li><a href="<?php echo $admin_path; ?>ipartner/index"><i class="fa fa-tags"></i> iPartner</a></li>
                <li><a href="<?php echo $admin_path; ?>imerchant/index"><i class="fa fa-tags"></i> iMerchant</a></li>
                <li><a href="<?php echo $admin_path; ?>iprihatin/index"><i class="fa fa-wheelchair"></i> iPrihatin</a></li>
                <li><a href="<?php echo $admin_path; ?>inews/index"><i class="fa fa-bullhorn"></i> iNews</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-book"></i> iReport <b class="caret"></b></a>
              <ul class="dropdown-menu"> 
                <li><a href="<?php echo $admin_path; ?>reports/index"><i class="fa fa-print"></i> Reports</a></li> 
                <li><a href="<?php echo $admin_path; ?>cashflow/index"><i class="fa fa-bar-chart-o"></i> Cash Flow</a></li>
                <li><a href="<?php echo $admin_path; ?>statistic/index"><i class="fa fa-signal"></i> Statistic</a></li>
              </ul>
            </li>
            
            <li><a href="<?php echo $admin_path; ?>messages/index"><i class="fa fa-comments-o"></i> iMail</a></li> 
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-gears"></i> iSetting <b class="caret"></b></a>
              <ul class="dropdown-menu"> 
                <li><a href="<?php echo $admin_path; ?>settings/index"><i class="fa fa-pencil-square-o"></i> Account Information</a></li>
                <li><a href="<?php echo $admin_path; ?>settings/password"><i class="fa fa-pencil-square-o"></i> Password</a></li>
              </ul>
            </li>
            <li><a href="<?php echo $admin_path; ?>event/index"><i class="fa fa-trophy"></i> Achievement</a></li>
          </ul>

          <ul class="nav navbar-nav navbar-right navbar-user">
            <li class="dropdown messages-dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> Messages <?php if ($count_inbox > 0) { ?><span class="badge badge-error"><?php echo $count_inbox; ?></span><?php } ?> <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li class="dropdown-header"><?php if ($count_inbox > 0) { ?> <?php echo $count_inbox; ?> New Messages <?php } ?></li>
                
                <?php foreach ($messages_nav as $msg) { ?> 
				<li class="message-preview">
	              <a href="<?php echo $admin_path; ?>messages/view/<?php if ($msg->message_id == 0) { ?><?php echo $msg->m_id; ?><?php } else { ?><?php echo $msg->message_id; ?><?php } ?>">
	                <span class="avatar"><img src="http://placehold.it/50x50"></span>
	                <span class="name"><?php echo $this->escaper->escapeHtml($msg->from_username); ?>:</span>
	                <span class="message"><?php echo $this->escaper->escapeHtml($msg->body); ?>...</span>
	                <span class="time"><i class="fa fa-clock-o"></i> <?php echo $msg->time; ?> <?php echo $msg->created; ?></span>
	              </a>
	            </li>
	            <li class="divider"></li> 
			    <?php } ?>
			    
                <li><?php echo $this->tag->linkTo(array('gghadmin/messages/index', 'View iMail <span class=\'badge\'>' . $count_inbox . '</span>')); ?></li>   
              </ul>
            </li>
            <li class="dropdown alerts-dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> Notification <?php if ($count_notification > 0) { ?><span class="badge badge-error"><?php echo $count_notification; ?></span><?php } ?> <b class="caret"></b></a>
              <ul class="dropdown-menu">
              <?php foreach ($notifications_nav as $notificate) { ?> 
                <li><?php echo $this->tag->linkTo(array('gghadmin/notifications/index', '<span class=\'label label-info\'>' . $this->escaper->escapeHtml($notificate->body) . '</span>')); ?></li> 
              <?php } ?>
                <li class="divider"></li>
                <li><?php echo $this->tag->linkTo(array('gghadmin/notifications/index', 'View All')); ?></li>
              </ul>
            </li>
            
            <li class="dropdown user-dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $nav->username; ?> <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#"><i class="fa fa-user"></i> Profile</a></li> 
                <li class="divider"></li>
                <li><?php echo $this->tag->linkTo(array('gghadmin/users/logout', '<i class=\'fa fa-power-off\'></i> Log Out')); ?></li>
              </ul>
            </li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </nav>
<?php } ?>
      <div id="page-wrapper">  