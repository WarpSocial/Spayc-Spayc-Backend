<?php
use Cake\Routing\Router;
?>
<!-- 
<div class="modal fade" id="waitlistCode" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">         
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">          
          <div class="text-center">
          <p class="successMsg"></p>          
           <?php //echo $this->Html->link(__('OK'), ['controller' => 'members', 'action' => 'referral'], ['class' => 'btn btn-yellow cmnmsg']); ?> 
          </div>
        </div>
      </div>
    </div>
</div>
 -->
<div class="modal modal-center fade" id="success" tabindex="-1" role="dialog"  aria-hidden="true">
      <div class="modal-dialog modal-dialog-sm" role="document">
        <div class="modal-content forgot-password-box text-center">
          <div class="modal-body">
              <img class="success-reset mb-20" src="images/success.png" alt="" title=""/>
              <p>
                A link to reset your password has been<br />
                sent to your work email.
              </p>
              <p class="mb-30">Please check your inbox.</p>
              <button type="button" class="button btn-md" data-dismiss="modal">ok</button>
          </div>
        </div>
      </div>
</div>

<div class="loader" id="loader">
	<span>Loading...</span>
</div>
