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
                            <strong><?= $user->username ?></strong>,
                            <br>
                            <br>
                        <p>Welcome to <?= Configure::read('title') ?>:</p>
                        </p>
                        <p>
                           The new frontier of social media! You're on your way to exploring and connecting with the local community! To get started try creating a spayc, joining a spayc, and inviting some of your friends!
                        </p>
                        
                        <hr>
                        <p><br>
                            <a href="<?php echo $this->Url->build('/api/verify/'.$user->token_verification.'/'. urlencode($user->email).'.html',true); ?>"  target="_blank" ><font face="'Walsheim-Medium', Arial, sans-serif">VERIFY YOUR EMAIL ADDRESS</font></a>
                            <br><br>
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>