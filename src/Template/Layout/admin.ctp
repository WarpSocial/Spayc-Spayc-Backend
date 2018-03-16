<?php
echo $this->element('admin/head');
    if($authUser){  
        echo $this->element('admin/header');
    } 
    echo $this->fetch('content');
?>

<script type="text/javascript">
var BASE_URL_ADMIN = '<?php echo $base_url; ?>admin/';
var BASE_URL = '<?php echo $base_url; ?>';
</script>
<?php
echo $this->element('admin/footer',['authUser' => $authUser]);
//echo $this->element('admin/popups');
?>