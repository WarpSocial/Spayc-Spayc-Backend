<div class="modal-body">
  <div class="">                                               
    <?php echo $this->Form->create($advertisement, ['id'=>'advertisement_delete_form','autocomplete' => 'off','novalidate'=>'novalidate']); ?>
      <h2>
          Are you sure you want to delete <br />
          <?= !empty($advertisement->name)?'"'.h(ucwords($advertisement->name)).'"':'this' ?> advertisement? 
      </h2>
      <div class="d-flex justify-content-center pt-20">
          <button class="button btn-sm skip-popup" data-dismiss="modal">No</button>
          <button type="button" id="advertisement_delete_btn" class="button btn-sm">Yes</button>
      </div>
    <?php echo $this->Form->end(); ?>
  </div>   
</div>         

