<?php
use Cake\Routing\Router;
$manageSpamReport=1;
$manageSpamReportCount=$filter=false;
if(count($manageSpamReport) > 0) 
  $manageSpamReportCount=true; 
if($this->request->query())
  $filter=true;
$breadcrumbsTxt='Manage Spam Report';
$nameIconSorting='filter.png';
if(isset($this->request->query['sort'])) {
    
    if(($this->request->query['sort'] == 'name') && ($this->request->query['direction'] == 'asc')) 
        $nameIconSorting = 'filter-up.png';
    else if(($this->request->query['sort'] == 'name') && ($this->request->query['direction'] == 'desc')) 
        $nameIconSorting = 'filter-down.png';
}
?>
<!--=============breadcrumbs==============-->      
<?php echo $this->element('admin/breadcrumbs', ['action'=> $breadcrumbsTxt]);?>

<section class="content-wrapper content-filter">
    <span class="error-alert alert-fixed-position spaycs-msg header-alert" style="display: none;"></span>
    <!--===========filter================-->
    <?php if($manageSpamReportCount || $filter) { 
            echo $this->element('admin/user-filter', ['userFilter'=> false]);
    ?>
    <!--============= table head ===================-->
    <div class="container">        
        <div class="table-wrapper">      
            <div class="table-head">
                <div class="head-text flex-basis30 text-left">
                    <span class="table-filter"><?php echo $this->Paginator->sort('name','Warps').'&nbsp;<i>'.$this->Paginator->sort('name',$this->Html->image($nameIconSorting, ['alt' => 'icon']),['escape' => false]).'</i>';?>     
                    </span>
                </div>
                <div class="head-text flex-basis30 text-left">
                    <span class="table-filter">Comment</span>
                </div>                
                <div class="head-text flex-basis15 text-left"><span>Reported Spam User</span></div>
                <div class="head-text flex-basis15"><span>No. of Users Reported Spam</span></div>
                <div class="head-text flex-basis10"><span>Action</span></div>
            </div>
          <?php   //if ($manageSpamReportCount) {?>  
            <?php 
//              $totalAdmin = '';
              //foreach($manageSpamReport as $spayc) { 
//              $totalAdmin = count($spayc['total_spayc_admin']);
//              $blocktxt =(ucfirst($spayc->status) == $statusArr['active'])?"Block":"Unblock";
              ?>
            <!--==============table data====================-->
            <div class="table-row">
                <div class="table-data flex-basis30 text-left">
                    <span>Test Warp</span>
                </div>
                <div class="table-data flex-basis30 text-left">
                    <span class="user-name">Bsnznanzn nsjs nsns nsns nsns bzns s bznz nsnsns Bsnznanzn nsjs nsns nsns nsns bzns s bznz nsnsns Bsnznanzn nsjs nsns nsns nsns bzns s bznz nsnsns <a href="javascript:void(0)" class="item-read-more">+ Read more</a></span>
                </div>
                <div class="table-data flex-basis15">
                    <span>Antanio Bowman</span>
                </div>
                <div class="table-data flex-basis15">
                    <span>5</span>
                </div>
                <div class="table-data flex-basis10">
                    <span>Ban</span>
                </div>
            </div>
            <div class="table-row">
                <div class="table-data flex-basis30 text-left">
                    <span>Test Warp</span>
                </div>
                <div class="table-data flex-basis30 text-left">
                    <span class="user-name">Bsnznanzn nsjs nsns nsns nsns bzns s bznz nsnsns Bsnznanzn nsjs nsns nsns nsns bzns s bznz nsnsns Bsnznanzn nsjs nsns nsns nsns bzns s bznz nsnsns</span>
                </div>
                <div class="table-data flex-basis15">
                    <span>Antanio Bowman</span>
                </div>
                <div class="table-data flex-basis15">
                    <span>5</span>
                </div>
                <div class="table-data flex-basis10">
                    <span>Ban</span>
                </div>
            </div>
            <div class="table-row">
                <div class="table-data flex-basis30 text-left">
                    <span>Test Warp</span>
                </div>
                <div class="table-data flex-basis30 text-left">
                    <span class="user-name">Bsnznanzn nsjs nsns nsns nsns bzns s bznz nsnsns Bsnznanzn nsjs nsns nsns nsns bzns s bznz nsnsns Bsnznanzn nsjs nsns nsns nsns bzns s bznz nsnsns</span>
                </div>
                <div class="table-data flex-basis15">
                    <span>Antanio Bowman</span>
                </div>
                <div class="table-data flex-basis15">
                    <span>5</span>
                </div>
                <div class="table-data flex-basis10">
                    <span>
                        <div class="tooltip-top disabled">
                            <a href="#"><img src="../../images/delete-red.png"</a>
                            <span class="tooltiptext">ban</span>
                        </div>
                    </span>
                </div>
            </div>
            <?php
            // }           
            // }
            ?>
          <?php //if($this->Paginator->params()['pageCount'] > 1) { ?>
            <ul class="pagination table-pagination">
                <?php //$this->Paginator->prev('',['escape' => false]) ?>
                <?php //$this->Paginator->numbers(array('modulus' => 4)) ?>
                <?php // $this->Paginator->next('',['escape' => false]) ?>
            </ul>
          <?php //} ?>
        </div>      
    </div>
    <?php }  else { ?>
    <div class="no-data-wrapper">
        <div class="no-data no-user" >
            <?php echo $this->Html->image('no-spam-report.png', ["alt" => "", 'class' =>'mb-30' ]);?>
            <h2>Hooray, no spam here!</h2>
            <p>Seems like no user has reported spam yet!</p>
        </div>
    </div>
    <?php } ?>
</section>
<?php echo $this->Html->script(['admin/admin-manage-user']); ?>