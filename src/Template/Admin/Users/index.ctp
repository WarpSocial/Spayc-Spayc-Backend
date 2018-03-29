<?php use Cake\Routing\Router;
use Api\Auth\ApiHasher;
 $userCount=$showPassword=$filter=false;
 if(count($users) > 0) {
    $userCount=true;
 }
 if($this->request->query('debug')&&$this->request->query('debug')=='on'){
  $showPassword=true;
 }
 if($this->request->query()){
    $filter=true;
 } 
$genderIconSorting=$usernameIconSorting=$createdIconSorting=$dobIconSorting='';
if(isset($this->request->query['sort'])){
    if(($this->request->query['sort'] == 'display_name') && ($this->request->query['direction'] == 'asc')) {
      $usernameIconSorting = 'sort-asc';
    } else if(($this->request->query['sort'] == 'display_name') && ($this->request->query['direction'] == 'desc')) {
      $usernameIconSorting = 'sort-desc';
    }
    if(($this->request->query['sort'] == 'gender') && ($this->request->query['direction'] == 'asc')) {
      $genderIconSorting = 'sort-asc';
    } else if(($this->request->query['sort'] == 'gender') && ($this->request->query['direction'] == 'desc')) {
      $genderIconSorting = 'sort-desc';
    }
    if(($this->request->query['sort'] == 'dob') && ($this->request->query['direction'] == 'asc')) {
      $dobIconSorting = 'sort-asc';
    } else if(($this->request->query['sort'] == 'dob') && ($this->request->query['direction'] == 'desc')) {
      $dobIconSorting = 'sort-desc';
    }
    
    if(($this->request->query['sort'] == 'created') && ($this->request->query['direction'] == 'asc')) {
      $createdIconSorting = 'sort-asc';
    } else if(($this->request->query['sort'] == 'created') && ($this->request->query['direction'] == 'desc')) {
      $createdIconSorting = 'sort-desc';
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
       <?php if($userCount || $filter){ ?>
       <?php echo $this->element('admin/user-filter');?>
 
      <!--============= table head ===================-->
      <div class="container">        
        <div class="table-wrapper">      
          <div class="table-head">
            <div class="head-text flex-basis15 text-left p-info">
            <span class="table-filter <?php echo $usernameIconSorting?>"><?php echo $this->Paginator->sort('display_name','User Info');?>
            </span>
            </div>
            <div class="head-text flex-basis11">
              <span class="table-filter <?php echo $genderIconSorting?>"><?php echo $this->Paginator->sort('gender','Gender');?></span>
            </div>
            <div class="head-text flex-basis11"><span class="table-filter <?php echo $dobIconSorting?>"><?php echo $this->Paginator->sort('dob','Date of Birth');?></span></div>
            <div class="head-text flex-basis15 text-left"><span>Location</span></div>
            <div class="head-text flex-basis9"><span>Spaycs Joined</span></div>
            <div class="head-text flex-basis9"><span>Spaycs Created</span></div>
            <div class="head-text flex-basis10"><span>Friends</span></div>
            <div class="head-text flex-basis14"><span>Advertisements</span></div>
            <div class="head-text flex-basis10"><span class="table-filter <?php echo $createdIconSorting?>"><?php echo $this->Paginator->sort('created','Registration Date');?></span></div>
            <div class="head-text flex-basis6"><span class="blank"></span></div>
          </div>
          <?php   if ($userCount) {?>  
            <?php foreach($users as $user) { ?>
            <!--==============table data====================-->
              <div class="table-row">
                <div class="table-data flex-basis15 text-left p-info">
                  <span class="user-name"><?= !empty($user->display_name)?h($user->display_name):'' ?></span>
                  <span class="ell"  class="d-inline-block" tabindex="0" data-toggle="tooltip" title="<?php echo $user->email;?>"><?= !empty($user->email)?h($user->email):'' ?></span>
                  <span class="user-contact"><?= !empty($user->phone)?h($user->country_code).'&nbsp;'.h($user->phone):''; ?>
                  </span>
                  <?php if($showPassword){ 
                    if(empty($user->fb_id)){ 
                  ?>
                  <span class="ell user-password d-inline-block" tabindex="0" data-toggle="tooltip" title="<?php echo ApiHasher::dehash($user->password);?>"><?= !empty($user->password)?'Pass->'.h(ApiHasher::dehash($user->password)):'' ?></span>
                  <?php } ?>
                  <span class="ell">
                    <a href="javascript:void(0)" class="pop change-password-text" page="<?php echo Router::url(['Controller' => 'Users', 'action'=> 'adminResetPassword',$user->id]);?>">Change Password</a>
                  </span>
                  <?php } ?>
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
          } else { ?>
            <div class="no-data-wrapper">
              <div class="no-data no-user" >
                  <?php echo $this->Html->image('no-result.png', ["alt" => "", 'class' =>'mb-30' ]);?>
                  <h2>No Result Found!</h2>
                  <p>Try with different keywords to find what you're looking for.</p>
              </div>
            </div>
          <?php } ?>
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
            <?php echo $this->Html->image('no-user.png', ["alt" => "", 'class' =>'mb-30' ]);?>
            <h2>No Users Found!</h2>
            <p>Seems like no user has created the account yet!</p>
            <p class="hide">Try with different keywords to find what you're looking for.</p>
        </div>
      </div>
    <?php } ?>
</section>
<?php echo $this->Html->script(['admin/admin-manage-user']); ?>