
<div class="spamReports view">
    <div class="panel panel-default">
        <div class="panel-heading"><?= __('View Spam Report') ?>
            <div class="pull-right rtbutton">               
                    <?= $this->Html->link('<span class="fa fa-list-alt"></span>&nbsp;&nbsp;List ', ['action' => 'index'],['class'=>'btn btn-primary','escape' => false]) ?> 
           </div>
        </div>
    <div class="panel-body">
    <div class="col-md-9">			
            <table cellpadding="0" cellspacing="0" class="table table-striped">
        <tr>
            <th><?= __('Spayc') ?></th>
            <td><?= $spamReport->has('spayc') ? $this->Html->link($spamReport->spayc->name, ['controller' => 'Spaycs', 'action' => 'view', $spamReport->spayc->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Event Id') ?></th>
            <td><?= h($spamReport->event_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($spamReport->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Reported By') ?></th>
            <td><?= $this->Number->format($spamReport->reported_by) ?></td>
        </tr>
        <tr>
            <th><?= __('Reported To') ?></th>
            <td><?= $this->Number->format($spamReport->reported_to) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($spamReport->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($spamReport->modified) ?></td>
        </tr>
    </table>
</div>
    </div>
    </div>

    <div class="row">
    <ul class="nav nav-pills">        
        <li><?= $this->Html->link(__('Edit Spam Report'), ['action' => 'edit', $spamReport->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Spam Report'), ['action' => 'delete', $spamReport->id], ['confirm' => __('Are you sure you want to delete # {0}?', $spamReport->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Spam Reports'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Spam Report'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Spaycs'), ['controller' => 'Spaycs', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Spayc'), ['controller' => 'Spaycs', 'action' => 'add']) ?> </li>
    </ul>
</div>
    </div>