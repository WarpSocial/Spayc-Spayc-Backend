
<div class="settings view">
    <div class="panel panel-default">
        <div class="panel-heading"><?= __('View Setting') ?>
            <div class="pull-right rtbutton">               
                    <?= $this->Html->link('<span class="fa fa-list-alt"></span>&nbsp;&nbsp;List ', ['action' => 'index'],['class'=>'btn btn-primary','escape' => false]) ?> 
           </div>
        </div>
    <div class="panel-body">
    <div class="col-md-9">			
            <table cellpadding="0" cellspacing="0" class="table table-striped">
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($setting->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($setting->created) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Param') ?></h4>
        <?= $this->Text->autoParagraph(h($setting->param)); ?>
    </div>
    <div class="row">
        <h4><?= __('Param Value') ?></h4>
        <?= $this->Text->autoParagraph(h($setting->param_value)); ?>
    </div>
</div>
    </div>
    </div>

    <div class="row">
    <ul class="nav nav-pills">        
        <li><?= $this->Html->link(__('Edit Setting'), ['action' => 'edit', $setting->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Setting'), ['action' => 'delete', $setting->id], ['confirm' => __('Are you sure you want to delete # {0}?', $setting->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Settings'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Setting'), ['action' => 'add']) ?> </li>
    </ul>
</div>
    </div>