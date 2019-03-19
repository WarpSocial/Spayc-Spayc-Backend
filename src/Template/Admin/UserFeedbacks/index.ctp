<?php echo $this->element('admin/breadcrumbs', ['action' => $breadcrumbsTxt]); ?>
<?= $this->Flash->render() ?>
<section class="content-wrapper content-filter">
    <div class="container">
        <div class="userFeedbacks index">
            <div class="panel panel-default">
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th><?= $this->Paginator->sort('id') ?></th>
                                <th><?= $this->Paginator->sort('user_id') ?></th>
                                <th><?= $this->Paginator->sort('attachment') ?></th>
                                <th><?= $this->Paginator->sort('created') ?></th>
                                <th class="actions"><?= __('Actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($userFeedbacks as $userFeedback): ?>
                                <tr>
                                    <td><?= $this->Number->format($userFeedback->id) ?></td>
                                    <td><?= $userFeedback->has('user') ? $this->Html->link($userFeedback->user->id, ['controller' => 'Users', 'action' => 'view', $userFeedback->user->id]) : '' ?></td>
                                    <td><?= h($userFeedback->attachment) ?></td>
                                    <td><?= h($userFeedback->created) ?></td>
                                    <td class="actions">
                                        <?= $this->Html->link('<span class="fa fa-folder-open"></span>', ['action' => 'view', $userFeedback->id], ['title' => 'View', 'escape' => false]) ?>
                                        <?= $this->Html->link('<span class="fa fa-edit"></span>', ['action' => 'edit', $userFeedback->id], ['title' => 'Edit', 'escape' => false]) ?>
                                        <?= $this->Form->postLink('<span class="fa fa-times"></span>', ['action' => 'delete', $userFeedback->id], ['title' => 'Delete', 'escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $userFeedback->id)]) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <?php if($this->Paginator->params()['pageCount'] > 1) { ?>
                    <ul class="pagination table-pagination">
                      <?= $this->Paginator->prev('',['escape' => false]) ?>
                      <?= $this->Paginator->numbers(array('modulus' => 4)) ?>
                      <?= $this->Paginator->next('',['escape' => false]) ?>
                    </ul>
                <?php } ?>
                </div><!-- end panel body -->
            </div>
        </div>
    </div>
</section>