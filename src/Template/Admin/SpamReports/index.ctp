<?php

use Cake\Routing\Router;

$manageSpamReport = 1;
$manageSpamReportCount = $filter = false;
if (count($spamReports) > 0)
    $manageSpamReportCount = true;
if ($this->request->query())
    $filter = true;
$breadcrumbsTxt = '';
$nameIconSorting = 'filter.png';
if (isset($this->request->query['sort'])) {

    if (($this->request->query['sort'] == 'name') && ($this->request->query['direction'] == 'asc'))
        $nameIconSorting = 'filter-up.png';
    else if (($this->request->query['sort'] == 'name') && ($this->request->query['direction'] == 'desc'))
        $nameIconSorting = 'filter-down.png';
}
?>
<!--=============breadcrumbs==============-->      
<?php echo $this->element('admin/breadcrumbs', ['action' => $breadcrumbsTxt]); ?>

<section class="content-wrapper content-filter">
    <span class="error-alert alert-fixed-position spaycs-msg header-alert" style="display: none;"></span>
    <!--===========filter================-->
    <?php
    if ($manageSpamReportCount || $filter) {
        echo $this->element('admin/user-filter', ['userFilter' => false]);
        ?>
        <!--============= table head ===================-->
        <div class="container">        
            <div class="table-wrapper">      
                <div class="table-head">
                    <div class="head-text flex-basis30 text-left">
                        <span class="table-filter"><?php echo $this->Paginator->sort('name', 'Warps') . '&nbsp;<i>' . $this->Paginator->sort('name', $this->Html->image($nameIconSorting, ['alt' => 'icon']), ['escape' => false]) . '</i>'; ?>     
                        </span>
                    </div>
                    <div class="head-text flex-basis30 text-left">
                        <span>Comment</span>
                    </div>                
                    <div class="head-text flex-basis15 text-left"><span>Reported Spam User</span></div>
                    <div class="head-text flex-basis15"><span>No. of Users Reported Spam</span></div>
                    <div class="head-text flex-basis10"><span>Action</span></div>
                </div>
                <?php
                if ($manageSpamReportCount) {
                    foreach ($spamReports as $spamReport) {
                        $getMatrixObj = $this->Custom->getMatrixObj(trim($spamReport->event_id));
                        $getUserObj = $this->Custom->getUserObj(trim($spamReport->reported_to));
                        $content = json_decode($getMatrixObj['content'], true);
                        ?>
                        <!--==============table data====================-->
                        <div class="table-row">
                            <div class="table-data flex-basis30 text-left">
                                <span><?= !empty($spamReport['spayc']['name']) ? ucwords($spamReport['spayc']['name']) : '' ?></span>
                            </div>
                            <div class="table-data flex-basis30 text-left">                    
                                <span><?= !empty($content['body']) ? $this->Text->truncate(h($content['body']), 25, ['ellipsis' => '...',
                                    'exact' => false]) : BLANK
                        ?></span>
                                <?php if (!empty($content['body']) && (strlen($content['body']) > 25)) { ?>
                                    <span>
                                        <a href="javascript:void(0)" onclick="showModel('<?= h($content['body']) ?>', 'Comment');" class="item-read-more">+ Read more</a>
                                    </span>
                                <?php } ?>

                            </div>
                            <div class="table-data flex-basis15">
                                <span><?= !empty($getUserObj['display_name']) ? ucwords($getUserObj['display_name']) : '' ?></span>
                            </div>
                            <div class="table-data flex-basis15">
                                <span><?= !empty($spamReport['total_user_reported_by']) ? ($spamReport['total_user_reported_by']) : BLANK_COUNT ?></span>
                            </div>
                            <div class="table-data flex-basis10">
                                <span>
                                    <div class="tooltip-top disabled">
                                        <a href="javascript:void(0)" rel="modal-dialog-xs confirm-message" class="pop dropdown-item status_<?= $spamReport['spayc']['id']?>" page="<?php echo $this->Url->build(["controller" => "SpamReports","action" => "banSpaycMember",$spamReport['spayc']['id'],$spamReport->reported_to,BANNED]);?>"><i class='icon-block'></i><span class="status_<?= $spamReport['spayc']['id']?>"><?= $this->Html->image('icon_user_approved.svg', ['alt' => '']) ?></span>
                                        </a>
                                        <span class="tooltiptext">ban</span>
                                    </div>
                                </span>
                            </div>
                        </div>            
                        <?php
                    }
                }
                ?>
                    <?php if ($this->Paginator->params()['pageCount'] > 1) { ?>
                    <ul class="pagination table-pagination">
                    <?= $this->Paginator->prev('', ['escape' => false]) ?>
        <?= $this->Paginator->numbers(array('modulus' => 4)) ?>
            <?= $this->Paginator->next('', ['escape' => false]) ?>
                    </ul>
    <?php } ?>
            </div>      
        </div>
<?php } else { ?>
        <div class="no-data-wrapper">
            <div class="no-data no-user" >
        <?php echo $this->Html->image('no-spam-report.png', ["alt" => "", 'class' => 'mb-30']); ?>
                <h2>Hooray, no spam here!</h2>
                <p>Seems like no user has reported spam yet!</p>
            </div>
        </div>
<?php } ?>
</section>
<?php echo $this->Html->script(['admin/admin-manage-user']); ?>