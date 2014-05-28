<script>
  $(function() {
	$("#dob").datepicker({
	    changeMonth: true,
        changeYear: true, 
		dateFormat: "yy-mm-dd", 
		stepMonths: 12,
		minDate: new Date(1930, 11 - 1, 6),
        yearRange: '1930:2010'
		});
	});
</script>
<script type="text/javascript">
 
 $(document).ready(function(){
    $("#username_sponsor").change(function(){
         $("#username_sponsor").html("<img src='/ishare/theme/pages/img/ajax-loader.gif' /> checking...");
     

    var username_sponsor=$("#username_sponsor").val();

      $.ajax({
            type:"post",
            url:"{{ajax_sponsor_username}}",
            data:"username_sponsor="+username_sponsor,
                success:function(data){ 
                    $("#username_sponsor_result").html(data); 
                }
         });

    });

 });
 
  $(document).ready(function(){
    $("#username").change(function(){
         $("#username").html("<img src='/ishare/theme/pages/img/ajax-loader.gif' /> checking...");
     

    var username=$("#username").val();

      $.ajax({
            type:"post",
            url:"{{ajax_username}}",
            data:"username="+username,
                success:function(data){ 
                    $("#username_result").html(data); 
                }
         });

    });

 });

</script> 
<div class="container spacer_80">    
	<div class="row">
	    <div class="col-lg-8">     
            {{content()}}
        </div>  
	      <div class="col-lg-4">
		    <div class="panel panel-success">
				<div class="panel-body text-justify">
				<h4><i class="fa fa-edit"></i> Pendaftaran</h4>
                <p>Sila pastikan anda mengisi borang pendaftaran mengikut maklumat di dalam Geran kenderaan. Hanya mereka yang beragama Islam dibenarkan untuk menyertai Komuniti iShare</p>
                <div class="text-center">
				  <a href="http://ishare.com.my/ikomuniti/users/login" class="btn btn-success"><i class="fa fa-lock"></i> Log Masuk</a>
				</div>
				<hr> 
                <h4><i class="fa fa-certificate"></i> iReseller</h4>
                <p>iReseller adalah individu yang dilantik oleh syarikat bagi mengaktifkan akaun dan iKit. Anda boleh menghubungi iReseller kami bagi mendapatkan info lengkap mengenai program iShare.</p> 
                <div class="text-center">
				  <a href="http://ishare.com.my/pages/ireseller" class="btn btn-primary"><i class="fa fa-certificate"></i> Senarai iReseller</a>
				</div>
				<hr>
				<div class="text-center">
				   <iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fishare.com.my&amp;width&amp;height=258&amp;colorscheme=light&amp;show_faces=true&amp;header=false&amp;stream=false&amp;show_border=false&amp;appId=473945646001405" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:258px;" allowTransparency="true"></iframe>
				</div>
				</div>
			</div> 
	    </div>
	</div><!-- End row -->     
</div><!-- /.container -->

