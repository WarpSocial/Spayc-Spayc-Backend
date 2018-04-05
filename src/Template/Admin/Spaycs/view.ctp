
<div class="spaycs view">
    <div class="panel panel-default">
        <div class="panel-heading"><?= __('View Spayc') ?>
            <div class="pull-right rtbutton">               
                    <?= $this->Html->link('<span class="fa fa-list-alt"></span>&nbsp;&nbsp;List ', ['action' => 'index'],['class'=>'btn btn-primary','escape' => false]) ?> 
           </div>
        </div>
    <div class="panel-body">
    <div class="col-md-9">			
            <table cellpadding="0" cellspacing="0" class="table table-striped">
        <tr>
            <th><?= __('User') ?></th>
            <td><?= $spayc->has('user') ? $this->Html->link($spayc->user->id, ['controller' => 'Users', 'action' => 'view', $spayc->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($spayc->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Location') ?></th>
            <td><?= h($spayc->location) ?></td>
        </tr>
        <tr>
            <th><?= __('Type') ?></th>
            <td><?= h($spayc->type) ?></td>
        </tr>
        <tr>
            <th><?= __('Group Type') ?></th>
            <td><?= h($spayc->group_type) ?></td>
        </tr>
        <tr>
            <th><?= __('Passcode') ?></th>
            <td><?= h($spayc->passcode) ?></td>
        </tr>
        <tr>
            <th><?= __('Image') ?></th>
            <td><?= h($spayc->image) ?></td>
        </tr>
        <tr>
            <th><?= __('Status') ?></th>
            <td><?= h($spayc->status) ?></td>
        </tr>
        <tr>
            <th><?= __('Matrix Room Id') ?></th>
            <td><?= h($spayc->matrix_room_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Parent Spayc') ?></th>
            <td><?= $spayc->has('parent_spayc') ? $this->Html->link($spayc->parent_spayc->name, ['controller' => 'Spaycs', 'action' => 'view', $spayc->parent_spayc->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($spayc->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Longitude') ?></th>
            <td><?= $this->Number->format($spayc->longitude) ?></td>
        </tr>
        <tr>
            <th><?= __('Latitude') ?></th>
            <td><?= $this->Number->format($spayc->latitude) ?></td>
        </tr>
        <tr>
            <th><?= __('Start Date') ?></th>
            <td><?= h($spayc->start_date) ?></td>
        </tr>
        <tr>
            <th><?= __('End Date') ?></th>
            <td><?= h($spayc->end_date) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($spayc->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($spayc->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($spayc->description)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Spaycs') ?></h4>
        <?php if (!empty($spayc->sub_spaycs)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('User Id') ?></th>
                <th><?= __('Name') ?></th>
                <th><?= __('Location') ?></th>
                <th><?= __('Type') ?></th>
                <th><?= __('Group Type') ?></th>
                <th><?= __('Start Date') ?></th>
                <th><?= __('End Date') ?></th>
                <th><?= __('Passcode') ?></th>
                <th><?= __('Description') ?></th>
                <th><?= __('Image') ?></th>
                <th><?= __('Longitude') ?></th>
                <th><?= __('Latitude') ?></th>
                <th><?= __('Status') ?></th>
                <th><?= __('Matrix Room Id') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th><?= __('Parent Id') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($spayc->sub_spaycs as $subSpaycs): ?>
            <tr>
                <td><?= h($subSpaycs->id) ?></td>
                <td><?= h($subSpaycs->user_id) ?></td>
                <td><?= h($subSpaycs->name) ?></td>
                <td><?= h($subSpaycs->location) ?></td>
                <td><?= h($subSpaycs->type) ?></td>
                <td><?= h($subSpaycs->group_type) ?></td>
                <td><?= h($subSpaycs->start_date) ?></td>
                <td><?= h($subSpaycs->end_date) ?></td>
                <td><?= h($subSpaycs->passcode) ?></td>
                <td><?= h($subSpaycs->description) ?></td>
                <td><?= h($subSpaycs->image) ?></td>
                <td><?= h($subSpaycs->longitude) ?></td>
                <td><?= h($subSpaycs->latitude) ?></td>
                <td><?= h($subSpaycs->status) ?></td>
                <td><?= h($subSpaycs->matrix_room_id) ?></td>
                <td><?= h($subSpaycs->created) ?></td>
                <td><?= h($subSpaycs->modified) ?></td>
                <td><?= h($subSpaycs->parent_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Spaycs', 'action' => 'view', $subSpaycs->id]) ?>

                    <?= $this->Html->link(__('Edit'), ['controller' => 'Spaycs', 'action' => 'edit', $subSpaycs->id]) ?>

                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Spaycs', 'action' => 'delete', $subSpaycs->id], ['confirm' => __('Are you sure you want to delete # {0}?', $subSpaycs->id)]) ?>

                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Joined Spayc') ?></h4>
        <?php if (!empty($spayc->joined_spayc)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Spayc Id') ?></th>
                <th><?= __('User Id') ?></th>
                <th><?= __('Status') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th><?= __('Updated By') ?></th>
                <th><?= __('Is Admin') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($spayc->joined_spayc as $joinedSpayc): ?>
            <tr>
                <td><?= h($joinedSpayc->id) ?></td>
                <td><?= h($joinedSpayc->spayc_id) ?></td>
                <td><?= h($joinedSpayc->user_id) ?></td>
                <td><?= h($joinedSpayc->status) ?></td>
                <td><?= h($joinedSpayc->created) ?></td>
                <td><?= h($joinedSpayc->modified) ?></td>
                <td><?= h($joinedSpayc->updated_by) ?></td>
                <td><?= h($joinedSpayc->is_admin) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'JoinedSpayc', 'action' => 'view', $joinedSpayc->id]) ?>

                    <?= $this->Html->link(__('Edit'), ['controller' => 'JoinedSpayc', 'action' => 'edit', $joinedSpayc->id]) ?>

                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'JoinedSpayc', 'action' => 'delete', $joinedSpayc->id], ['confirm' => __('Are you sure you want to delete # {0}?', $joinedSpayc->id)]) ?>

                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Subscribed Users') ?></h4>
        <?php if (!empty($spayc->subscribed_users)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Spayc Id') ?></th>
                <th><?= __('User Id') ?></th>
                <th><?= __('Status') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($spayc->subscribed_users as $subscribedUsers): ?>
            <tr>
                <td><?= h($subscribedUsers->id) ?></td>
                <td><?= h($subscribedUsers->spayc_id) ?></td>
                <td><?= h($subscribedUsers->user_id) ?></td>
                <td><?= h($subscribedUsers->status) ?></td>
                <td><?= h($subscribedUsers->created) ?></td>
                <td><?= h($subscribedUsers->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'SubscribedUsers', 'action' => 'view', $subscribedUsers->id]) ?>

                    <?= $this->Html->link(__('Edit'), ['controller' => 'SubscribedUsers', 'action' => 'edit', $subscribedUsers->id]) ?>

                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'SubscribedUsers', 'action' => 'delete', $subscribedUsers->id], ['confirm' => __('Are you sure you want to delete # {0}?', $subscribedUsers->id)]) ?>

                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Comments') ?></h4>
        <?php if (!empty($spayc->comments)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Spayc Id') ?></th>
                <th><?= __('User Id') ?></th>
                <th><?= __('Comment') ?></th>
                <th><?= __('Status') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($spayc->comments as $comments): ?>
            <tr>
                <td><?= h($comments->id) ?></td>
                <td><?= h($comments->spayc_id) ?></td>
                <td><?= h($comments->user_id) ?></td>
                <td><?= h($comments->comment) ?></td>
                <td><?= h($comments->status) ?></td>
                <td><?= h($comments->created) ?></td>
                <td><?= h($comments->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Comments', 'action' => 'view', $comments->id]) ?>

                    <?= $this->Html->link(__('Edit'), ['controller' => 'Comments', 'action' => 'edit', $comments->id]) ?>

                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Comments', 'action' => 'delete', $comments->id], ['confirm' => __('Are you sure you want to delete # {0}?', $comments->id)]) ?>

                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Spayc Hashtags') ?></h4>
        <?php if (!empty($spayc->spayc_hashtags)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Spayc Id') ?></th>
                <th><?= __('Hashtag Id') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($spayc->spayc_hashtags as $spaycHashtags): ?>
            <tr>
                <td><?= h($spaycHashtags->id) ?></td>
                <td><?= h($spaycHashtags->spayc_id) ?></td>
                <td><?= h($spaycHashtags->hashtag_id) ?></td>
                <td><?= h($spaycHashtags->created) ?></td>
                <td><?= h($spaycHashtags->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'SpaycHashtags', 'action' => 'view', $spaycHashtags->id]) ?>

                    <?= $this->Html->link(__('Edit'), ['controller' => 'SpaycHashtags', 'action' => 'edit', $spaycHashtags->id]) ?>

                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'SpaycHashtags', 'action' => 'delete', $spaycHashtags->id], ['confirm' => __('Are you sure you want to delete # {0}?', $spaycHashtags->id)]) ?>

                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div>
</div>
    </div>
    </div>

    <div class="row">
    <ul class="nav nav-pills">        
        <li><?= $this->Html->link(__('Edit Spayc'), ['action' => 'edit', $spayc->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Spayc'), ['action' => 'delete', $spayc->id], ['confirm' => __('Are you sure you want to delete # {0}?', $spayc->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Spaycs'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Spayc'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Parent Spaycs'), ['controller' => 'Spaycs', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Parent Spayc'), ['controller' => 'Spaycs', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Joined Spayc'), ['controller' => 'JoinedSpayc', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Joined Spayc'), ['controller' => 'JoinedSpayc', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Subscribed Users'), ['controller' => 'SubscribedUsers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Subscribed User'), ['controller' => 'SubscribedUsers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Comments'), ['controller' => 'Comments', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Comment'), ['controller' => 'Comments', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Spayc Hashtags'), ['controller' => 'SpaycHashtags', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Spayc Hashtag'), ['controller' => 'SpaycHashtags', 'action' => 'add']) ?> </li>
    </ul>
</div>
    </div>