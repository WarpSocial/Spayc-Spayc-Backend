
<div class="users view">
    <div class="panel panel-default">
        <div class="panel-heading"><?= __('View User') ?>
            <div class="pull-right rtbutton">               
                    <?= $this->Html->link('<span class="fa fa-list-alt"></span>&nbsp;&nbsp;List ', ['action' => 'index'],['class'=>'btn btn-primary','escape' => false]) ?> 
           </div>
        </div>
    <div class="panel-body">
    <div class="col-md-9">			
            <table cellpadding="0" cellspacing="0" class="table table-striped">
        <tr>
            <th><?= __('Username') ?></th>
            <td><?= h($user->username) ?></td>
        </tr>
        <tr>
            <th><?= __('Email') ?></th>
            <td><?= h($user->email) ?></td>
        </tr>
        <tr>
            <th><?= __('Password') ?></th>
            <td><?= h($user->password) ?></td>
        </tr>
        <tr>
            <th><?= __('Gender') ?></th>
            <td><?= h($user->gender) ?></td>
        </tr>
        <tr>
            <th><?= __('Phone') ?></th>
            <td><?= h($user->phone) ?></td>
        </tr>
        <tr>
            <th><?= __('Status') ?></th>
            <td><?= h($user->status) ?></td>
        </tr>
        <tr>
            <th><?= __('Website Url') ?></th>
            <td><?= h($user->website_url) ?></td>
        </tr>
        <tr>
            <th><?= __('Fb Id') ?></th>
            <td><?= h($user->fb_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Fb Access Key') ?></th>
            <td><?= h($user->fb_access_key) ?></td>
        </tr>
        <tr>
            <th><?= __('Timezone') ?></th>
            <td><?= h($user->timezone) ?></td>
        </tr>
        <tr>
            <th><?= __('Matrix User Id') ?></th>
            <td><?= h($user->matrix_user_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Matrix Access Token') ?></th>
            <td><?= h($user->matrix_access_token) ?></td>
        </tr>
        <tr>
            <th><?= __('Token Verification') ?></th>
            <td><?= h($user->token_verification) ?></td>
        </tr>
        <tr>
            <th><?= __('Forgot Password Token') ?></th>
            <td><?= h($user->forgot_password_token) ?></td>
        </tr>
        <tr>
            <th><?= __('Country Code') ?></th>
            <td><?= h($user->country_code) ?></td>
        </tr>
        <tr>
            <th><?= __('Is Notify') ?></th>
            <td><?= h($user->is_notify) ?></td>
        </tr>
        <tr>
            <th><?= __('Role') ?></th>
            <td><?= $user->has('role') ? $this->Html->link($user->role->title, ['controller' => 'Roles', 'action' => 'view', $user->role->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($user->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Longitude') ?></th>
            <td><?= $this->Number->format($user->longitude) ?></td>
        </tr>
        <tr>
            <th><?= __('Latitude') ?></th>
            <td><?= $this->Number->format($user->latitude) ?></td>
        </tr>
        <tr>
            <th><?= __('Current Latitude') ?></th>
            <td><?= $this->Number->format($user->current_latitude) ?></td>
        </tr>
        <tr>
            <th><?= __('Current Longitude') ?></th>
            <td><?= $this->Number->format($user->current_longitude) ?></td>
        </tr>
        <tr>
            <th><?= __('Dob') ?></th>
            <td><?= h($user->dob) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($user->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($user->modified) ?></td>
        </tr>
        <tr>
            <th><?= __('Forgot Password Timestamp') ?></th>
            <td><?= h($user->forgot_password_timestamp) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Address') ?></h4>
        <?= $this->Text->autoParagraph(h($user->address)); ?>
    </div>
    <div class="row">
        <h4><?= __('Bio Data') ?></h4>
        <?= $this->Text->autoParagraph(h($user->bio_data)); ?>
    </div>
</div>
    </div>
    </div>

    <div class="row">
    <ul class="nav nav-pills">        
        <li><?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Roles'), ['controller' => 'Roles', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Role'), ['controller' => 'Roles', 'action' => 'add']) ?> </li>
    </ul>
</div>
    </div>