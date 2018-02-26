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
        $this->controller->set('data', [
            'error' => $this->controller->viewVars['message'],
            'code' => $this->controller->viewVars['code']
        ]);
        $this->controller->set('_serialize', ['data']);

        return parent::_outputMessage($template);
    }

}
