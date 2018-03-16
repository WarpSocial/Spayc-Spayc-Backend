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