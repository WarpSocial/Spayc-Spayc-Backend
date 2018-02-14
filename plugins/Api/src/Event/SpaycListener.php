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

class SpaycListener implements EventListenerInterface {
    
    
    public function implementedEvents() {
        return [
            'Controller.Spayc.matrixMedia' => 'matrixMedia'
        ];
    }
    
    public function matrixMedia(Event $event, EntityInterface $entity,$options){
        $controller = $event->getSubject();
        //$controller->loadComponent('Api.Matrix');
        $matrix = new MatrixComponent(new ComponentRegistry());
        $matrix->uploadMediaImage([
            'image_url'=>$entity->image,
            'room_id'=>$entity->matrix_room_id,
            'token'=>$options['matrix_token']
            ]);
        return true;
    }
}
