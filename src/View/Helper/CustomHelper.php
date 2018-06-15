<?php
namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;
use Cake\Routing\Router;
use Cake\View\Helper\HtmlHelper;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

class CustomHelper extends Helper {

	public $helpers = ['Html'];
        
        public function getMatrixObj($eventId){
            $res = '';
            if(!empty($eventId)){
                $eventsRepo = TableRegistry::get('Events');
                $query = $eventsRepo->find()->where(['event_id'=>$eventId,'type'=>CHAT_ROOM_TYPE]);
                $res = $query->first();
            }
            return $res;
        }
        
        public function getUserObj($userId){
            $res = '';
            if(!empty($userId)){
                $usersRepo = TableRegistry::get('Users');
                $res = $usersRepo->get($userId);
            }
            return $res;
        }
	
	public function getmsgLikeDislike($roomId, $eventId) {
            $like=$dislike=0;
            if(!empty($roomId) && !empty($eventId)){
                $eventsRepo = TableRegistry::get('Events');
                $query = $eventsRepo->find()->where(['room_id'=>$roomId,'type'=>CHAT_ROOM_TYPE]);
                $query->where([['content LIKE' => '%"fromEventId":"'.$eventId.'"%']]);
                $res = $query->toArray();
                $data=[];
                if(!empty($res)){
                    foreach ($res as $val){
                        $content = json_decode($val['content'], true);
                        if(strtolower($content['actionType']) == 'like')
                            $like++;
                         if(strtolower($content['actionType']) == 'dislike')
                            $dislike++;
                    }
                    $data['like']=$like;
                    $data['dislike']=$dislike;
                }
            }
            $data['like']=$like;
            $data['dislike']=$dislike;
            return $data;
	}

	public function getSenderInfo($matrixUserId) {
            $userObj = TableRegistry::get("Users")->getUserByMatrixUserId($matrixUserId);
            return $userObj;
        }
        
        public function getJoinedSpaycObj($spaycId = null, $userId = null) {
           $jsModel = TableRegistry::get('JoinedSpayc');
           $jsObj = $jsModel->getJoinedSpaycObj($spaycId, $userId);
           return $jsObj->status;
        }
        
        public function getChatMsgDate($msgdate) {           
           $ts = (int) trim($msgdate);
           $msgdate =  date(DATEFORMAT_DISPLAY, ($ts/1000)).'&nbsp;at&nbsp;'.date(TIMEFORMAT_SPAYC, ($ts/1000));
           return $msgdate;
        }
        
        public function getChatReply($roomId, $eventId) {            
            $res = '';
            $chat_msg_type = unserialize(CHAT_MSG_TYPE);
            if(!empty($roomId) && !empty($eventId)){
                $eventsRepo = TableRegistry::get('Events');
                $query = $eventsRepo->find()->where(['room_id'=>$roomId,'type'=>CHAT_ROOM_TYPE]);
                $query->where(['OR' => [['content LIKE' => '%"msgtype":"'.$chat_msg_type['replytext'].'"%'], ['content LIKE' => '%"msgtype":"'.$chat_msg_type['replyimage'].'"%']]]);
                $query->where(['AND' => [['content LIKE' => '%"eventId":"'.$eventId.'"%']]]);
                $res = $query->toArray();
            }
            return $res;
	}
    
        public function getChatReplyText($getChatReply, $html = '') {
            
            foreach ($getChatReply as $getChatReply) {
                $content = json_decode($getChatReply['content'], true);
                $userInfo = $this->getSenderInfo(trim($getChatReply->sender));
                $matrixObj = $this->getMatrixObj($content['eventId']);
                $replied_to = $this->getSenderInfo(trim($matrixObj->sender));
                $likeDislike = $this->getmsgLikeDislike($getChatReply['room_id'], $getChatReply['event_id']);
                $userImg = !empty($userInfo['user_images']) ? $userInfo['user_images']['0']['image_url'] : 'user.jpg';
                $html .= "<div class='comment-reply d-flex flex-wrap'>";
                $html .= "<div class='comment-reply-user-image d-flex w-100'><span>" . $this->Html->image($userImg, ['alt' => '']) . "</span><h4>" . ucwords($userInfo['display_name']) . "<span> replied " . ucwords($replied_to['display_name']) . "</span></h4>";
                $html .= "<div class='comment-action ml-auto'><div class='like'>" . $likeDislike['like'] . "</div><div class='dislike'>" . $likeDislike['dislike'] . "</div></div>";
                $html .= "</div>";
                $html .= "<div class='comment-reply-image'>";
                $html .= "<div class='image-reply d-flex flex-nowrap'><p>" . trim($content['replyString']) . "</p></div>";
                $html .= "<div class='image-reply d-flex flex-nowrap'><p>" . $this->getChatMsgDate($getChatReply['origin_server_ts']) . "</p></div>";
                $html .= "</div>";
                $html .= "</div>";
                $againChatReply = $this->getChatReply($getChatReply['room_id'], $getChatReply['event_id']);
                $html = $this->getChatReplyText($againChatReply, $html );
            }

        return $html;
    }

}
?>
