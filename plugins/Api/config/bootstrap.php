<?php
use Cake\Core\Configure;

try {
    Configure::load('Api.api', 'default', false);
} catch (Exception $e) {
    exit($e->getMessage() . "\n");
}
