<main class="login-page">
      <div class="login-wrapper">
        <div class="image-screen"></div>
        <div class="login-screen">
          <!--====================login=================-->
          <div class="login-box">            
             <!-- <span class="error-alert error-login-page hide">Invalid email and password.</span> -->                          
             <div class="error-login-page"><?= $this->Flash->render(); ?></div>
             <?php echo $this->Form->create($user,['id'=>'adminLogin','autocomplete' => 'off','novalidate'=>'novalidate']); ?>
              <h1>Welcome Admin</h1>
              <p class="mb-30">Login to continue to spayc admin.</p>
              <div class="form-group">               
                <?= $this->Form->input('email',['class'=>'form-control','label'=>'Email', 'maxlength'=> '100']); ?>
                <small class="input-alert" id="emailError"></small>
              </div>
              <div class="form-group">                
                <div class="password-wrap">                  
                  <?= $this->Form->input('password',['class'=>'form-control','label'=>'Password', 'maxlength'=> '30']); ?>                   
                  <span class="show-password">Show</span>                
                  <small class="input-alert" id="passwordError"></small>
                </div>
              </div>

              <div class="mt-10 d-flex justify-content-between align-items-center">
                <button type="button" class="forgot-password-text" data-toggle="modal" data-target="#forgotPassword">Forgot Password?</button>               
                 <?= $this->Form->button('Sign In', ['type' => 'submit','class'=>'button btn-md']); ?>               
                <!--option-->
                <!-- <a href="#" class="hide forgot-password-text" data-toggle="modal" data-target="#forgotPassword">Forgot Password?</a>-->
              </div>
             <?php echo $this->Form->end();?>
          </div>         
        </div>
      </div>
    </main>
<?php echo $this->element('admin/signin/success');?>
<?php echo $this->element('admin/signin/forgot_password');?>
<?php echo $this->Html->script('admin/user'); ?>
