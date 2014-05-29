<?php echo $this->getContent(); ?>
   <div class="container" style="max-width: 340px; margin: 100px auto 100px auto;">
       <?php echo $this->tag->form(array('users/login', 'method' => 'POST', 'class' => 'form-signin', 'role' => 'form')); ?>
        <h2 class="form-signin-heading">Please sign in</h2>
        <input type="text" name="username" class="form-control" placeholder="Username" required autofocus>
        <input style="margin-top: 10px;" type="password" name="password" class="form-control" placeholder="Password" required>
        <input type="hidden" name="<?php echo $token_name; ?>" value="<?php echo $token_value; ?>">
        
        <button style="margin-top: 10px;" class="btn btn-lg btn-primary btn-block" type="submit"><i class="fa fa-lock"></i> Sign in</button>
        
        <a href="http://ishare.com.my/pages/register" class="btn btn-lg btn-success btn-block"><i class="fa fa-edit"></i> Register</a> 
      </form>
	  <p class="text-center"><?php echo $this->tag->linkTo(array('users/forgotpassword', '<i class="fa fa-question-circle"></i> Forgot Password')); ?></p>
	  <p class="text-center"><a href="http://ishare.com.my"><i class="fa fa-home"></i> Back To Home</a></p>
   </div>  