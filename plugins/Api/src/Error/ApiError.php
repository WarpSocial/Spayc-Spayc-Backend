<?php

/*
 * Description API plugin exception to render error message either in json or xml.
 *
 * @author subhash
 */

namespace Api\Error;

use Cake\Core\Configure;
use Cake\Error\BaseErrorHandler;

/**
 * API Exception Renderer.
 *
 * Captures and handles all unhandled exceptions. Displays valid json response.
 */
class ApiError extends BaseErrorHandler {

    public function _displayError($error, $debug) {
        echo 'There has been an error!';
    }

    public function _displayException($exception) {
        echo 'There has been an exception!';
    }

    public function handleFatalError($code, $description, $file, $line) {
        return 'A fatal error has happened';
    }

}
