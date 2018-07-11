<?php
use Cake\Core\Configure;
use Cake\Routing\Router;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Warp Event Notification</title>
    <style>
        body{
          font-family: arial;
        }
    </style>
  </head>
  <body bgcolor="#f2f5f6" style="font-family: arial; font-size: 13px; color:#000;">
    <div style="width: 100%">
      <table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" style="background-color:#fff; max-width:600px;">
        <tbody>
          <tr style="border:0;border-collapse:collapse;background-color:#1a4c59;">
              <td style="width:100%;margin:0;padding:7px 15px;font-size:25px;color: #fff;">
                <?php echo $this->Html->image('logo.png', ['fullBase' => true,'alt' => 'Warp', 'style'=>'text-align: center;display: block;margin: 0 auto;']);?>
              </td>
         </tr>
          <tr>
            <td class="outer-padding" style="background:#fff; border:1px solid #e3e3e3; padding:15px;">
              <table width="100%;" style="font-size:14px; padding-top:10px; padding-bottom:0px;">
                <tbody>
                  <tr>
                    <td style="line-height:23px;">
                      <div style="display: block; font-size: 16px;">Event Notification</div>
                      <div style="margin-top: 25px; color:#272727; font-size: 14px;">Hi <?= $user->display_name ?>,</div>
                      <div style="color:#333333; margin-top:10px; font-size: 13px;">
                          <p>Welcome to <?= Configure::read('title') ?>:</p>
                          <p>Your warp,<?= $user->spayc_name ?> is now active!</p>
                      </div>
                    </td>
                  </tr>
                  
                  <tr>
                    <td>
                      <p style="font-weight: 500;">- Thanks (Warp Team)</p>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:100%; border-top: 1px solid #eaeaea;">
                      <p style="color:#6c6c6c; font-size: 13px;padding-top: 5px;">For general inquiries or to request support with your account, please email admin@warp.com</p>
                    </td>
                  </tr>
                </tbody>
              </table>
            </td>
          </tr>
        </tbody>
      </table>
      <!-- main-table -->
    </div>
  </body>
</html>
