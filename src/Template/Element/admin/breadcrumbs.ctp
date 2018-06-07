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
	  ?>
	</div>
</div>