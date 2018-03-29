<?php

namespace Api\Error;

use Cake\Error\ExceptionRenderer;
use Cake\Error\BaseErrorHandler;
/**
 * API Exception Renderer.
 *
 * Captures and handles all unhandled exceptions. Displays valid json response.
 */
class ApiExceptionRenderer extends ExceptionRenderer {

    protected function _outputMessage($template) {
        $this->controller->response->statusCode($this->controller->viewVars['code']);
        $response = [
            'status'=> 'failed',
            'message' => $this->controller->viewVars['message']
        ];
        $this->controller->set($response);
        $this->controller->set('_serialize',['status','message','url']);
        //$this->controller->set('_serialize',true);
        return parent::_outputMessage($template);
    }

}
