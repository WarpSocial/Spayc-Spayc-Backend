 <?php
use Cake\Routing\Router;
$controller_name = $this->request->param('controller');
$controller_action = $this->request->param('action');
$activeUrl = $controller_name.$controller_action;
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
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle"  id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Manage<i class="icon-down-icon"></i>
                </a>
                <div class="dropdown-menu" class="manage" aria-labelledby="navbarDropdownMenuLink">
                    <a class="nav-link <?= ('Usersindex' == $activeUrl)? ' active' : '' ?>" href="<?php echo Router::url(['action' => 'index','controller' =>'Users']);?>">Manage Users</a>
                 <a class="nav-link <?= (('Spaycsindex' == $activeUrl) || ('Spaycsview' == $activeUrl))? ' active' : '' ?>" href="<?php echo Router::url(['action' => 'index','controller' =>'Spaycs']);?>">Manage Warps</a>
                  <a class="nav-link <?= ('Advertisementindex' == $activeUrl)? ' active' : '' ?>" href="<?php echo Router::url(['action' => 'index','controller' =>'Advertisement']);?>">Manage Advertisements</a>
                  <a class="nav-link <?= ('Categoriesindex' == $activeUrl)? ' active' : '' ?>" href="<?php echo Router::url(['action' => 'index','controller' =>'Categories']);?>">Manage Category</a>
                </div>
              </li>
              <li class="nav-item <?= ('UserFeedbacksindex' == $activeUrl)? ' active' : '' ?>">
                <a class="nav-link" href="<?php echo Router::url(['action' => 'index','controller' =>'UserFeedbacks']);?>">User Feedback</a>
              </li>
              <li class="nav-item <?php echo (($controller_name=='CustomMessages') && ($controller_action=='index')) ? 'active' : '';?>">
                <a class="nav-link" href="<?php echo Router::url(['action' => 'index','controller' =>'CustomMessages']);?>">Custom Messages</a>
              </li>
              <li class="nav-item <?php echo (($controller_name=='SpamReports') && ($controller_action=='index'))? 'active' : '';?>">
                <a class="nav-link" href="<?php echo Router::url(['action' => 'index','controller' =>'SpamReports']);?>">Manage Spam Report</a>
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
        