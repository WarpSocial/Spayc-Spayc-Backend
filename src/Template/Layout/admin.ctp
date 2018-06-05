<?php
echo $this->element('admin/head');
echo $this->element('admin/paths');
    if($authUser){  
        echo $this->element('admin/header', ['authUser' => $authUser]);
    } 
    echo $this->fetch('content');
?>
<?php
echo $this->element('admin/footer',['authUser' => $authUser]);
?>