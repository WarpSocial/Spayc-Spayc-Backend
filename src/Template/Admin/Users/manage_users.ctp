<?php use Cake\Routing\Router;
use Api\Auth\ApiHasher;
  $userCount = false;
 if(count($users) > 0) {
    $userCount = true;
 }
$genderIconSorting=$usernameIconSorting=$createdIconSorting=$dobIconSorting='';
if(isset($this->request->query['sort'])){
    if(($this->request->query['sort'] == 'username') && ($this->request->query['direction'] == 'asc')) {
      $usernameIconSorting = 'active';
    }
    if(($this->request->query['sort'] == 'gender') && ($this->request->query['direction'] == 'asc')) {
      $genderIconSorting = 'active';
    }
    if(($this->request->query['sort'] == 'dob') && ($this->request->query['direction'] == 'asc')) {
      $dobIconSorting = 'active';
    }
    
    if(($this->request->query['sort'] == 'created') && ($this->request->query['direction'] == 'asc')) {
      $createdIconSorting = 'active';
    }
}
?>
<!--=============breadcrumbs==============-->      
      <div class="breadcrumbs">
        <div class="container">
          <h4>Manage Users</h4>
          <p><span>manage</span> <span>user</span></p>
        </div>
      </div>
<section class="content-wrapper content-filter">
        <!--===========filter================-->
      <?php if ($userCount) {?>  
      <div class="filters">
        <div class="container">
      <form name="userFilterFrm" id="userFilterFrm" method="get" autocomplete="off">
          <div class="filter-wrapper">
            <!--============search dropdown========-->
              <div class="search">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Search" id="keyword" name="keyword" value="<?php echo $this->request->query('keyword'); ?>">
                <span class="clear-search hide" id="clear-search"></span>
              </div>
            </div>
            
           
            <div class="filter-by ml-auto">
              <h4>Fillter by</h4>
              <!--============filter dropdown========-->
              <div class="filter-box">
                <div class="dropp-header js-dropp-action filter-sm">
                  <span class="dropp-header__title js-value ell" id="user_type">Gender </span>
                  <i class="icon icon-down-filter"></i>
                </div>
                <div class="dropp-body">
                  <div class="dropp-body-wrap">
                    <label for="optA" class="custom-label">
                      <input type="radio" id="optA" name="dropp" value="All"/>
                      <span class="ell">All</span>
                    </label>
                    <label for="optB" class="custom-label">
                      <input type="radio" id="optB" name="dropp" value="Male"/>
                      <span class="ell">Male</span>
                    </label>
                    <label for="optC" class="custom-label">
                      <input type="radio" id="optC" name="dropp" value="Female"/>
                      <span class="ell">Female</span>
                    </label>
                  </div>
                </div>
              </div>
              <!--============filter dropdown========-->
              <div class="filter-box">
                  <div class="dropp-header filter-sm">
                    <div id="datepicker2" class="input-group date">
                      <input class="from-date" type="text"  placeholder="From Date" />
                      <span class="input-group-addon datepicker-icon"></span>
                  </div>
                  </div>
  
                </div>
                <!--============filter dropdown========-->
              <div class="filter-box">
                  <div class="dropp-header filter-sm">
                    <div id="datepicker" class="input-group date">
                      <input class="from-date" type="text"  placeholder="To Date" />
                      <span class="input-group-addon datepicker-icon"></span>
                    </div>
                  </div>
                </div>
                <!--============filter dropdown========-->
                <div class="filter-box hide">
                  <div class="dropp-header js-dropp-action filter-sm">
                    <span class="dropp-header__title js-value ell ">Location</span>
                    <i class="icon icon-down-filter"></i>
                  </div>
                  <div class="dropp-body">
                    <div class="dropp-body-wrap">
                      <label for="locationA" class="custom-label">
                        <input type="radio" id="locationA" name="dropp" value="Location 1"/>
                        <span class="ell">Location 1</span>
                      </label>
                      <label for="locationB" class="custom-label">
                        <input type="radio" id="locationB" name="dropp" value="Location 2"/>
                        <span class="ell">Location 2</span>
                      </label>
                    </div>
                  </div>
                </div>
                <!--============filter reset========-->
                <button class="reset-filter">Reset</button>
                <button class="reset-filter" type="submit">Search</button>
            </div>
          </div>
          </form>
        </div>
      </div>
      <!--============= table head ===================-->
      <div class="container">        
        <div class="table-wrapper">      
          <div class="table-head">
            <div class="head-text flex-basis15 text-left">
            <span class="table-filter"><?php echo $this->Paginator->sort('username','User Info');?>
            <!-- <span class="icon-sorting <?php //echo $usernameIconSorting?>">
               <?php //echo $this->Paginator->sort('username',$this->Html->image('filter-down.png', ['alt' => 'icon']),['escape' => false]);?>
            </span> -->
              
            </span>
            </div>
            <div class="head-text flex-basis11">
              <span class="table-filter"><?php echo $this->Paginator->sort('gender','Gender');?></span>
            </div>
            <div class="head-text flex-basis11"><span class="table-filter"><?php echo $this->Paginator->sort('dob','Date of Birth');?></span></div>
            <div class="head-text flex-basis15 text-left"><span>Location</span></div>
            <div class="head-text flex-basis9"><span>Spaycs Joined</span></div>
            <div class="head-text flex-basis9"><span>Spaycs Created</span></div>
            <div class="head-text flex-basis10"><span>Friends</span></div>
            <div class="head-text flex-basis14"><span>Advertisements</span></div>
            <div class="head-text flex-basis10"><span class="table-filter"><?php echo $this->Paginator->sort('created','Registration Date');?></span></div>
            <div class="head-text flex-basis6"><span class="blank"></span></div>
          </div>
          <?php foreach($users as $user) { ?>
          <!--==============table data====================-->
            <div class="table-row">
              <div class="table-data flex-basis15 text-left">
                <span class="user-name"><?= !empty($user->username)?h(ucwords($user->username)):BLANK ?></span>
                <span class="ell"><?= !empty($user->email)?h($user->email):BLANK ?></span>
                <span class="user-contact"><?= !empty($user->phone)?h($user->country_code).'&nbsp;'.h($user->phone):BLANK; ?>
                </span>
                <span class="ell"><?= !empty($user->password)?h(ApiHasher::dehash($user->password)):BLANK ?></span>
                <span class="ell">
                  <a href="javascript:void(0)" class="pop" page="<?php echo Router::url(['Controller' => 'Users', 'action'=> 'adminResetPassword',$user->id]);?>">Change Password
                </a>
                </span>
              </div>
              <div class="table-data flex-basis11">
                <span><?= !empty($user->gender)?h($user->gender):BLANK ?></span>
              </div>
              <div class="table-data flex-basis11">
                <span><?= !empty($this->dateFormat($user->dob))?$this->dateFormat($user->dob):BLANK ?></span>
              </div>
              <div class="table-data flex-basis15 text-left">
                <span><?= !empty($user->address)?h($user->address):BLANK ?></span>
              </div>
              <div class="table-data flex-basis9">
                <span><?= !empty($user->joined_spayc[0]->joined_spaycs)?h($user->joined_spayc[0]->joined_spaycs):BLANK_COUNT ?></span>
              </div>
              <div class="table-data flex-basis9">
                <span><?= !empty($user->spaycs[0]->created_spaycs)?h($user->spaycs[0]->created_spaycs):BLANK_COUNT ?></span>
              </div>
              <div class="table-data flex-basis10">
                <span><?= !empty($user->friend)?h($user->friend):BLANK_COUNT ?></span>
              </div>
              <div class="table-data flex-basis14">
                <span><?= BLANK_COUNT ?></span>
              </div>
              <div class="table-data flex-basis10">
                <span><?= !empty($this->dateFormat($user->created))?$this->dateFormat($user->created):BLANK ?></span>
              </div>
              <!--table dropdown-->
              <div class="table-data flex-basis6">
                <div class="dropdown table-view-dropdown">
                  <div class="table-dropdown"  id="table-data-dropdown" data-toggle="dropdown">
                    <span></span>
                    <span></span>
                    <span></span>
                  </div>
                  <div class="dropdown-menu" aria-labelledby="table-data-dropdown">
                    <button class="dropdown-item block"> <i class="icon-block"></i>Block</button>
                  </div>
                </div>
              </div>
            </div>
          <?php
           }
          ?>
         
        
        <!--===========pagination========-->
       <!--  <ul class="pagination table-pagination">
          <li><a href="#" class="prev"></a></li>
          <li><a href="#" class="active">1</a></li>
          <li><a href="#">2</a></li>
          <li><a href="#">3</a></li>
          <li><a href="#">4</a></li>
          <li><a href="#">5</a></li>
          <li><a class="next" href="#"></a></li>
        </ul> -->
        <?php if($this->Paginator->params()['pageCount'] > 1) { ?>
            <ul class="pagination table-pagination">
              <?= $this->Paginator->prev('',['escape' => false]) ?>
              <?= $this->Paginator->numbers(array('modulus' => 4)) ?>
              <?= $this->Paginator->next('',['escape' => false]) ?>
            </ul>
        <?php } ?>

      </div>      
    </div>
    <?php }  else { ?>
      <div class="no-data-wrapper">
        <div class="no-data no-user" >
            <?php echo $this->Html->image("no-user.png", ["alt" => "", 'class' =>'mb-30' ]); ?>
            <h2>No Users Found!</h2>
            <p>Seems like no user has created the account yet!</p>
        </div>
      </div>
    <?php } ?>
</section>
<?php echo $this->Html->script('admin/user'); ?>
<?php echo $this->Html->script(['admin/admin-manage-user.js']); ?>