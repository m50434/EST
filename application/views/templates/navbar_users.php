
<nav class="navbar navbar-custom navbar-expand-lg navbar-dark nav-bg-color">
 <div class="container">
  <div class="navbar-brand" ><?php echo $prefs[0]->school ?></div>
  

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor03" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarColor03">
    <ul class="navbar-nav mr-auto"></ul>

	<ul class="nav navbar-nav navbar-right">
	<li class="nav-item"><a class="navbar-brand nav-link logout-link" href="<?php echo site_url() ?>/auth/logout">Logout</a></li>
        <li class="nav-item dropdown active">
          <a href="#" class="nav-link" data-placement="left" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog fa-2x"></i> </a>
          <ul class="navbar-custom dropdown-menu">
            <li class="nav-item"><a class="nav-link" href="<?php echo site_url() ?>/auth/change_password">Passwort ändern</a></li>
            
          </ul>
        </li>
      </ul>

  </div>
  </div>
</nav>

<div class="container">