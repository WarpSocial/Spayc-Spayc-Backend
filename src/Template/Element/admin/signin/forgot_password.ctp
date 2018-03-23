 <div class="modal modal-center fade" id="forgotPassword" tabindex="-1" role="dialog"  aria-hidden="true">
      <div class="modal-dialog modal-dialog-sm" role="document">
        <div class="modal-content forgot-password-box">
          <div class="modal-body">                      
            <?= $this->Form->create('', ['url' => ['controller' => 'users', 'action' => 'forgot-password'], 'id' => 'ForgetPasswordFrm', 'autocomplete' => 'off','novalidate'=>'novalidate']) ?>
            <span class="error-alert error-forgot-password-page hide">Not a registered email.</span>              
            <h1>Forgot Password?</h1>
              <p class="mb-30">Enter your work email address below. We will send you the link to reset your password.</p>
              <div class="form-group">               
                <?= $this->Form->input('email', ['class' => 'form-control', 'label' => 'Email', 'value' =>'', 'maxlength'=> '100']); ?>
                <small class="input-alert" id="emailError"></small>                
              </div>
              <div class="mt-10 d-flex justify-content-between align-items-center">
                <button type="button" id="forgotCancel" class="cancel-text" data-dismiss="modal">Cancel</button>
                <?= $this->Form->button('Submit', ['type' => 'button', 'class' => 'button btn-md', 'id' => 'forget_password_btn']); ?>
                <!--======option======-->
                <!-- <a href="#" class="hide cancel-text" data-dismiss="modal">Cancel</a>-->
              </div>
           <?php echo $this->Form->end(); ?>
          </div>
        </div>
      </div>
</div>

