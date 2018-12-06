
<div class="reportedWarps view">
    <div class="panel panel-default">
        <div class="panel-heading"><?= __('View Reported Warp') ?>
            <div class="pull-right rtbutton">               
                    <?= $this->Html->link('<span class="fa fa-list-alt"></span>&nbsp;&nbsp;List ', ['action' => 'index'],['class'=>'btn btn-primary','escape' => false]) ?> 
           </div>
        </div>
    <div class="panel-body">
    <div class="col-md-9">			
            <table cellpadding="0" cellspacing="0" class="table table-striped">
        <tr>
            <th><?= __('Spayc') ?></th>
            <td><?= $reportedWarp->has('spayc') ? $this->Html->link($reportedWarp->spayc->name, ['controller' => 'Spaycs', 'action' => 'view', $reportedWarp->spayc->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Matrix Room Id') ?></th>
            <td><?= h($reportedWarp->matrix_room_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($reportedWarp->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Reported By') ?></th>
            <td><?= $this->Number->format($reportedWarp->reported_by) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($reportedWarp->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($reportedWarp->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Message') ?></h4>
        <?= $this->Text->autoParagraph(h($reportedWarp->message)); ?>
    </div>
</div>
    </div>
    </div>

    <div class="row">
    <ul class="nav nav-pills">        
        <li><?= $this->Html->link(__('Edit Reported Warp'), ['action' => 'edit', $reportedWarp->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Reported Warp'), ['action' => 'delete', $reportedWarp->id], ['confirm' => __('Are you sure you want to delete # {0}?', $reportedWarp->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Reported Warps'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Reported Warp'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Spaycs'), ['controller' => 'Spaycs', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Spayc'), ['controller' => 'Spaycs', 'action' => 'add']) ?> </li>
    </ul>
</div>
    </div>