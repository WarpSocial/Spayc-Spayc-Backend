<?php 
use Cake\Routing\Router;
use Api\Auth\ApiHasher;
$statusArr = unserialize(STATUS_ARR);
$messagesCount=$showPassword=$filter=false;
if(count($messages) > 0) 
  $messagesCount=true; 
if($this->request->query('debug')&&$this->request->query('debug')=='on')
  $showPassword=true;
if($this->request->query())
  $filter=true;

$breadcrumbsTxt = (isset($currUser) && !empty($currUser)) ? 'friends of '.ucwords($currUser->display_name):''; 
$genderIconSorting=$usernameIconSorting=$createdIconSorting=$dobIconSorting='filter.png';
if(isset($this->request->query['sort'])) {

    if(($this->request->query['sort'] == 'display_name') && ($this->request->query['direction'] == 'asc')) 
        $usernameIconSorting = 'filter-up.png';
    else if(($this->request->query['sort'] == 'display_name') && ($this->request->query['direction'] == 'desc')) 
        $usernameIconSorting = 'filter-down.png';
    
    if(($this->request->query['sort'] == 'gender') && ($this->request->query['direction'] == 'asc')) 
        $genderIconSorting = 'filter-up.png';
    else if(($this->request->query['sort'] == 'gender') && ($this->request->query['direction'] == 'desc')) 
        $genderIconSorting = 'filter-down.png';
    
    if(($this->request->query['sort'] == 'dob') && ($this->request->query['direction'] == 'asc')) 
        $dobIconSorting = 'filter-up.png';
    else if(($this->request->query['sort'] == 'dob') && ($this->request->query['direction'] == 'desc')) 
        $dobIconSorting = 'filter-down.png';
    
    if(($this->request->query['sort'] == 'created') && ($this->request->query['direction'] == 'asc')) 
        $createdIconSorting = 'filter-up.png';
    else if(($this->request->query['sort'] == 'created') && ($this->request->query['direction'] == 'desc')) 
        $createdIconSorting = 'filter-down.png';
    
}
?>

<!--=============breadcrumbs==============-->      
<?php echo $this->element('admin/breadcrumbs', ['action'=> $breadcrumbsTxt]);?>
<section class="content-wrapper content-filter">
 <span class="success-alert alert-fixed-position users-msg header-alert" style="display: none;"></span>
        <!--===========filter================-->
        <?php if($messagesCount || $filter){ 
             //   echo $this->element('admin/user-filter', ['userFilter'=> true]);
        ?>
      <!--============= table head ===================-->
      <div class="container">        
        <div class="table-wrapper">      
           <div class="table-head">
            <div class="head-text flex-basis40 text-left"><span>Message</span></div>
            <div class="head-text flex-basis20 text-left"><span>Date & Time</span></div>
            <div class="head-text flex-basis10"><span>No Of User</span></div>
            <div class="head-text flex-basis13 ml-auto text-left"><span>Action</span></div>
          </div>
          <?php   if ($messagesCount) {?>  
            <?php foreach($messages as $message) { ?>
            <!--==============table data====================-->

<div class="table-row">
            <div class="table-data d-flex-a-center flex-basis40 text-left">
              <span id="msg_<?=$message['id'];?>"><?=$message['message'];?></span>
            </div>
            <div class="table-data flex-basis20 text-left">
<!--              <span>Nov 09, 2017</span>
              <span>3:24 AM</span>-->
                   <span><?= !empty($this->dateFormat($message['created']))?$this->dateFormat($message['created']):BLANK ?></span>
                  <span><?= !empty($this->dateFormat($message['created']))?$this->dateFormat($message['created'], TIMEFORMAT_SPAYC):BLANK ?></span>
                
            </div>
            <div class="table-data flex-basis10 ">
                <?php $count=count(explode(",",$message['user_id']));?>
              <span><?=$count;?></span>
            </div>
            <div class="table-data flex-basis13 ml-auto text-left">
              <span>
                  <button type="button" onclick="getUsers('<?=$message['user_id'];?>','<?=$message['id'];?>')" rel="modal-dialog-lg" class="pop button message-creation btn-sm" page="<?php echo $this->Url->build(["controller" => "CustomMessages","action" => "getCustomMessage"]);?>">Resend</button>
              </span>
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
<?php echo $this->Html->script(['admin/user','admin/admin-manage-user']); ?>
<?php echo $this->Html->script(['admin/user','select2.min']); ?>

<?php echo $this->Html->script(['admin/spayc','admin/custom-messages']); ?>