<?php 
$input = $this->request->getData();
?>
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
    <?=$this->Html->css('Api.style.css');?>
    <style>
        .form-group input.form-control.reset-alert {
            border-color: red;
        }
        .chint {
            position: absolute;
            color: red;
            bottom: 9px;
            font-size: 11px;
        }
        .red-alert {
            color :red !important;
        }
        .error-alert {
            position: relative;
        }
    </style>
  </head>
  
 <body>
    <!--=============content section===========-->
    <section class="forgot-password-wrapper">
        <!--================forgot password=====================-->
        <div class="forgot-password-box forgot-password-web">
          <div class="logo-wrap">
            <?php echo $this->Html->image('Api.logo.png', ['alt' => 'Spayc']);?>
          </div>
            <?php
            if($status == 'done'){
              ?>
            <div class="success-reset-password">
            <span>Your password has been reset successfully.</span>
          </div>
            <?php
            }elseif($status == 'error'){
               // echo '<h4>Reset Password</h4>';
                echo $this->Flash->render();
            }else{
            ?>
          <?php echo $this->Form->create($user, ['id'=>'resetpaswd-frm','class'=>'reset-password','novalidate']);?>
            <h4>Reset Password</h4>
            <p class="mb-30">Enter new password and confirm it.</p>
            <p><?php echo $this->Flash->render() ?></p>
            <?php
                $pinputClass = !empty($input['new_password'])?'form-control form-input filled':"form-control form-input";
                $cpinputClass = !empty($input['confirm_password'])?'form-control form-input filled':"form-control form-input";
                $cfocused = !empty($input['new_password'])?'focused':"";
                $cpfocused = !empty($input['confirm_password'])?'focused':"";
                ?>
            <div class="form-group <?= $cfocused ?>">
                <label class="form-label <?= $cfocused ?>" for="password">New Password</label>
                
                <?php echo $this->Form->control('new_password', ['type'=>'password', 'class'=>$pinputClass, 'label'=>false]);?>
                <small class="hint">Hint: Requires at least 1 number and 1 letter.</small>

            </div>
            <div class="form-group confirm-password <?= $cfocused ?>">
              <label class="form-label <?= $cpfocused ?>" for="confirm-password">Confirm New Password</label>
              <?php echo $this->Form->control('confirm_password', ['type'=>'password', 'class'=>$cpinputClass, 'label'=>false]);?>
               <small class="chint"></small>
            </div>

            <div class="mt-10 d-flex justify-content-between align-items-center">
              <!--button type="submit" class="button btn-w-100">Save</button-->
              <?php echo $this->Form->button('Save', ['type'=>'submit','id'=>'reset-btn', 'class'=>['button', 'btn-w-100']]);?>             
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
    <script type="text/javascript">
        $('#resetpaswd-frm').submit(function(e){        
           if($.trim($('#password').val())==''){
               $('#password').addClass('reset-alert');
               $('.hint').text('Requires at least 1 number and 1 letter.');
               $('#password').focus();
               return false;
           }
           if($.trim($('#confirm-password').val())==''){
               $('#confirm-password').addClass('reset-alert');
               $('#confirm-password').focus();
               return false;
           }
           if(($('#password').val()) != ($('#confirm-password').val())){
               $('#confirm-password').addClass('reset-alert');
               $('.chint').text('Password not matched.');
               $('#confirm-password').focus();
               return false;
           }         
       });
    </script>
  </body>
</html>