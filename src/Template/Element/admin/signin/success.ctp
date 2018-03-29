 <div class="modal modal-center fade" id="success" tabindex="-1" role="dialog"  aria-hidden="true">
      <div class="modal-dialog modal-dialog-sm" role="document">
        <div class="modal-content forgot-password-box text-center">
          <div class="modal-body">              
              <?php echo $this->Html->image("success.png", ["alt" => "success", 'class' =>'success-reset mb-20']); ?>
              <p>
                A link to reset your password has been<br />
                sent to your work email.
              </p>
              <p class="mb-30">Please check your inbox.</p>
              <button type="button" class="button btn-md hide" data-dismiss="modal">ok</button>
               <a href="<?php echo $base_url_admin;?>" class="button btn-md">ok</a>
          </div>
        </div>
      </div>
</div>