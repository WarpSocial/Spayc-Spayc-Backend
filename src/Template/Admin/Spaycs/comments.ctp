<?php

use Cake\Routing\Router;
use Cake\Core\Configure;
$commentsCount=false;
$totalComments='';
if(count($comments) > 0){ 
    $totalComments = count($comments);
    $commentsCount=true; 
}
$breadcrumbsTxt='Comments';
$chat_msg_type = unserialize(CHAT_MSG_TYPE);
$matrixconfig = Configure::read('MATRIX');
$matrixImgUrl = $matrixconfig['url'] . '/media/v1/thumbnail/';
$matrixImgUrlQueryString = '?width=0&height=0&method=scale';

            /*** breadcrumbs***/
 echo $this->element('admin/breadcrumbs', ['action'=> $breadcrumbsTxt]);
?>

<section class="content-wrapper content-filter">
    <!--============= table head ===================-->
    <div class="container">        
        <div class="comment-wrapper">      
            <h2>Comments <?= !empty($totalComments)?'('.$totalComments.')':'';?></h2>  
            <?php 
            if($commentsCount) {          
                foreach ($comments as $comment) {
                    $content = json_decode($comment['content'],true);
                    $userInfo = $this->Custom->getSenderInfo(trim($comment->sender));
                    $likeDislike = $this->Custom->getmsgLikeDislike($comment['room_id'], $comment['event_id']);
                    $getChatReply = $this->Custom->getChatReply($comment['room_id'], $comment['event_id']);
                    $userImg = !empty($userInfo['user_images']) ? $userInfo['user_images']['0']['image_url']:'user.jpg';
            ?>
            <div class="comment-list-wrapper ">
                <div class="comment-list">
                    <div class="comment-image">
                        <span><?= $this->Html->image($userImg, ['alt' => ''])?></span>
                    </div>
                    <div class="comment-data">
                        <h4><?= !empty($userInfo['display_name'])? ucwords($userInfo['display_name']): '' ?></h4>
                        <?php if(strtolower($content['msgtype']) == $chat_msg_type['text']) { ?>
                        <p><?= !empty($content['body'])? trim($content['body']): '' ?></p>
                        <p><?= $this->Custom->getChatMsgDate($comment['origin_server_ts']); ?></p>
                        <?php } else if(strtolower($content['msgtype']) == strtolower($chat_msg_type['image'])) { ?>
                        <div class="comment-reply-image">
                            <div class="image-reply d-flex flex-nowrap">
                                <div class="user-reply-image-content">
                                    <span>
                                    <?= $this->Html->image($matrixImgUrl.str_replace("mxc://", "", $content['url']) . $matrixImgUrlQueryString, ['alt' => ''])?>
                                    </span>
                                    <p><?= $this->Custom->getChatMsgDate($comment['origin_server_ts']); ?></p>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>                    
                    <div class="comment-action">
                        <span class="like"><?= $likeDislike['like'] ?></span>
                        <span class="dislike"><?= $likeDislike['dislike'] ?></span>
                    </div>
                </div>
                <?php if(!empty($getChatReply)) {
                    $html = $this->Custom->getChatReplyText($getChatReply);
                    echo  $html;    
                ?>

                <?php } ?>
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
            <?php echo $this->Html->image('no-comments.png', ["alt" => "", 'class' =>'mb-30' ]);?>
            <h2>No Comments Found!</h2>
            <p>Seems like no user has commented the warp yet!</p>
        </div>
    </div>
    <?php } ?>
</section>
<?php echo $this->Html->script(['admin/admin-manage-user']); ?>