<div class="modal-body">
  <div class="">                                               
    <?php echo $this->Form->create($spayc, ['id'=>'delete_spayc_form','autocomplete' => 'off','novalidate'=>'novalidate']); ?>
      <?php echo $this->Form->input('spayc-id', ['type' => 'hidden', 'value' => $spayc->id]); ?>
      <h2>
          Are you sure you want to Delete<br />
          <?= !empty($spayc->name)?'"'.h(ucwords($spayc->name)).'"':'this' ?> spayc? 
      </h2>
      <div class="d-flex justify-content-center pt-20">
          <button class="button btn-sm skip-popup" data-dismiss="modal">No</button>
          <button type="button" id="delete_spayc_btn" class="button btn-sm">Yes</button>
      </div>
    <?php echo $this->Form->end(); ?>
  </div>   
</div>         

