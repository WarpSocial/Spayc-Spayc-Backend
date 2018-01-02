<?php 
use Cake\Core\Configure;
use Cake\Routing\Router;
?>
<div style="font-size:31px;font-family:'Open Sans','HelveticaNeue-Light','Helvetica Neue Light','Helvetica Neue',Helvetica,Arial,'Lucida Grande',sans-serif;color:#404040;padding:0;width:100%!important;font-weight:300!important;margin:0" marginheight="0" marginwidth="0">
    <div style="max-width:600px!important;padding:4px">
        <table cellpadding="0" cellspacing="0" style="padding:0 45px;width:100%!important;padding-top:45px;border:1px solid #f0f0f0;background-color:#ffffff" border="0" align="center">
            <tbody>
                <tr>
                    <td align="center">
                        <table cellspacing="0" border="0" width="100%">
                            <tbody>
                                <tr>
                                    <td style="width:23086px">
                                        <h2><?= Configure::read('title') ?></h2>
                                    </td>
                                    <td style="width:589px"></td>
                                </tr>
                            </tbody>
                        </table>
                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                            <tbody>
                                <tr style="font-size:16px;font-weight:300;color:#404040;font-family:'Open Sans','HelveticaNeue-Light','Helvetica Neue Light','Helvetica Neue',Helvetica,Arial,'Lucida Grande',sans-serif;line-height:26px;text-align:left">
                                    <td>
                                        <br>
                                        <br><?php echo $user['user']->user_name; ?>,
                                        <br>
                                        <br>Someone recently requested a password change for your RehabNetwork account. If this was you, you can set a new password here: 
                                        <br>
                                        <br>
                                        <a style="border-radius:4px;font-size:15px;color:white;text-decoration:none;padding:14px 7px 14px 7px;width:210px;max-width:210px;font-family:Open Sans Helvetica Neue,Arial;margin:0;display:block;background-color:#007ee6;text-align:center" href="<?php echo $this->Url->build(['controller'=>'users','action'=>'resetpassword',$user['token'],  urldecode($user['user']->email)],true); ?>" target="_blank">Reset password</a>
                                        <br>
                                        <br>
                                        <br>If you don't want to change your password or didn't request this, just ignore and delete this message.
                                        <br>
                                        <br>To keep your account secure, please don't forward this email to anyone.
                                        <br>
                                    </td>
                                </tr>
                                <tr><td height="40"></td></tr>
                                <tr>
                                    <td style="background-position:right 50%;border-top:#333333;padding-left:10px;height:25px" align="left">Yours Sincerely,<br></td>
                                    
                                </tr>
                                <tr>
                                    <td style="background-position:right 50%;border-top:#333333;padding-left:10px;height:25px" align="left">
                                        <span style="font-size:8pt">
                                            <strong>
                                                Regards!
                                                <br>Customer Support Team.
                                            </strong>
                                            <br>
                                        </span>
                                        <br>
                                        <a href="mailto:<?= Configure::read('adminEmail') ?>" target="_blank"><?= Configure::read('adminEmail') ?></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
           
            <p>
                <font size="2px">
                This email and its attachments may contain confidential, proprietary or legally privileged information and is intended solely for the use of the individual or entity to whom it is addressed. If 
                <span class="il">you</span> have erroneously received this message, please delete it immediately and notify the sender. Any unauthorized review, use, disclosure, dissemination, forwarding, printing or copying of this email or any action taken in reliance on this e-mail is strictly prohibited and may be unlawful. E-mail transmission cannot be guaranteed to be secure or error-free as information could be intercepted, corrupted, lost, destroyed, incomplete or contain viruses and any views expressed in this message are those of the individual sender and no binding nature of the message shall be implied or assumed unless the sender does so expressly with due authority of <?= Configure::read('title') ?> Tech team.

                </font>
            </p>            
</div>
