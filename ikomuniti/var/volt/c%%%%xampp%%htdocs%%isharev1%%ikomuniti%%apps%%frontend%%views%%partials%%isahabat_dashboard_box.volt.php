       
<div class="row">
	<div class="col-lg-12">	
		<div class="alert alert-dismissable alert-danger">
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
		  <strong>Dear <?php echo $user->username; ?>.</strong> You&#44;re accessing to iSahabat account that some function are disabled. Please upgrade to iKomuniti account to get extra benefit by iShare.
	    </div> 	
	</div>
</div> 
		
		<div class="row">
          <div class="col-lg-3">
            <div class="panel panel-info">
              <div class="panel-heading">
                <div class="row"> 
                  <div class="col-xs-4">
                    <span class="glyphicon glyphicon-usd"></span>
                  </div>
                  <div class="col-xs-8 text-left">
                    <h4>Commission</h4>
                    <p class="announcement-text">Up to 4 level</p>
                  </div>
                </div>
              </div>
              <a href="/ikomuniti/wallets/index">
                <div class="panel-footer announcement-bottom">
                  <div class="row">
                    <div class="col-xs-6">
                      View Detail
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
                  <div class="col-xs-4">
                    <span class="glyphicon glyphicon-list-alt"></span>
                  </div>
                  <div class="col-xs-8 text-left">
                    <h4>iMall</h4>
                    <p class="announcement-text">Unlimited Ads</p>
                  </div>
                </div>
              </div>
              <a href="/ikomuniti/epins/index">
                <div class="panel-footer announcement-bottom">
                  <div class="row">
                    <div class="col-xs-6">
                      View Detail
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
                  <div class="col-xs-4">
                    <span class="glyphicon glyphicon-ok-sign"></span>
                  </div>
                  <div class="col-xs-8 text-left">
                    <h4>PA</h4>
                    <p class="announcement-text">RM5000</p>
                  </div>
                </div>
              </div>
              <a href="/ikomuniti/activations/index">
                <div class="panel-footer announcement-bottom">
                  <div class="row">
                    <div class="col-xs-6">
                      View Detail
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
                   <div class="col-xs-4">
                    <span class="glyphicon glyphicon-calendar"></span>
                  </div>
                  <div class="col-xs-8 text-left">
                    <h4><?php echo $user->insuran_due_date; ?></h4>
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
        </div><!-- /.row -->