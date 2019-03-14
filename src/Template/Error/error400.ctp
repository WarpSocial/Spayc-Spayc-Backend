<?php
use Cake\Core\Configure;
use Cake\Error\Debugger;

if('admin' == $this->request->param('prefix')){
    $this->layout = 'admin';
}else{
    $this->layout = 'error';
}

if (Configure::read('debug')):
    $this->layout = 'dev_error';

    $this->assign('title', $message);
    $this->assign('templateName', 'error400.ctp');

    $this->start('file');
?>
<?php if (!empty($error->queryString)) : ?>
    <p class="notice">
        <strong>SQL Query: </strong>
        <?= h($error->queryString) ?>
    </p>
<?php endif; ?>
<?php if (!empty($error->params)) : ?>
        <strong>SQL Query Params: </strong>
        <?php Debugger::dump($error->params) ?>
<?php endif; ?>
<?= $this->element('auto_table_warning') ?>
<?php
    if (extension_loaded('xdebug')):
        xdebug_print_function_stack();
    endif;

    $this->end();
endif;
$this->layout = 'admin';
echo $this->element('admin/error', ['admin_url'=> $base_url_admin,'code'=>400,'message'=>$message]);
?>