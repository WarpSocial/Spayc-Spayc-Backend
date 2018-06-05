<?php
use Cake\Core\Configure;
use Cake\Error\Debugger;
$this->layout = 'admin';
/*** Error Page ***/
echo $this->element('admin/error', ['base_url_admin'=> $base_url_admin]);
?>



