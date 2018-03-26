<?php if($authUser){  ?>
<section class="content-wrapper f-password-wrap">
      <!--============= change password Update successfully ===================-->
  <div class="d-flex justify-content-center align-items-center w-100">
    <div class="change-password-wrapper">
            <div class="forgot-password-box">                  
                <div class="update-password-wrap">
                   <?php echo $this->Html->image("success.png", ["alt" => "success"]); ?>
                    <p>Your password has been<br /> updated successfully.</p>
                    <?php echo $this->Html->link('Ok',['controller' => 'Users', 'action' => 'change-password'], ['class' => 'button btn-md']);?>
                </div>
            </div>    
        </div>
    </div>
</section>
<?php } else { ?>
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
<?php } ?>