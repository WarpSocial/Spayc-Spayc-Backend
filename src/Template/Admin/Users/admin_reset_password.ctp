         <div class="modal-body">
          <div class="">                                               
             <?php echo $this->Form->create($user, ['id'=>'admin_reset_password_form','autocomplete' => 'off','novalidate'=>'novalidate']); ?>
              <span class="error-alert error-forgot-password-page hide"></span>
              <h1>Change Password</h1>
              <p class="mb-50">Please enter a new password in the fields below.</p>
              
              <div class="form-group form-group-reset">                
                <div class="password-wrap">                           
                    <?php echo $this->Form->input('new_password', ['type'=>'password','class' => 'form-control','maxlength'=> '30','id'=>'new_password', 'label' => 'New Password', 'templates' => ['inputContainer' => '{{content}}']]); ?>
                    <span class="show-password">Show</span>
                    <small class="input-alert" id="passwordError"></small>
                </div>
              </div>
              <div class="form-group form-group-reset">                        
                <div class="password-wrap">                            
                    <?php echo $this->Form->input('confirm_password', ['type'=>'password','class' => 'form-control','maxlength'=> '30','id'=>'confirm_password', 'label' => 'Confirm Password', 'templates' => ['inputContainer' => '{{content}}']]); ?>
                    <span class="show-password">Show</span>
                    <small class="input-alert" id="confirmpasswordError"></small>
                </div>
              </div>
             
               <div class="mt-40 d-flex justify-content-between align-items-center">
                  <button type="button" class="skip-text skip-popup" data-dismiss="modal">Skip</button>
                  <button type="submit" class="button btn-md ml-auto">Update</button>
              </div>
              <?php echo $this->Form->end(); ?>
          </div>   
          </div>         
