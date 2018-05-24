<?php 
use Cake\Routing\Router;
$spaycsCount=$filter=false;
if(count($spaycs) > 0) 
  $spaycsCount=true; 
if($this->request->query())
  $filter=true;
 
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
      <div class="breadcrumbs">
        <div class="container">
          <h4>Manage Warps</h4>
          <p class="hide"><span>manage</span> <span>user</span></p>
        </div>
      </div>

<section class="content-wrapper content-filter">
 <span class="error-alert users-msg header-alert" style="display: none;"></span>
        <!--===========filter================-->
        <?php if($spaycsCount || $filter){ 
                echo $this->element('admin/user-filter', ['userFilter'=> false]);
        ?>
      <!--============= table head ===================-->
      <div class="container">        
        <div class="table-wrapper">      
          <div class="table-head">
            <div class="head-text flex-basis12 text-left p-info">
            <span class="table-filter"><?php echo $this->Paginator->sort('name','Spayc').'&nbsp;<i>'.$this->Paginator->sort('name',$this->Html->image($nameIconSorting, ['alt' => 'icon']),['escape' => false]).'</i>';?>     
            </span>
            </div>
            <div class="head-text flex-basis12 text-left">
              <span class="table-filter"><?php echo $this->Paginator->sort('spayc_admin','Admin').'&nbsp;<i>'.$this->Paginator->sort('spayc_admin',$this->Html->image($disNameSorting, ['alt' => 'icon']),['escape' => false]).'</i>';?></span>
            </div>
            <div class="head-text flex-basis10 text-left"><span class="table-filter"><?php echo $this->Paginator->sort('start_date','Date & Time').'&nbsp;<i>'.$this->Paginator->sort('start_date',$this->Html->image($dateIconSorting, ['alt' => 'icon']),['escape' => false]).'</i>';?></span>
            </div>
            <div class="head-text flex-basis13 text-left"><span>Address</span></div>
            <div class="head-text flex-basis7"><span>Members</span></div>
            <div class="head-text flex-basis10"><span>Subscribed Members</span></div>
            <div class="head-text flex-basis12"><span>Physical People Present</span></div>
            <div class="head-text flex-basis9"><span>Number of Subspaycs</span></div>
            <div class="head-text flex-basis9"><span>Number of Comment </span></div>
            <div class="head-text flex-basis6"><span class="blank"></span></div>
          </div>
          <?php   if ($spaycsCount) {?>  
            <?php foreach($spaycs as $spayc) { ?>
            <!--==============table data====================-->
              <div class="table-row">               
                <div class="table-data flex-basis12 text-left">
                  <span class="data-name"><?= !empty($spayc->name)?h(ucwords($spayc->name)):BLANK ?></span>
                </div>
                <div class="table-data flex-basis12 text-left">
                  <span><?= !empty($spayc->spayc_admin)?h(ucwords($spayc->spayc_admin)):BLANK ?></span>
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
                  <span><?= !empty($spayc->total_subscribed_users)?trim($spayc->total_subscribed_users):BLANK_COUNT ?></span>
                </div>

                 <div class="table-data flex-basis12">
                  <span><?= !empty($spayc->total_presents)?trim($spayc->total_presents):BLANK_COUNT ?></span>
                </div>
                <div class="table-data flex-basis9">
                    <span><?= !empty($spayc->total_subspaycs)?trim($spayc->total_subspaycs):BLANK_COUNT ?></span>
                </div>
                <div class="table-data flex-basis9">
                  <span><?= !empty($spayc->total_comments)?trim($spayc->total_comments):BLANK_COUNT ?></span>
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
                      <button class="dropdown-item block hide"> <i class="icon-block"></i>Block</button>
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
            <h2>No Warp Found!</h2>
            <p>Seems like no user has created the warp yet!</p>
        </div>
      </div>
    <?php } ?>
</section>
<?php echo $this->Html->script(['admin/user','admin/admin-manage-user']); ?>