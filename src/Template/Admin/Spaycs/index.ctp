<div class="spaycs index">
<div class="panel panel-default">
        <div class="panel-heading"><?= __('Spaycs') ?> Listing
            <div class="pull-right rtbutton">
                <?= $this->Html->link(__("<span class='fa fa-plus'></span>&nbsp;&nbsp;New spayc") , ['action' => 'add'],['class'=>'btn btn-primary','escape' => false]) ?>
               
           </div>
        </div>
<div class="panel-body">
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('user_id') ?></th>
                <th><?= $this->Paginator->sort('name') ?></th>
                <th><?= $this->Paginator->sort('location') ?></th>
                <th><?= $this->Paginator->sort('type') ?></th>
                <th><?= $this->Paginator->sort('group_type') ?></th>
                <th><?= $this->Paginator->sort('start_date') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($spaycs as $spayc): ?>
            <tr>
                <td><?= $this->Number->format($spayc->id) ?></td>
                <td><?= $spayc->has('user') ? $this->Html->link($spayc->user->id, ['controller' => 'Users', 'action' => 'view', $spayc->user->id]) : '' ?></td>
                <td><?= h($spayc->name) ?></td>
                <td><?= h($spayc->location) ?></td>
                <td><?= h($spayc->type) ?></td>
                <td><?= h($spayc->group_type) ?></td>
                <td><?= h($spayc->start_date) ?></td>
                <td class="actions">
                    <?= $this->Html->link('<span class="fa fa-folder-open"></span>', ['action' => 'view', $spayc->id],['title'=>'View','escape' => false]) ?>
                    <?= $this->Html->link('<span class="fa fa-edit"></span>', ['action' => 'edit', $spayc->id],['title'=>'Edit','escape' => false]) ?>
                    <?= $this->Form->postLink('<span class="fa fa-times"></span>', ['action' => 'delete', $spayc->id], ['title'=>'Delete','escape' => false,'confirm' => __('Are you sure you want to delete # {0}?', $spayc->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <div class="paginator">
        <ul class="pagination pagination-sm">
            <?= $this->Paginator->prev('&larr; Prev',['class' => 'prev','tag' => 'li','escape' => false]) ?>
            <?= $this->Paginator->numbers(['separator' => '','tag' => 'li','currentClass' => 'active','currentTag' => 'a']) ?>
            <?= $this->Paginator->next('Next &rarr;',['class' => 'next','tag' => 'li','escape' => false]) ?>
        </ul>
        <p><small><?= $this->Paginator->counter() ?></small></p>
    </div>
    </div><!-- end panel body -->
</div>
</div>
