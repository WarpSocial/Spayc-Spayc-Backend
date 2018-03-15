<?php ?>
<!DOCTYPE html>
<?= $this->Html->charset() ?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?=  $this->Html->meta('favicon.ico','favicon.ico',['type' => 'icon']); ?>
    <title>Spayc Reset Password</title>
    <!--===============stylesheet=================-->
    <?=$this->Html->css('bootstrap.min.css');?>
    <?=$this->Html->css('style.css');?>
  </head>

 <body>
    <!--=============content section===========-->
    <section class="forgot-password-wrapper">
        <!--================forgot password=====================-->
        <div class="forgot-password-box forgot-password-web">
          <div class="logo-wrap">
            <?php echo $this->Html->image('logo-gr.png', ['alt' => 'Spayc']);?>
          </div>
            <?php
            if($status == 'done'){
              ?>
            <div class="success-reset-password">
            <div class="logo-wrap hide">
                <?php echo $this->Html->image('logo-gr.png', ['alt' => 'Spayc']);?>
            </div>
            <span>Your password has been reset successfully.</span>
          </div>
            <?php
            }else{
            ?>
          <?php echo $this->Form->create('Users', [
    'context' => ['validator' => 'reset'],'class'=>['reset-password']
]);?>
            <h4>Reset Password</h4>
            <p class="mb-30">Enter new password and confirm it.</p>
            <p><?php echo $this->Flash->render() ?></p>
            <div class="form-group">
                <!--label class="form-label" for="password">New Password</label>
                <input type="password" name="password" class="form-control form-input " id="password"-->
                <?php echo $this->Form->control('password', ['type'=>'password', 'class'=>['form-control', 'form-input'], 'placeholder'=>'New Password', 'label'=>false]);?>
                <small class="hint">Hint: Requires at least 1 number and 1 letter.</small>

            </div>
            <div class="form-group confirm-password">
              <!--label class="form-label" for="confirm-password">Confirm New Password</label-->
              <?php echo $this->Form->control('confirm_password', ['type'=>'password', 'class'=>['form-control', 'form-input'], 'placeholder'=>'Confirm New Password', 'label'=>false]);?>
            </div>

            <div class="mt-10 d-flex justify-content-between align-items-center">
              <!--button type="submit" class="button btn-w-100">Save</button-->
              <?php echo $this->Form->button('Save', ['type'=>'submit', 'class'=>['button', 'btn-w-100']]);?>
              <!--option-->
              <!--input type="submit" value="Save" class="hide"-->
              
            </div>
          <?php echo $this->Form->end();?>
            <?php } ?>
        </div>
    </section>
    <!--=============== javascript=================-->
    <?=$this->Html->script('jquery.min');?>
    <?=$this->Html->script('bootstrap.min');?>
    <?=$this->Html->script('app');?>
  </body>
</html>