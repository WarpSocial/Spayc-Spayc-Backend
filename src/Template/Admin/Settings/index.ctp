<div class="settings index">
<div class="panel panel-default">
        <div class="panel-heading"><?= __('Settings') ?> Listing
            <div class="pull-right rtbutton">
                <?= $this->Html->link(__("<span class='fa fa-plus'></span>&nbsp;&nbsp;New setting") , ['action' => 'add'],['class'=>'btn btn-primary','escape' => false]) ?>
               
           </div>
        </div>
<div class="panel-body">
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($settings as $setting): ?>
            <tr>
                <td><?= $this->Number->format($setting->id) ?></td>
                <td><?= h($setting->created) ?></td>
                <td class="actions">
                    <?= $this->Html->link('<span class="fa fa-folder-open"></span>', ['action' => 'view', $setting->id],['title'=>'View','escape' => false]) ?>
                    <?= $this->Html->link('<span class="fa fa-edit"></span>', ['action' => 'edit', $setting->id],['title'=>'Edit','escape' => false]) ?>
                    <?= $this->Form->postLink('<span class="fa fa-times"></span>', ['action' => 'delete', $setting->id], ['title'=>'Delete','escape' => false,'confirm' => __('Are you sure you want to delete # {0}?', $setting->id)]) ?>
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
