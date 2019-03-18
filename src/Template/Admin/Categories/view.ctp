
<div class="spaycCategories view">
    <div class="panel panel-default">
        <div class="panel-heading"><?= __('View Spayc Category') ?>
            <div class="pull-right rtbutton">               
                    <?= $this->Html->link('<span class="fa fa-list-alt"></span>&nbsp;&nbsp;List ', ['action' => 'index'],['class'=>'btn btn-primary','escape' => false]) ?> 
           </div>
        </div>
    <div class="panel-body">
    <div class="col-md-9">			
            <table cellpadding="0" cellspacing="0" class="table table-striped">
        <tr>
            <th><?= __('Parent Spayc Category') ?></th>
            <td><?= $spaycCategory->has('parent_spayc_category') ? $this->Html->link($spaycCategory->parent_spayc_category->name, ['controller' => 'SpaycCategories', 'action' => 'view', $spaycCategory->parent_spayc_category->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($spaycCategory->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Slug') ?></th>
            <td><?= h($spaycCategory->slug) ?></td>
        </tr>
        <tr>
            <th><?= __('Code') ?></th>
            <td><?= h($spaycCategory->code) ?></td>
        </tr>
        <tr>
            <th><?= __('Description') ?></th>
            <td><?= h($spaycCategory->description) ?></td>
        </tr>
        <tr>
            <th><?= __('Status') ?></th>
            <td><?= h($spaycCategory->status) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($spaycCategory->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Lft') ?></th>
            <td><?= $this->Number->format($spaycCategory->lft) ?></td>
        </tr>
        <tr>
            <th><?= __('Rght') ?></th>
            <td><?= $this->Number->format($spaycCategory->rght) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($spaycCategory->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($spaycCategory->modified) ?></td>
        </tr>
    </table>
</div>
    </div>
    </div>

    <div class="row">
    <ul class="nav nav-pills">        
        <li><?= $this->Html->link(__('Edit Spayc Category'), ['action' => 'edit', $spaycCategory->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Spayc Category'), ['action' => 'delete', $spaycCategory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $spaycCategory->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Spayc Categories'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Spayc Category'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Parent Spayc Categories'), ['controller' => 'SpaycCategories', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Parent Spayc Category'), ['controller' => 'SpaycCategories', 'action' => 'add']) ?> </li>
    </ul>
</div>
    </div>