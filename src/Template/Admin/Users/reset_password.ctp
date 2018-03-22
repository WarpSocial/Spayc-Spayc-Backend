<main class="login-page">
      <div class="login-wrapper">
        <div class="image-screen"></div>
        <div class="login-screen">
          <!--====================login=================-->
          <div class="login-box">            
             <!-- <span class="error-alert error-login-page hide">Invalid email and password.</span> -->             
             <span class="error-login-page"><?= $this->Flash->render(); ?></span>
             <?php echo $this->Form->create($user, ['id'=>'reset_password_form','autocomplete' => 'off','novalidate'=>'novalidate']); ?>

              <h1>Reset Password</h1>
              <!-- <p class="mb-30">Login to continue to spayc admin.</p> -->
              
              <div class="form-group">                
                <div class="password-wrap">                           
                    <?php echo $this->Form->input('new_password', ['type'=>'password','class' => 'form-control','id'=>'new_password', 'label' => 'New Password', 'templates' => ['inputContainer' => '{{content}}', 'maxlength'=> '30']]); ?>
                    <span class="show-password">Show</span>
                    <small class="input-alert" id="passwordError"></small>
                </div>
              </div>
              <div class="form-group">                        
                <div class="password-wrap">                            
                    <?php echo $this->Form->input('confirm_password', ['type'=>'password','class' => 'form-control','id'=>'confirm_password', 'label' => 'Confirm Password', 'templates' => ['inputContainer' => '{{content}}', 'maxlength'=> '30']]); ?>
                    <span class="show-password">Show</span>
                    <small class="input-alert" id="confirmpasswordError"></small>
                </div>
              </div>

               <div class="mt-10 d-flex justify-content-between align-items-center">
                  <button type="submit" class="button btn-md">Update</button>
                  <!--option-->
                  <input type="submit" value="Update" class="hide">
              </div>
              <?php echo $this->Form->end(); ?>
          </div>         
        </div>
      </div>
    </main>
<?php echo $this->Html->script('admin/user'); ?>
