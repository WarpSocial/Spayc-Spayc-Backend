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
          <a class="navbar-brand" href="<?php echo Router::url(['_name' => 'login']);?>">
            <?php echo $this->Html->image("logo.png", ["alt" => ""]); ?>
            </a>
          <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item <?php echo (($controller_name=='Users') && ($controller_action=='index')|| ($controller_action=='warps')|| ($controller_action=='userAdvertisement')) ? 'active' : '';?>">
                <a class="nav-link" href="<?php echo Router::url(['action' => 'index','controller' =>'Users']);?>">Manage Users</a>
              </li>
              <li class="nav-item <?php echo (($controller_name=='Spaycs') && ($controller_action=='index') || ($controller_action=='physicalPresents') || ($controller_action=='spaycMembers') || ($controller_action=='subwarps') || ($controller_action=='subscribedMembers') || ($controller_action=='view')) ? 'active' : '';?>">
                <a class="nav-link" href="<?php echo Router::url(['action' => 'index','controller' =>'Spaycs']);?>">Manage Warps</a>
              </li>
              <li class="nav-item <?php echo (($controller_name=='Advertisement') && ($controller_action=='index')) ? 'active' : '';?>">
                <a class="nav-link" href="<?php echo Router::url(['action' => 'index','controller' =>'Advertisement']);?>">Manage Advertisements</a>
              </li>
              <li class="nav-item <?php echo (($controller_name=='CustomMessages') && ($controller_action=='index')) ? 'active' : '';?>">
                <a class="nav-link" href="<?php echo Router::url(['action' => 'index','controller' =>'CustomMessages']);?>">Custom Messages</a>
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
        