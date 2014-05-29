        <div class="row">
          <div class="col-lg-3">
            <div class="panel panel-info">
              <div class="panel-heading">
                <div class="row"> 
                  <div class="col-xs-6">
                    <span class="fa fa-usd"></span>
                  </div>
                  <div class="col-xs-6 text-left">
                    <h4><?php echo $info->amount; ?></h4>
                    <p class="announcement-text">iPoint</p>
                  </div>
                </div>
              </div>
              <a href="/ikomuniti/wallets/index">
                <div class="panel-footer announcement-bottom">
                  <div class="row">
                    <div class="col-xs-6">
                      Add iPoint
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
                  <div class="col-xs-6">
                    <i class="fa fa-key"></i>
                  </div>
                  <div class="col-xs-6 text-left">
                    <h4><?php echo $epin_balance; ?></h4>
                    <p class="announcement-text">iPin</p>
                  </div>
                </div>
              </div>
              <a href="/ikomuniti/epins/index">
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
            <div class="panel <?php echo $blink; ?>">
              <div class="panel-heading">
                <div class="row">
                   <div class="col-xs-6">
                    <span class="fa fa-calendar"></span>
                  </div>
                  <div class="col-xs-6 text-left">
                    <h4><?php echo $next_renewal_date; ?></h4>
                    <p class="announcement-text">Due Date</p>
                  </div>
                </div>
              </div>
              <a href="/ikomuniti/itakaful/index">
                <div class="panel-footer announcement-bottom">
                  <div class="row">
                    <div class="col-xs-6">
                      Quotation
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
                    <span class="fa fa-sitemap"></span>
                  </div>
                  <div class="col-xs-6 text-left">
                    <h4<?php if ($count_new_member > 0) { ?> id="blink"<?php } ?>><?php echo $count_new_member; ?></h4>
                    <p class="announcement-text">New iKomuniti</p>
                  </div>
                </div>
              </div>
              <a href="/ikomuniti/activations/index">
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
        </div><!-- /.row -->