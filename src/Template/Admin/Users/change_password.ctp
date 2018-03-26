  <section class="content-wrapper f-password-wrap">
      <!--============= change password ===================-->
      <div class="d-flex justify-content-center align-items-center w-100">
        <div class="change-password-wrapper">         
                <div class="forgot-password-box">
                <div class="error-login-page"><?= $this->Flash->render(); ?></div>
                    <?php echo $this->Form->create($user, ['id'=>'change_password_form','autocomplete' => 'off','novalidate'=>'novalidate', 'role' => 'form']); ?>
                        <h1 class="mb-30">Change Password</h1>
                        <div class="form-group form-group-reset">                      
                        <div class="password-wrap">                           
                        <?php echo $this->Form->input('old_password', ['type'=>'password','class' => 'form-control', 'maxlength'=> '30', 'id'=>'old_password','label' => 'Current Password', 'templates' => ['inputContainer' => '{{content}}']]); ?>
                            <span class="show-password">Show</span>
                            <small class="input-alert" id="oldpasswordError"></small>
                        </div>
                        </div>
                        <div class="form-group form-group-reset">                        
                        <div class="password-wrap">                           
                            <?php echo $this->Form->input('new_password', ['type'=>'password','class' => 'form-control','id'=>'new_password', 'maxlength'=> '30', 'label' => 'New Password', 'templates' => ['inputContainer' => '{{content}}']]); ?>
                            <span class="show-password">Show</span>
                            <small class="input-alert" id="passwordError"></small>
                        </div>
                        </div>
                        <div class="form-group form-group-reset">                        
                        <div class="password-wrap">                            
                            <?php echo $this->Form->input('confirm_password', ['type'=>'password','class' => 'form-control','id'=>'confirm_password', 'maxlength'=> '30', 'label' => 'Confirm Password', 'templates' => ['inputContainer' => '{{content}}']]); ?>
                            <span class="show-password">Show</span>
                            <small class="input-alert" id="confirmpasswordError"></small>
                        </div>
                        </div>

                        <div class="mt-10 d-flex justify-content-between align-items-center">
                        <button type="submit" class="button btn-md ml-auto">Update</button>
                        </div>
                    <?php echo $this->Form->end(); ?>
                    <div class="update-password-wrap hide">
                        <img class="success-reset mb-20" src="images/success.png" alt="" title=""/>
                        <p>New password has been<br /> updated successfully.</p>
                        <button type="submit" class="button btn-md">Proceed</button>
                    </div>
                </div>    
            </div>
        </div>
    </section>
    <?= $this->Html->script('admin/user'); ?>