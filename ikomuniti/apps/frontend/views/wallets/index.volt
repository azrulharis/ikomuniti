{{ partial("partials/navigation") }}

<div class="row">        
      
	<div class="col-lg-12">   
	   
		<div class="panel panel-primary">
			<div class="panel-heading">
			<h3 class="panel-title">iPoint Balance</h3>
			</div>
			<div class="panel-body">
			<div class="bs-example">
		  <ul class="breadcrumb" style="margin-bottom: 5px;">
		    <li class="active">iPoint</li>
			<li>{{ link_to("wallets/histories", "History") }}</li>
		    <li>{{ link_to("wallets/redeem", "Withdraw") }}</li>
		    <li>{{ link_to("wallets/status", "Withdrawal Status") }}</li> 
			<li>{{ link_to("wallets/transfer", "Transfer") }}</li> 
		  </ul>
		</div>
			<h4>iPoint Balance <b>{{ wallet }}</b></h4>
			</div>
		</div>
	</div>

	<div class="col-lg-12"> 
		<div class="panel panel-primary">
			<div class="panel-heading">
			<h3 class="panel-title">Add iPoint</h3>
			</div>
			<div class="panel-body">
			{{ content() }} 
			<div class="form-group" style="padding: 2px 10px 30px 10px; margin-bottom: 20px;">
			    <p>Sila lengkapkan borang ini setelah anda bank in apa-apa bayaran ke Akaun iShare (Contoh Remark: Bayaran iKit, Premium Takaful, Pembelian barang-barang iShare atau Tambahan iPoint).</p>
			    <p>Borang ini adalah alternatif untuk memaklumkan pihak iShare mengenai bukti sebarang pembayaran ke Akaun iShare. (Manual Transfer)</p>
			    <p>Maklumat Bank iShare:</p>
			    <p class="col-lg-2 col-xs-12">Nama:</p> <p class="col-lg-9 col-xs-12"><b>Global Group Holdings Sdn Bhd</b></p>
			    <p class="col-lg-2 col-xs-12">Bank:</p> <p class="col-lg-9 col-xs-12"><b>Maybank Berhad</b></p>
	            <p class="col-lg-2 col-xs-12">No. Akaun:</p> <p class="col-lg-9 col-xs-12"><b>5628 3450 3818</b></p> 
			</div>
			<div class="form-group" style="height: 30px;"></div>
				<form action="" method="post">
				<div class="form-group">
				  <label>From Account (If online transfer)</label>
				  <input type="text" name="from_acc" class="form-control" placeholder="CIMB 4876584568">  
				</div>
				<div class="form-group">
				  <label>Payment Date (YYYY-MM-DD)<b class="required">*</b></label>
				  <input type="text" name="payment_date" id="datepicker" class="form-control" placeholder="YYYY-MM-DD" required onfocus> 
				</div>
				<div class="form-group">
				  <label>Payment Time (HH:MM am/pm)<b class="required">*</b></label>
				  <input type="text" name="payment_time" class="form-control" placeholder="12:32pm" required onfocus> 
				</div>
				<div class="form-group">
				  <label>Amount RM <b class="required">*</b></label>
				  <input type="text" name="amount" value="{{amount|e}}" class="form-control" placeholder="1295.50" required onfocus> 
				  <input type="hidden" name="token" value="{{token}}">
				</div>
				<div class="form-group">
				  <label>Remark</label>
				  <textarea name="remark" class="form-control" placeholder="Remark..."></textarea>
				</div>
				<div class="form-group"> 
				  <input type="submit" name="submit" class="btn btn-success" value="Submit"> 
				</div>
			  </form>
			</div>
		</div>
	</div>
</div>   
{{ partial("partials/footer") }}