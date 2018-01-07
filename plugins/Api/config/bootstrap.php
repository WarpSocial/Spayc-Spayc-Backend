<?php
use Cake\Core\Configure;
//use Api\Error\ApiError;

try {
    Configure::load('Api.api', 'default', false);
} catch (Exception $e) {
    exit($e->getMessage() . "\n");
}
//$errorHandler = new ApiError();
//$errorHandler->register();
