<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Api\Event;
/**
 * Description of SpaycListener
 *
 * @author kiwitech
 */
use Cake\Event\EventListenerInterface;
use Cake\Event\Event;
use Cake\Datasource\EntityInterface;
use Cake\Controller\ComponentRegistry;
use Api\Controller\Component\MatrixComponent;
use Api\Controller\Component\PushComponent;

class SpaycListener implements EventListenerInterface {
    
    
    public function implementedEvents() {
        return [
            'Controller.Spayc.matrixMedia' => 'matrixMedia',
            'Controller.Spayc.pushNotification' => 'pushNotification'
        ];
    }
    
    public function matrixMedia(Event $event, $options){        
        $matrix = new MatrixComponent(new ComponentRegistry());
        $items = ['image_url'=>$options['image'],'matrix_token'=>$options['matrix_token']];
        if(!empty($options['matrix_room_id'])){
            $items['matrix_room_id'] = $options['matrix_room_id'];
        }elseif(!empty($options['matrix_user_id'])){
            $items['matrix_user_id'] = $options['matrix_user_id'];
        }else{
            return;
        }
        $matrix->uploadMediaImage($items);
        return true;
    }
    
    public function pushNotification(Event $event, $options){
        $pusher = new PushComponent(new ComponentRegistry());
        $pusher->sendPushNotification($options);
        return true;
    }
}
