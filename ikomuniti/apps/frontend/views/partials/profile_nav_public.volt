{{ stylesheet_link("css/profile.css") }}
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
          {{ link_to("{{path}}/index", image('images/logo.png'), "class": "navbar-brand") }}
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse jun_line"> 
          <ul class="nav navbar-nav navbar-right navbar-user">
            <li><a href="">iPartner</a></li>
            <li><a href="">iMall</a></li> 
            <li><a href="">Login</a></li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </nav> 
 <div class="profile_container" style="border: 1px solid #ccc;">
