<?php 
use Cake\Routing\Router;
$statusArr = unserialize(STATUS_ARR);
$txtMassage = unserialize(TEXT_MASSAGE);  
$spaycsCount=$filter=false;
if(count($spaycs) > 0) 
  $spaycsCount=true; 
if($this->request->query())
  $filter=true;
 $breadcrumbsTxt='';
 $nameIconSorting=$dateIconSorting=$disNameSorting='filter.png';
if(isset($this->request->query['sort'])) {

    if(($this->request->query['sort'] == 'name') && ($this->request->query['direction'] == 'asc')) 
        $nameIconSorting = 'filter-up.png';
    else if(($this->request->query['sort'] == 'name') && ($this->request->query['direction'] == 'desc')) 
        $nameIconSorting = 'filter-down.png';
    
    if(($this->request->query['sort'] == 'start_date') && ($this->request->query['direction'] == 'asc')) 
        $dateIconSorting = 'filter-up.png';
    else if(($this->request->query['sort'] == 'start_date') && ($this->request->query['direction'] == 'desc')) 
        $dateIconSorting = 'filter-down.png';
    
    if(($this->request->query['sort'] == 'display_name') && ($this->request->query['direction'] == 'asc')) 
        $disNameSorting = 'filter-up.png';
    else if(($this->request->query['sort'] == 'display_name') && ($this->request->query['direction'] == 'desc')) 
        $disNameSorting = 'filter-down.png';
}
?>
<!--=============breadcrumbs==============-->      
<?php echo $this->element('admin/breadcrumbs', ['action'=> $breadcrumbsTxt]);?>

<section class="content-wrapper content-filter main-spayc-div">
<span class="error-alert alert-fixed-position spaycs-msg header-alert" style="display: none;"></span>
        <!--===========filter================-->
        <?php if($spaycsCount || $filter){ 
                echo $this->element('admin/user-filter', ['userFilter'=> false]);
        ?>
      <!--============= table head ===================-->
      <div class="container">        
        <div class="table-wrapper">      
          <div class="table-head">
            <div class="head-text flex-basis12 text-left p-info">
            <span class="table-filter"><?php echo $this->Paginator->sort('name','Warps').'&nbsp;<i>'.$this->Paginator->sort('name',$this->Html->image($nameIconSorting, ['alt' => 'icon']),['escape' => false]).'</i>';?>     
            </span>
            </div>
            <div class="head-text flex-basis12 text-left">
              <span class="table-filter"><?php echo $this->Paginator->sort('Users.display_name','Admin').'&nbsp;<i>'.$this->Paginator->sort('Users.display_name',$this->Html->image($disNameSorting, ['alt' => 'icon']),['escape' => false]).'</i>';?></span>
            </div>
            <div class="head-text flex-basis10 text-left"><span class="table-filter"><?php echo $this->Paginator->sort('start_date','Date & Time').'&nbsp;<i>'.$this->Paginator->sort('start_date',$this->Html->image($dateIconSorting, ['alt' => 'icon']),['escape' => false]).'</i>';?></span>
            </div>
            <div class="head-text flex-basis13 text-left"><span>Address</span></div>
            <div class="head-text flex-basis7"><span>Members</span></div>
            <div class="head-text flex-basis10"><span>Subscribed Members</span></div>
            <div class="head-text flex-basis12"><span>Physical People Present</span></div>
            <div class="head-text flex-basis9"><span>Number of Subwarps</span></div>
            <div class="head-text flex-basis9"><span>Number of Comment </span></div>
            <div class="head-text flex-basis6"><span class="blank"></span></div>
          </div>
          <?php   if ($spaycsCount) {?>  
            <?php 
              $totalAdmin = '';
              foreach($spaycs as $spayc) { 
              $totalAdmin = count($spayc['total_spayc_admin']);
              $blocktxt =(ucfirst($spayc->status) == $statusArr['active'])?"Block":"Unblock";
              ?>
            <!--==============table data====================-->
              <div class="table-row spayc-div-listing <?php echo $blocktxt =='Block'?'':'disabled';?>">
                <div class="table-data flex-basis12 text-left">
                  <span class="data-name"><?= !empty($spayc->name)?h(ucwords($spayc->name)):BLANK ?></span>
                </div>
                <div class="table-data flex-basis12 text-left">
                  <span><?= !empty($spayc->spayc_admin)?h(ucwords($spayc->spayc_admin)):BLANK ?></span>
                  <?php if($totalAdmin > 1) { ?>
                  <div id="admin_<?=$spayc->id?>" class="hide"><?= $this->element('admin/adminpopuptxt',['total_spayc_admin'=>$spayc['total_spayc_admin']])?></div>
                  <span>
                  <a href="javascript:void(0)" onclick="showAdmin('<?=$spayc->id?>', '<?=$totalAdmin?>');" class="item-read-more count">+ <?= ($totalAdmin -1)?></a>
                  </span>
                  <?php } ?>
                </div>

                <div class="table-data flex-basis10 text-left">
                  <span><?= !empty($this->dateFormat($spayc->start_date))?$this->dateFormat($spayc->start_date):BLANK ?></span>
                  <span><?= !empty($this->dateFormat($spayc->start_date))?$this->dateFormat($spayc->start_date, TIMEFORMAT_SPAYC):BLANK ?></span>
                </div>

                <div class="table-data flex-basis13 text-left">
                  <span><?= !empty($spayc->location)?h($spayc->location):BLANK ?></span>
                </div>

                 <div class="table-data flex-basis7">
                  <span><?= !empty($spayc->joined_users)?$this->Html->link($spayc->joined_users,['controller' => 'Spaycs', 'action' => 'spayc-members',$spayc->id], ['class' => 'num-letter-spacing']):BLANK_COUNT ?></span>
                </div>
                <div class="table-data flex-basis10">
                  <span><?= !empty($spayc->total_subscribed_users)?$this->Html->link($spayc->total_subscribed_users,['controller' => 'Spaycs', 'action' => 'subscribedMembers',$spayc->id], ['class' => 'num-letter-spacing']):BLANK_COUNT ?></span>
                </div>

                 <div class="table-data flex-basis12">                 
                  <span><?= !empty($spayc->total_presents)?$this->Html->link($spayc->total_presents,['controller' => 'Spaycs', 'action' => 'physicalPresents',$spayc->id], ['class' => 'num-letter-spacing']):BLANK_COUNT ?></span>
                </div>
                <div class="table-data flex-basis9">
                    <span><?= !empty($spayc->total_subspaycs)?$this->Html->link($spayc->total_subspaycs,['controller' => 'Spaycs', 'action' => 'subwarps',$spayc->id], ['class' => 'num-letter-spacing']):BLANK_COUNT ?></span>
                </div>
                <div class="table-data flex-basis9">
                  <span><?= !empty($spayc->total_comments)?trim($spayc->total_comments):BLANK_COUNT ?></span>
                </div>
                <!--table dropdown-->
                <div class="table-data flex-basis6">
                  <div class="dropdown table-view-dropdown">
                    <div class="table-dropdown"  id="table-data-dropdown_<?= $spayc->id?>" data-toggle="dropdown">
                      <span></span>
                      <span></span>
                      <span></span>
                    </div>
                  <div class="dropdown-menu" aria-labelledby="table-data-dropdown_<?= $spayc->id?>">                    
                    <?= $this->Html->link("<i class='icon-view'></i>View",['controller' => 'Spaycs', 'action' => 'view',$spayc->id,$spayc->user_id], ['class' => 'dropdown-item view','escape' => false]);?>  
                    <a href="javascript:void(0)" rel="modal-dialog-xs confirm-message" class="pop dropdown-item status_<?= $spayc->id?> <?= strtolower($blocktxt)?>" page="<?php echo $this->Url->build(["controller" => "Spaycs","action" => "setSpaycStatus",$spayc->id]);?>"><i class='icon-block'></i><span class="status_<?= $spayc->id?>"><?= $blocktxt?></span>
                      </a> 
                      <a href="javascript:void(0)" rel="modal-dialog-xs confirm-message" class="pop dropdown-item delete" page="<?php echo $this->Url->build(["controller" => "Spaycs","action" => "deleteSpayc",$spayc->id]);?>"><i class='icon-Delete'></i>
                      <span>Delete</span></a> 
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
            <?php echo $this->Html->image('no-spayc.png', ["alt" => "", 'class' =>'mb-30' ]);?>
            <h2>No Warp Found!</h2>
            <p>Seems like no user has created the warp yet!</p>
        </div>
      </div>
    <?php } ?>
    <div id="no-spayc" class="hide">       
    <div class="no-data-wrapper" >
        <div class="no-data no-spayc">          
          <?php echo $this->Html->image('no-spayc.png', ["alt" => "", 'class' =>'mb-30' ]);?>
          <h2> No Spayc Found!</h2>
          <p>Seems like no user has created the spayc yet!</p>
        </div>
      </div>
   </div>
</section>
<?php echo $this->Html->script(['admin/spayc','admin/admin-manage-user']); ?>