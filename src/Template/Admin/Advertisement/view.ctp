
<div class="advertisement view">
    <div class="panel panel-default">
        <div class="panel-heading"><?= __('View Advertisement') ?>
            <div class="pull-right rtbutton">               
                    <?= $this->Html->link('<span class="fa fa-list-alt"></span>&nbsp;&nbsp;List ', ['action' => 'index'],['class'=>'btn btn-primary','escape' => false]) ?> 
           </div>
        </div>
    <div class="panel-body">
    <div class="col-md-9">			
            <table cellpadding="0" cellspacing="0" class="table table-striped">
        <tr>
            <th><?= __('User') ?></th>
            <td><?= $advertisement->has('user') ? $this->Html->link($advertisement->user->id, ['controller' => 'Users', 'action' => 'view', $advertisement->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($advertisement->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Url') ?></th>
            <td><?= h($advertisement->url) ?></td>
        </tr>
        <tr>
            <th><?= __('Image') ?></th>
            <td><?= h($advertisement->image) ?></td>
        </tr>
        <tr>
            <th><?= __('Status') ?></th>
            <td><?= h($advertisement->status) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($advertisement->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Price') ?></th>
            <td><?= $this->Number->format($advertisement->price) ?></td>
        </tr>
        <tr>
            <th><?= __('Views') ?></th>
            <td><?= $this->Number->format($advertisement->views) ?></td>
        </tr>
        <tr>
            <th><?= __('Balance') ?></th>
            <td><?= $this->Number->format($advertisement->balance) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($advertisement->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($advertisement->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($advertisement->description)); ?>
    </div>
</div>
    </div>
    </div>

    <div class="row">
    <ul class="nav nav-pills">        
        <li><?= $this->Html->link(__('Edit Advertisement'), ['action' => 'edit', $advertisement->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Advertisement'), ['action' => 'delete', $advertisement->id], ['confirm' => __('Are you sure you want to delete # {0}?', $advertisement->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Advertisement'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Advertisement'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</div>
    </div>