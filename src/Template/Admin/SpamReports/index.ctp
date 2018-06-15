<?php
use Cake\Routing\Router;
use Cake\Core\Configure;

$manageSpamReportCount = $filter = false;
if (count($spamReports) > 0)
    $manageSpamReportCount = true;
if ($this->request->query())
    $filter = true;
$breadcrumbsTxt = '';
$chat_msg_type = unserialize(CHAT_MSG_TYPE);
$matrixconfig = Configure::read('MATRIX');
$matrixImgUrl = $matrixconfig['url'] . '/media/v1/thumbnail/';
$matrixImgUrlQueryString = '?width=0&height=0&method=scale';
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
                        <span>Comment</span>
                    </div> 
                    <div class="head-text flex-basis30 text-left">                        
                        <span>Warps</span>
                    </div>
                    <div class="head-text flex-basis15 text-left"><span>Reported Spam User</span></div>
                    <div class="head-text flex-basis15"><span>No. of Users Reported Spam</span></div>
                    <div class="head-text flex-basis10"><span>Action</span></div>
                </div>
                <input type="hidden" id="set_status">
                <div id="<?= BANNED; ?>_image" style="display: none"><?= $this->Html->image("user_banned.svg", ['alt' => '']) ?></div>
                <div id="<?= UNBANNED; ?>_image" style="display: none"><?= $this->Html->image("user_unbanned.svg", ['alt' => '']) ?></div>
                <?php
                if ($manageSpamReportCount) {
                    foreach ($spamReports as $spamReport) {
                        $getMatrixObj = $this->Custom->getMatrixObj(trim($spamReport->event_id));
                        $getUserObj = $this->Custom->getUserObj(trim($spamReport->reported_to));
                        $getJsStatus = $this->Custom->getJoinedSpaycObj(trim($spamReport->spayc_id), trim($spamReport->reported_to));
                        $content = json_decode($getMatrixObj['content'], true);
                        ?>
                        <!--==============table data====================-->
                        <div class="table-row">
                           
                            <div class="table-data flex-basis30 text-left">        
                                <?php
                                if ((strtolower($content['msgtype']) == strtolower($chat_msg_type['text'])) || (strtolower($content['msgtype']) == strtolower($chat_msg_type['replytext'])) || (strtolower($content['msgtype']) == strtolower($chat_msg_type['replyimage']))) {
                                $txtMsg = (strtolower($content['msgtype']) == $chat_msg_type['text']) ?  preg_replace( "/\r|\n/", " ", $content['body'] ): preg_replace( "/\r|\n/", " ", $content['replyString'] );
                                    ?>
                                    <span><?=
                                    !empty($txtMsg) ? $this->Text->truncate(h($txtMsg), 25, ['ellipsis' => '...',
                                                'exact' => false]) : BLANK
                                    ?></span>
                                    <?php if (!empty($txtMsg) && (strlen($txtMsg) > 25)) { ?>
                                        <span>
                                            <a href="javascript:void(0)" onclick="showModel('<?= h($txtMsg) ?>', 'Comment');" class="item-read-more">+ Read more</a>
                                            

                                        </span>
                                        <?php }
                                    } else if (strtolower($content['msgtype']) == $chat_msg_type['image']) { ?>
                                    <span class="spam-report-img">
                <?php
                echo $this->Html->image($matrixImgUrl . str_replace("mxc://", "", $content['url']) . $matrixImgUrlQueryString, ['alt' => '']);
                ?>
                                    </span>

            <?php } ?>

                            </div>
                             <div class="table-data flex-basis30 text-left">
                                <span><?= !empty($spamReport['spayc']['name']) ? ucwords($spamReport['spayc']['name']) : '' ?></span>
                            </div>
                            <div class="table-data flex-basis15">
                                <span><?= !empty($getUserObj['display_name']) ? ucwords($getUserObj['display_name']) : '' ?></span>
                            </div>
                            <div class="table-data flex-basis15">
                                <span><?= !empty($spamReport['total_user_reported_by']) ? ($spamReport['total_user_reported_by']) : BLANK_COUNT ?></span>
                            </div>

                            <?php
                            $txt = "Ban";
                            $imgTxt = 'user_unbanned.svg';
                            $banStatus = BANNED;
                            if ($getJsStatus == BANNED) {
                                $txt = "Unban";
                                $imgTxt = 'user_banned.svg';
                                $banStatus = UNBANNED;
                            }
                            $popupClass = '';
                            $parentClass ='disabled';
                            if (trim($spamReport['total_user_reported_by']) >= 5) {
                                    $popupClass ='pop';
                                    $parentClass ='';
                            } else {
                                $imgTxt = 'user_disable.svg'; 
                            }
                            ?>

                            <div class="table-data flex-basis10">
                                <span>
                                    <div class="tooltip-top <?= $parentClass ?>">
                                        <a href="javascript:void(0)" onClick="setStatus('<?= $banStatus; ?>')" rel="modal-dialog-xs confirm-message" class="dropdown-item <?= $popupClass?> status_div_<?= !empty($popupClass) ? $spamReport['spayc']['id'] . '-' . $spamReport->reported_to : '' ?>" page="<?php echo $this->Url->build(["controller" => "SpamReports", "action" => "banSpaycMember", $spamReport['spayc']['id'], $spamReport->reported_to]); ?>"><i class='icon-block'></i><span class="status_<?= !empty($popupClass) ? $spamReport['spayc']['id'] . '-' . $spamReport->reported_to : '' ?>"><?= $this->Html->image($imgTxt, ['alt' => '']) ?></span>
                                        </a>
                                        <span class="tooltiptext t_status_<?= !empty($popupClass) ? $spamReport['spayc']['id'] . '-' . $spamReport->reported_to : '' ?>"><?= $txt ?></span>
                                    </div>
                                </span>
                            </div>
                        </div>            
            <?php
        }
    } else {
        ?>
                    <div class="no-data-wrapper">
                        <div class="no-data no-user" >
                    <?php echo $this->Html->image('no-spam-report.png', ["alt" => "", 'class' => 'mb-30']); ?>
                            <h2>No Result Found!</h2>
                            <p>Try with different keywords to find what you're looking for.</p>
                        </div>
                    </div>
                    <?php } ?>

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