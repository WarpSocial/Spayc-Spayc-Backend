<?php
echo $this->element('admin/head');
    if($authUser){  
        echo $this->element('admin/header');
    } 
    echo $this->fetch('content');
?>

<script type="text/javascript">
var base_url = '<?php echo $base_url; ?>';
var base_url_admin = '<?php echo $base_url; ?>admin/';
var errorSuccessMessage = '<?=$error_success_message?>';
errorSuccessMessage = JSON.parse(errorSuccessMessage);
</script>
<?php
echo $this->element('admin/footer',['authUser' => $authUser]);
//echo $this->element('admin/popups');
?>