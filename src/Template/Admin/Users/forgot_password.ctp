<div class="modal-body">
    <?= $this->Form->create('', ['id' => 'ForgetPasswordFrm', 'autocomplete' => 'off','novalidate'=>'novalidate']) ?>
    <span class="error-alert forgot-password-modal-error hide"></span>
    <h1>Forgot Password?</h1>
      <p class="mb-30">Enter your work email address below. We will send you the link to reset your password.</p>
      <div class="form-group">               
        <?= $this->Form->input('email', ['class' => 'form-control', 'label' => 'Email', 'value' =>'', 'maxlength'=> '100']); ?>
        <small class="input-alert" id="emailError"></small>                
      </div>
      <div class="mt-10 d-flex justify-content-between align-items-center">
        <button type="button" id="forgotCancel" class="cancel-text" data-dismiss="modal">Cancel</button>
        <?= $this->Form->button('Submit', ['type' => 'submit', 'class' => 'button btn-md', 'id' => 'forget_password_btn']); ?>
      </div>
   <?php echo $this->Form->end(); ?>
</div>