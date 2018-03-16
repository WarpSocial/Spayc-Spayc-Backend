<div class="users index">
<div class="panel panel-default">
        <div class="panel-heading"><?= __('Users') ?> Listing
            <div class="pull-right rtbutton">
                <?= $this->Html->link(__("<span class='fa fa-plus'></span>&nbsp;&nbsp;New user") , ['action' => 'add'],['class'=>'btn btn-primary','escape' => false]) ?>
               
           </div>
        </div>
<div class="panel-body">
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('username') ?></th>
                <th><?= $this->Paginator->sort('email') ?></th>
                <th><?= $this->Paginator->sort('password') ?></th>
                <th><?= $this->Paginator->sort('gender') ?></th>
                <th><?= $this->Paginator->sort('dob') ?></th>
                <th><?= $this->Paginator->sort('phone') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $this->Number->format($user->id) ?></td>
                <td><?= h($user->username) ?></td>
                <td><?= h($user->email) ?></td>
                <td><?= h($user->password) ?></td>
                <td><?= h($user->gender) ?></td>
                <td><?= h($user->dob) ?></td>
                <td><?= h($user->phone) ?></td>
                <td class="actions">
                    <?= $this->Html->link('<span class="fa fa-folder-open"></span>', ['action' => 'view', $user->id],['title'=>'View','escape' => false]) ?>
                    <?= $this->Html->link('<span class="fa fa-edit"></span>', ['action' => 'edit', $user->id],['title'=>'Edit','escape' => false]) ?>
                    <?= $this->Form->postLink('<span class="fa fa-times"></span>', ['action' => 'delete', $user->id], ['title'=>'Delete','escape' => false,'confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?>
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
