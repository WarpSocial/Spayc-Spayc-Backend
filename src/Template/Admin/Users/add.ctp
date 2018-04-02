<div class="users form">
    <div class="panel panel-default">
        <div class="panel-heading"><?= __('Add User') ?>
            <div class="pull-right rtbutton">
                                &nbsp;&nbsp;<?= $this->Html->link('<span class="fa fa-list-alt"></span>&nbsp;&nbsp;List ', ['action' => 'index'],['class'=>'btn btn-primary','escape' => false]) ?>        
                        
           </div>
        </div>
        <div class="panel-body">
            <div class="col-md-12">
    <?= $this->Form->create($user,['role' => 'form']) ?>
        <?php
            echo '<div class="form-group">';        
            echo $this->Form->input('username',['class' => 'form-control', 'placeholder' => 'Username']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('email',['class' => 'form-control', 'placeholder' => 'Email']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('password',['class' => 'form-control', 'placeholder' => 'Password']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('gender',['class' => 'form-control', 'placeholder' => 'Gender']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('dob', ['empty' => true],['class' => 'form-control', 'placeholder' => 'Dob']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('phone',['class' => 'form-control', 'placeholder' => 'Phone']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('status',['class' => 'form-control', 'placeholder' => 'Status']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('website_url',['class' => 'form-control', 'placeholder' => 'Website Url']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('address',['class' => 'form-control', 'placeholder' => 'Address']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('bio_data',['class' => 'form-control', 'placeholder' => 'Bio Data']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('fb_id',['class' => 'form-control', 'placeholder' => 'Fb Id']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('fb_access_key',['class' => 'form-control', 'placeholder' => 'Fb Access Key']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('longitude',['class' => 'form-control', 'placeholder' => 'Longitude']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('latitude',['class' => 'form-control', 'placeholder' => 'Latitude']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('timezone',['class' => 'form-control', 'placeholder' => 'Timezone']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('matrix_user_id',['class' => 'form-control', 'placeholder' => 'Matrix User Id']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('matrix_access_token',['class' => 'form-control', 'placeholder' => 'Matrix Access Token']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('token_verification',['class' => 'form-control', 'placeholder' => 'Token Verification']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('forgot_password_token',['class' => 'form-control', 'placeholder' => 'Forgot Password Token']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('forgot_password_timestamp',['class' => 'form-control', 'placeholder' => 'Forgot Password Timestamp']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('country_code',['class' => 'form-control', 'placeholder' => 'Country Code']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('is_notify',['class' => 'form-control', 'placeholder' => 'Is Notify']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('current_latitude',['class' => 'form-control', 'placeholder' => 'Current Latitude']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('current_longitude',['class' => 'form-control', 'placeholder' => 'Current Longitude']);
            echo '</div>';
            echo '<div class="form-group">';
            echo $this->Form->input('role_id', ['options' => $roles],['empty' => true,'class' => 'form-control', 'placeholder' => 'Role Id']);
            echo '</div>';
        ?>
   <?php echo  '<div class="form-group">'; ?>
    <?= $this->Form->button(__('Submit'),['class' => 'btn btn-info']) ?>
    <?= $this->Form->end() ?>
    <?php echo '</div>'; ?>
</div>
        </div>
    </div>
</div>
