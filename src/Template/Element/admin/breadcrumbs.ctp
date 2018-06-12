<?php
use Cake\Routing\Router;
$controller_name = $this->request->param('controller');
$name = (strtolower($controller_name) == 'spaycs')?"Manage ".SITE_TITLE.'s': "Manage ".ucfirst($controller_name);
?>
 <div class="breadcrumbs">
	<div class="container">
	  <h4>Manage <?= $name?></h4>
	  <?php 
  		$html = '';
  		$html ="<p><span>".$this->Html->link($name,['controller' => $controller_name, 'action' => 'index'])."</span>";
  		if(!empty($action))
  		$html .="<span>".$action."</span>";
  		$html .="</p>";
  		echo $html;
	  if($controller_name=='CustomMessages'){
//              echo '<button class="button message-creation btn-lg-lg" data-toggle="modal" data-target="#customMessage">Custom Messages</button>';
                ?>
          <button type="button" rel="modal-dialog-lg confirm-message" class="pop button message-creation btn-lg-lg" page="<?php echo $this->Url->build(["controller" => "CustomMessages","action" => "getCustomMessage"]);?>">
                      Custom Messages</button> 
          <?php } ?>
          
	</div>
</div>
