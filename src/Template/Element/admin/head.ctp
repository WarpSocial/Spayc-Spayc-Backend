<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <?=  $this->Html->meta('favicon.ico','favicon.ico',['type' => 'icon']); ?>
    <title><?php echo SITE_TITLE. ' : '.$title ; ?></title>
    <?=$this->Html->css(['bootstrap.min.css','datepicker.css','bootstrap-multiselect.min.css','icon.css','style.css','custom.css']); ?>
    <?=$this->Html->script(['jquery.min.js','commonFunction.js','datepicker.js','bootstrap.min.js','bootstrap-multiselect.min.js','theme.js']); ?>
  </head>
  <body>