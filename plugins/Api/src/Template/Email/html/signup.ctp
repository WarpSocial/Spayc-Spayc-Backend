<?php
use Cake\Core\Configure;
use Cake\Routing\Router;
?>
<table border="0" cellpadding="0" cellspacing="0" style="border-right:#333333 1px dotted;border-top:#333333 1px dotted;border-left:#333333 1px dotted;border-bottom:#333333 1px dotted" width="700">
            <tbody>
                <tr>
                    <td align="left" bgcolor="#ffffff" style="padding-right:10px;padding-left:10px;padding-bottom:10px;padding-top:10px;width:893px">
                        <table style="width:672px">
                            <tbody>
                                <tr>
                                    <td style="width:23086px">
                                       <h2><?= Configure::read('title') ?></h2>
                                    </td>
                                    <td style="width:589px"></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="padding-right:10px;padding-left:10px;padding-bottom:10px;padding-top:10px">
                        <p style="line-height:1.7">Dear 
                            <strong><?= $user->user_name ?></strong>,
                            <br>
                            <br>
                        <p>Thanks for reaching out! <?= Configure::read('title') ?>!.</p>
                        </p>
                        <p>
                           We’ve sent you an email at the email address you provided. All you need to do is click the button below (it only takes a few seconds). We are simply verifying ownership of this email address.
                        </p>
                        
                        <hr>
                        <p><br>
                            <a href="<?php echo $this->Url->build('/api/verify/'.$user->token_verification.'/'. urlencode($user->email).'.html',true); ?>" style="color:#ffffff;text-decoration:none;background-color:#02ADC6;border-top:15px solid #02ADC6;border-bottom:15px solid #02ADC6;border-left:15px solid #02ADC6;border-right:15px solid #02ADC6;display:inline-block" target="_blank" ><font style="font-size:18px;line-height:20px" color="#ffffff" face="'Walsheim-Medium', Arial, sans-serif">VERIFY YOUR EMAIL ADDRESS</font></a>
                            <br><br>
                        </p>
                        <hr>
                        <p>
                            If you don't verify your email address, we are required to temporarily put your account on hold until verification is complete.
                        </p>
                        <p>
                            Your registration information is below.You may wish to retain a copy for your records
                        </p>
                    </td>
                </tr>
                <tr>
                    <td style="padding-right:10px;padding-left:10px;padding-bottom:10px;padding-top:10px;width:893px" align="center">
                        <table align="left" border="0" cellspacing="0" cellpadding="0" style="width:616px">
                            <tbody>
                                <tr>
                                    <td align="center" valign="top" colspan="2">
                                        <table border="0" cellpadding="3" cellspacing="3" style="width:648px;border:1px outset #cccccc;background-color:#f5f5f5">
                                            <tbody>
                                                <tr>
                                                    <td align="left" style="height:21px">
                                                        <span>
                                                            <strong>Username</strong>
                                                        </span>
                                                    </td>
                                                    <td align="left" style="height:21px"><?= $user->user_name; ?></td>
                                                    <td align="left" style="height:21px">
                                                        <strong>Contact</strong>
                                                    </td>
                                                    <td align="left" style="height:21px"><?php echo $user->phone; ?></td>
                                                </tr>
                                                <tr>
                                                    <td align="left" style="height:21px">
                                                        <strong>Email</strong>
                                                    </td>
                                                    <td align="left" style="height:21px"><?php echo $user->email; ?></td>
                                                    <td align="left" style="height:21px">
                                                        <strong>Password </strong>
                                                    </td>
                                                    <td align="left"><?php echo $user->confirm_password; ?></td>
                                                </tr>                                              
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding-right:0px;background-position:right 50%;border-top:#333333;padding-left:10px;padding-bottom:0px;padding-top:10px;background-repeat:no-repeat;height:49px" align="left">
                                        
                                        <br>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="background-position:right 50%;border-top:#333333;padding-left:10px;height:25px" align="left">Yours Sincerely,</td>
                                    <td style="background-position:right 50%;border-top:#333333;padding-left:10px;height:25px" align="center">
                                        &nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="background-position:right 50%;border-top:#333333;padding-left:10px;height:25px" align="left">
                                        <span style="font-size:8pt">
                                            <strong>Regards!
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
        <div>
           
            <p>
                <font size="2px">
                This email and its attachments may contain confidential, proprietary or legally privileged information and is intended solely for the use of the individual or entity to whom it is addressed. If 
                <span class="il">you</span> have erroneously received this message, please delete it immediately and notify the sender. Any unauthorized review, use, disclosure, dissemination, forwarding, printing or copying of this email or any action taken in reliance on this e-mail is strictly prohibited and may be unlawful. E-mail transmission cannot be guaranteed to be secure or error-free as information could be intercepted, corrupted, lost, destroyed, incomplete or contain viruses and any views expressed in this message are those of the individual sender and no binding nature of the message shall be implied or assumed unless the sender does so expressly with due authority of <?= Configure::read('title') ?>  Tech team.

                </font>
            </p>            
        </div>