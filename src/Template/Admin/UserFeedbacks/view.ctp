
<div class="userFeedbacks view">
    <div class="panel panel-default">
        <div class="panel-heading"><?= __('View User Feedback') ?>
            <div class="pull-right rtbutton">               
                    <?= $this->Html->link('<span class="fa fa-list-alt"></span>&nbsp;&nbsp;List ', ['action' => 'index'],['class'=>'btn btn-primary','escape' => false]) ?> 
           </div>
        </div>
    <div class="panel-body">
    <div class="col-md-9">			
            <table cellpadding="0" cellspacing="0" class="table table-striped">
        <tr>
            <th><?= __('User') ?></th>
            <td><?= $userFeedback->has('user') ? $this->Html->link($userFeedback->user->id, ['controller' => 'Users', 'action' => 'view', $userFeedback->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Attachment') ?></th>
            <td><?= h($userFeedback->attachment) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($userFeedback->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($userFeedback->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($userFeedback->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Message') ?></h4>
        <?= $this->Text->autoParagraph(h($userFeedback->message)); ?>
    </div>
</div>
    </div>
    </div>

    <div class="row">
    <ul class="nav nav-pills">        
        <li><?= $this->Html->link(__('Edit User Feedback'), ['action' => 'edit', $userFeedback->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete User Feedback'), ['action' => 'delete', $userFeedback->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userFeedback->id)]) ?> </li>
        <li><?= $this->Html->link(__('List User Feedbacks'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User Feedback'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</div>
    </div>