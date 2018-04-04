<div class="modal-body">
  <div class="">                                               
    <?php echo $this->Form->create($user, ['id'=>'set_user_status_form','autocomplete' => 'off','novalidate'=>'novalidate']); ?>
      <?php echo $this->Form->input('user-id', ['type' => 'hidden', 'value' => $user->id]); ?>
      <h2>
          Are you sure you want to <?= (strtolower($user->status) == 'active')?"Block":"Unblock";?><br />
          <?= !empty($user->display_name)?'"'.h(ucwords($user->display_name)).'"':'this' ?>user? 
      </h2>
      <div class="d-flex justify-content-center pt-20">
          <button class="button btn-sm skip-popup" data-dismiss="modal">No</button>
          <button type="button" id="set_user_status_btn" class="button btn-sm">Yes</button>
      </div>
    <?php echo $this->Form->end(); ?>
  </div>   
</div>         

