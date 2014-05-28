{{ content() }}
   <div class="container" style="max-width: 340px; margin: 100px auto 100px auto;">
       {{ form('users/forgotpassword', 'method': 'POST', 'class': 'form-signin', 'role': 'form')}} 
        <h2 class="form-signin-heading">Forgotten Password</h2>
        <input type="text" name="username" class="form-control" placeholder="Username" required autofocus> 
        <input type="hidden" name="{{token_name}}" value="{{token_value}}">
        
        <button class="btn btn-lg btn-primary btn-block" type="submit"><i class="fa fa-question-circle"></i> Reset Password</button>
        {{ link_to('users/register', '<i class="fa fa-edit"></i> Register', 'class': 'btn btn-lg btn-success btn-block')}}
        <p class="text-center"><a href="http://ishare.com.my"><i class="fa fa-home"></i> Back To Home</a></p>
      </form> 
   </div>  