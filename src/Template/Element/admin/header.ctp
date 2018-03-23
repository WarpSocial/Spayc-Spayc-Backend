 <?php
use Cake\Routing\Router;
$controller_name = $this->request->param('controller');
$controller_action = $this->request->param('action');
?>
 <header class="fixed-header">
      <!--============navigation===============-->
      <nav class="navbar navbar-toggleable-md ">
        <div class="container">
          <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <a class="navbar-brand" href="#">
            <?php echo $this->Html->image("logo.png", ["alt" => ""]); ?>
            </a>
          <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item <?php echo (($controller_name=='Users') && ($controller_action=='manageUser')) ? 'active' : '';?>">
                <a class="nav-link" href="<?php echo Router::url(['action' => 'manage-user','controller' =>'Users']);?>">Manage Users</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Manage Spaycs</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Manage Advertisements</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Custom Messages</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle"  id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Admin <i class="icon-down-icon"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item change-password" href="<?php echo Router::url(['action' => 'change-password','controller' =>'Users']);?>"> <i class="icon-key-icon"></i>Change Password</a>
                  <a class="dropdown-item logout" href="<?php echo Router::url(['action' => 'logout','controller' =>'Users']);?>"><i class="icon-logout-icon"></i> Logout</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>      
  </header>
        <div class ="loader hide">
					<div class="loader-icon"></div>
				</div>