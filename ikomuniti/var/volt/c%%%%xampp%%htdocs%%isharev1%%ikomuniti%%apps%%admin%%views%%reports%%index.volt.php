 <script type="text/javascript">
$(document).ready(function()
{   $('#username').autocomplete(
    {   source: "/ikomuniti/gghadmin/ajax/ajaxusername",
        minLength: 2
    });
});
</script>

<?php echo $this->partial('partials/navigation'); ?> 
<div class="row"> 
	
</div>     
<div class="row">
    <div class="col-lg-12">
          
      <div class="panel panel-primary">
        <div class="panel-heading">
		  <h3 class="panel-title">Joining Reports</h3>
		</div>
			<div class="panel-body">  
			<div class="bs-example">
			  <ul class="breadcrumb" style="margin-bottom: 5px;">
			    <li class="active">Joining Report</li>
				<li><?php echo $this->tag->linkTo(array('gghadmin/reports/renewal', 'Renewal')); ?></li>
			    <li><?php echo $this->tag->linkTo(array('gghadmin/reports/bankin', 'Bank In')); ?></li>
				<li><?php echo $this->tag->linkTo(array('gghadmin/reports/payout', 'Payout')); ?></li>
			    <li><?php echo $this->tag->linkTo(array('gghadmin/reports/purchase', 'Purchase')); ?></li>  
			    <li><?php echo $this->tag->linkTo(array('gghadmin/reports/iprihatin', 'iPrihatin Donation')); ?></li>  
			  </ul>
			</div>
		    <?php echo $this->getContent(); ?>
   		    
   <div class="col-lg-6">
	    <div class="well form">
		  <form action="" method="GET">
	      	<h4>From date</h4>
			  <div class="form-group text-center"> 
			  <input type="text" name="start" id="datepicker_from" class="form-control input-lg" value="<?php if ($set_view == 1) { ?><?php echo $start; ?><?php } ?>"> 
			</div>
	  	</div>
	</div>
	<div class="col-lg-6"> 
		<div class="well form">  
			<h4>To date</h4>
				<div class="input-group text-center">
				<input name="end" type="text" class="form-control input-lg" id="datepicker_to" value="<?php if ($set_view == 1) { ?><?php echo $end; ?><?php } ?>">
				<span class="input-group-btn"><button name="submit_date" class="btn btn-lg btn-primary" type="submit" value="search">Go</button></span>
				</div>
			</form>
		</div> 
	</div>
	<div class="col-lg-12">
	    <div class="well form">
		  <form action="" method="GET">
	      	<h4>Print By Username</h4>
			  <div class="form-group text-center"> 
			     <input type="text" name="username" id="username" class="col-lg-10 form-control input-lg" placeholder="Username"> 
			     <span class="input-group-btn"><button name="search_user" class="col-lg-2 btn btn-lg btn-primary" type="submit" value="search">Go</button></span>
			  </div>
		  </form>
	  	</div>
	</div>
		    <?php if ($set_view == 1) { ?>
		    <div class="form-group col-md-12"> 
			   <?php echo $counter; ?> Data Found
			  </div>
			  
			  <div class="col-lg-12">
			  <div class="table-responsive">
		      
			  <?php foreach ($reports as $report) { ?>
				<table class="table table-bordered table-hover table-striped tablesorter"> 
			    <tr>
				 <th>Data</th> <th>Status</th> 
			    </tr>
			    <tr>
				    <td><p>Epin</p></td>
					<td><p><?php echo $report->epin; ?></p></td>  
				</tr>
				<tr>
				    <td><p>Epin Tracking</p></td>
					<td><p><?php echo $report->last_owner; ?></p></td>  
				</tr>
				<tr>
				    <td><p>Username</p></td>
					<td><p><?php echo $report->username; ?></p></td>  
				</tr>
				<tr>
				    <td><p>Sponsor</p></td>
					<td><p><?php echo $report->username_sponsor; ?></p></td>  
				</tr>
				<tr>
				    <td><p>Join Date</p></td>
					<td><p><?php echo $report->created_at; ?></p></td>  
				</tr>
				<tr>
				    <td><p>IC Number</p></td>
					<td><p><?php echo $report->nric_new; ?></p></td>  
				</tr>
				<tr>
				    <td><p>Next Of Kin</p></td>
					<td><p><?php echo $this->escaper->escapeHtml($report->kin_name); ?></p></td>  
				</tr>
				<tr>
				    <td><p>Relation</p></td>
					<td><p><?php echo $this->escaper->escapeHtml($report->relation); ?></p></td>  
				</tr>
				<tr>
				    <td><p>Kin NRIC</p></td>
					<td><p><?php echo $report->nric_new_kin; ?></p></td>  
				</tr>
				<tr>
				    <td><p>Account Number</p></td>
					<td><p><?php echo $this->escaper->escapeHtml($report->bank_number); ?></p></td>  
				</tr>
				<tr>
				    <td><p>Bank</p></td>
					<td><p><?php echo $this->escaper->escapeHtml($report->bank_name); ?></p></td>  
				</tr>
				<tr>
				    <td><p>Address</p></td>
					<td><p><?php echo $this->escaper->escapeHtml($report->address); ?></p></td>  
				</tr>
				<tr>
				    <td><p>Postcode</p></td>
					<td><p><?php echo $report->postcode; ?></p></td>  
				</tr>
				<tr>
				    <td><p>Phone</p></td>
					<td><p><?php echo $report->telephone; ?></p></td>  
				</tr>
				<tr>
				    <td><p>Email</p></td>
					<td><p><?php echo $report->email; ?></p></td>  
				</tr>
				<tr>
				    <td><p>Previous Insurance</p></td>
					<td><p><?php echo $this->escaper->escapeHtml($report->previous_insuran_company); ?></p></td>  
				</tr>
				<tr>
				    <td><p>Cover Note</p></td>
					<td><p><?php echo $this->escaper->escapeHtml($report->cover_note); ?></p></td>  
				</tr>
				<tr>
				    <td><p>NCD</p></td>
					<td><p><?php echo $report->insuran_ncb; ?></p></td>  
				</tr>
				<tr>
				    <td><p>Road Tax</p></td>
					<td><p><?php echo $report->road_tax; ?></p></td>  
				</tr>
				<tr>
				    <td><p>Due Date</p></td>
					<td><p><?php echo $report->insuran_due_date; ?></p></td>  
				</tr>
				<tr>
				    <td><p>Reg Number</p></td>
					<td><p><?php echo $report->reg_number; ?></p></td>  
				</tr>
				<tr>
				    <td><p>Owner Name</p></td>
					<td><p><?php echo $this->escaper->escapeHtml($report->owner_name); ?></p></td>  
				</tr>
				<tr>
				    <td><p>Owner NRIC</p></td>
					<td><p><?php echo $report->owner_nric; ?></p></td>  
				</tr>
				<tr>
				    <td><p>Owner DOB</p></td>
					<td><p><?php echo $report->owner_dob; ?></p></td>  
				</tr>
				<tr>
				    <td><p>Model</p></td>
					<td><p><?php echo $this->escaper->escapeHtml($report->model); ?></p></td>  
				</tr> 
				<tr>
				    <td><p>Year Make</p></td>
					<td><p><?php echo $this->escaper->escapeHtml($report->year_make); ?></p></td>  
				</tr>
				<tr>
				    <td><p>Engine Capacity</p></td>
					<td><p><?php echo $report->capacity; ?></p></td>  
				</tr>
				<tr>
				    <td><p>Engine Number</p></td>
					<td><p><?php echo $this->escaper->escapeHtml($report->engine_number); ?></p></td>  
				</tr>
				<tr>
				    <td><p>Chasis Number</p></td>
					<td><p><?php echo $this->escaper->escapeHtml($report->chasis_number); ?></p></td>  
				</tr>
				<tr>
				    <td><p>Grant Serial Number</p></td>
					<td><p><?php echo $this->escaper->escapeHtml($report->grant_serial_number); ?></p></td>  
				</tr>
			 
				</table>
				
				<?php } ?>
			  </div>
			   </div>
			  
		     <div class="form-group col-md-12"> 
		     <?php if ($set_print == 1) { ?>
			   <input type="submit" value="Print" onclick="printIframe(report);" class="btn btn-success"/>
			   <script>function printIframe(objFrame){ objFrame.focus(); objFrame.print(); bjFrame.save(); }</script>
			   <iframe style="display: none;" name="report" id="report" src="<?php echo $path; ?>reports/print?start=<?php echo $start; ?>&end=<?php echo $end; ?>"></iframe>
			   <?php } elseif ($set_print == 2) { ?>
			   <input type="submit" value="Print" onclick="printIframe(report);" class="btn btn-success"/>
			   <script>function printIframe(objFrame){ objFrame.focus(); objFrame.print(); bjFrame.save(); }</script>
			   <iframe style="display: none;" name="report" id="report" src="<?php echo $path; ?>reports/print?username=<?php echo $username; ?>"></iframe>
			   <?php } ?>
			</div>
			<?php } else { ?>
			<div class="form-group col-md-12">
			<div class="alert alert-dismissable alert-info">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              Please select data between two date to view record.
            </div>
			</div>
			<?php } ?>
			</div>
		</div>
	</div>
</div>  

<?php echo $this->partial('partials/footer'); ?>
