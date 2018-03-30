<div class="modal-body">
  <div class="">                                               
    <?php echo $this->Form->create($user, ['id'=>'set_user_status_form','autocomplete' => 'off','novalidate'=>'novalidate']); ?>
        <span class="error-alert error-forgot-password-page hide"></span>
        <p>
            Are you sure you want to <?= (strtolower($user->status) == 'active')?"Block":"Unblock";?><br />
            <?= !empty($user->display_name)?'"'.h(ucwords($user->display_name)).'"':'' ?>user? 
        </p>
        <div class="mt-40 d-flex justify-content-between align-items-center">
          <button type="button" class="skip-text skip-popup" data-dismiss="modal">No</button>
          <button type="submit" class="button btn-md ml-auto">Yes</button>
       </div>
    <?php echo $this->Form->end(); ?>
  </div>   
</div>         
<?php echo $this->Html->script('admin/user'); ?>
