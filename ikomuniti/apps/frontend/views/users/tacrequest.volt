<div class="container" style="max-width: 700px; margin: 30px auto 10px auto;">
{{ content() }}
</div>
   <div class="container" style="max-width: 400px; margin: 10px auto 10px auto;">
   
       <form action="" method="POST" class="form-signin" role="form"> 
        <h2 class="form-signin-heading">New Password Request</h2>
        <div class="form-group">
	        <label>RPID</label>
	        <input type="text" name="tac" class="form-control" placeholder="RPID" required> 
        </div>
        <div class="form-group">
	        <label>New Password</label>
        	<input type="password" name="password" class="form-control" placeholder="password" required> 
        </div>
        <div class="form-group">
	        <label>Retype Password</label>
        	<input type="password" name="retype_password" class="form-control" placeholder="password" required> 
        </div> 
        <input type="hidden" name="{{token_name}}" value="{{token_value}}">
        
        <button class="btn btn-lg btn-primary btn-block" type="submit"><i class="fa fa-question-circle"></i> Change My Password</button> 
        <p class="text-center"><a href="http://ishare.com.my"><i class="fa fa-home"></i> Back To Home</a></p>
      </form> 
   </div>  