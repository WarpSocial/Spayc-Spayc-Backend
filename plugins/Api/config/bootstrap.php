<?php

use Cake\Core\Configure;
use Cake\Log\Log;
use Cake\Event\EventManager;
use Api\Event\SpaycListener;
//use Api\Error\ApiError;

try {
    Configure::load('Api.api', 'default', false);
} catch (\Exception $e) {
    exit($e->getMessage() . "\n");
}
Configure::write('Error.exceptionRenderer','Api\Error\ApiExceptionRenderer');
EventManager::instance()->on(new SpaycListener());
//Log::config('api', [
//            'className' => 'Api\Log\Engine\ApiLog.Api',
//            'path' => LOGS,
//            'file' => 'api',
//            'levels' => ['notice', 'error', 'critical', 'alert', 'emergency'],
//        ]);

//$errorHandler = new ApiError();
//$errorHandler->register();
