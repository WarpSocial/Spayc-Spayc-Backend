<?php ?>
<!DOCTYPE html>
<?= $this->Html->charset() ?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?=  $this->Html->meta('favicon.ico','favicon.ico',['type' => 'icon']); ?>
    <title>Account verification</title>
    <!--===============stylesheet=================-->
    <?=$this->Html->css('bootstrap.min.css');?>
    <?=$this->Html->css('Api.style.css');?>
  </head>

 <body>
    <!--=============content section===========-->
    <section class="forgot-password-wrapper">
        <!--================forgot password=====================-->
        <div class="forgot-password-box forgot-password-web">
          <div class="logo-wrap">
            <?php echo $this->Html->image('logo-gr.png', ['alt' => 'Spayc']);?>
              <h4>Account Verification</h4>
          </div>
            <div class="success-reset-password">                
            <div class="logo-wrap hide">
                <?php echo $this->Html->image('logo-gr.png', ['alt' => 'Spayc']);?>
            </div>
            <span> <?= $this->Flash->render() ?></span>
          </div>
        </div>
    </section>
    <!--=============== javascript=================-->
    <?=$this->Html->script('jquery.min');?>
    <?=$this->Html->script('bootstrap.min');?>
    <?=$this->Html->script('app');?>
  </body>
</html>