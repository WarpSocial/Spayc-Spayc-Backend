<?php
use Cake\Routing\Router;
?>
<script type="text/javascript">
var base_url = '<?php echo $base_url; ?>';
var base_url_admin = '<?php echo $base_url; ?>admin/';
var errorSuccessMessage = '<?=$error_success_message?>';
errorSuccessMessage = JSON.parse(errorSuccessMessage);
var UserUrls = {
            'searchUser':'<?php echo Router::url(['_name' => 'searchUser']); ?>',
            'ForgotPassword':'<?php echo Router::url(['_name' => 'forgotPassword']); ?>',
            'Success': '<?php echo Router::url(['_name' => 'success']); ?>',
        };
    
</script>
