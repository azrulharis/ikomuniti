<?php echo $this->tag->stylesheetLink('css/morris-0.4.3.min.css'); ?> 

<?php echo $this->partial('partials/navigation'); ?>
<?php foreach ($informations as $info) { ?>

        
        <div class="row">
          <div class="col-lg-3">
            <div class="panel panel-info">
              <div class="panel-heading">
                <div class="row"> 
                  <div class="col-xs-6 text-right">
                    <p class="announcement-heading"><?php echo $count_all_member; ?></p>
                    <p class="announcement-text">iKomuniti</p>
                  </div>
                </div>
              </div>
              <a href="<?php echo $admin_path; ?>users/view">
                <div class="panel-footer announcement-bottom">
                  <div class="row">
                    <div class="col-xs-6">
                      View iKomuniti
                    </div>
                    <div class="col-xs-6 text-right">
                      <i class="fa fa-arrow-circle-right"></i>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </div>
         
          <div class="col-lg-3">
            <div class="panel panel-danger">
              <div class="panel-heading">
                <div class="row">
                   
                  <div class="col-xs-6 text-right">
                    <p class="announcement-heading"><?php echo $today_joining; ?></p>
                    <p class="announcement-text">Today Joining</p>
                  </div>
                </div>
              </div>
              <a href="<?php echo $admin_path; ?>activations/index">
                <div class="panel-footer announcement-bottom">
                  <div class="row">
                    <div class="col-xs-6">
                      Activate
                    </div>
                    <div class="col-xs-6 text-right">
                      <i class="fa fa-arrow-circle-right"></i>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </div>
           <div class="col-lg-3">
            <div class="panel panel-warning">
              <div class="panel-heading">
                <div class="row"> 
                  <div class="col-xs-6 text-right">
                    <p class="announcement-heading"><?php echo $epin_balance; ?></p>
                    <p class="announcement-text">iPin</p>
                  </div>
                </div>
              </div>
              <a href="<?php echo $admin_path; ?>epins/index">
                <div class="panel-footer announcement-bottom">
                  <div class="row">
                    <div class="col-xs-6">
                      View All
                    </div>
                    <div class="col-xs-6 text-right">
                      <i class="fa fa-arrow-circle-right"></i>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </div>
          
          <div class="col-lg-3">
            <div class="panel panel-success">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-6">
                    <i class="fa fa-comments fa-5x"></i>
                  </div>
                  <div class="col-xs-6 text-right">
                    <p class="announcement-heading"><?php echo $total_unread; ?></p>
                    <p class="announcement-text">Unread iMail</p>
                  </div>
                </div>
              </div>
              <a href="<?php echo $admin_path; ?>messages/index">
                <div class="panel-footer announcement-bottom">
                  <div class="row">
                    <div class="col-xs-6">
                      View iMail
                    </div>
                    <div class="col-xs-6 text-right">
                      <i class="fa fa-arrow-circle-right"></i>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </div>
        </div><!-- /.row -->
        
        <div class="row">
          
          <div class="col-lg-6">
            <div class="bs-example">
              <div class="list-group">
                <a href="#" class="list-group-item active">
                  <i class="glyphicon glyphicon-bookmark"></i>  iPrihatin
                </a>
                <?php foreach ($iprihatins as $iprihatin) { ?>
                <a href="<?php echo $admin_path; ?>iprihatin/view/<?php echo $iprihatin->slug; ?>" class="list-group-item"><?php echo $iprihatin->title; ?>
				<p class="list-group-item-text"><?php echo $iprihatin->body; ?>... </p>
				<span class="glyphicon glyphicon-time"></span> On <?php echo $iprihatin->created; ?>
				</a> 
                <?php } ?>
                <a href="<?php echo $admin_path; ?>iprihatin/index" class="list-group-item"> View All 
                      <i class="fa fa-arrow-circle-right"></i> 
              </a>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="bs-example wgreen">
              <div class="list-group">
                <a href="<?php echo $admin_path; ?>news/index" class="list-group-item active">
                  <i class="glyphicon glyphicon-info-sign"></i>  iNews
                </a>
                <?php foreach ($news as $inews) { ?>
                <a href="<?php echo $admin_path; ?>news/view/<?php echo $inews->slug; ?>" class="list-group-item"><?php echo $inews->title; ?>
				<p class="list-group-item-text"><?php echo $inews->body; ?>...</p>
				<span class="glyphicon glyphicon-time"></span> On <?php echo $inews->created; ?>
				</a> 
                <?php } ?>
                <a href="<?php echo $admin_path; ?>news/index" class="list-group-item"> View All 
                      <i class="fa fa-arrow-circle-right"></i> 
              </a>
              </div>
            </div> 
          </div>
        </div><!-- /.row -->
 
        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> iKomuniti Statistics By Date</h3>
              </div>
              
              <div class="panel-body">
                <div id="morris-chart-area"></div>
              </div>
            </div>
          </div>
        </div> <!--/.row -->
        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-success">
              <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> iKomuniti Statistics By Month</h3>
              </div>
              <div class="panel-body">
                <div id="month-chart-area"></div>
              </div>
            </div>
          </div>
        </div> <!--/.row -->
<?php } ?> 


<?php echo $this->partial('partials/footer'); ?>
<?php echo $this->tag->javascriptInclude('js/morris-0.4.3.min.js'); ?>  
<?php echo $this->tag->javascriptInclude('js/morris/chart-data-morris.js'); ?>