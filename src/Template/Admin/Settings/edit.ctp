<section class="content-wrapper content-filter">
    <div class="container">
<div class="settings form">
    <div class="panel panel-default">
        <div class="panel-heading"><?= __('Edit Setting') ?>
            <div class="pull-right rtbutton">
                                <?= $this->Form->postLink('<span class="fa fa-times"></span>&nbsp;&nbsp;Delete',['action' => 'delete', $setting->id],['class'=>'btn btn-danger','escape' => false,'confirm' => __('Are you sure you want to delete # {0}?', $setting->id)]) ?>
                                &nbsp;&nbsp;<?= $this->Html->link('<span class="fa fa-list-alt"></span>&nbsp;&nbsp;List ', ['action' => 'index'],['class'=>'btn btn-primary','escape' => false]) ?>        
                        
           </div>
        </div>
        <div class="panel-body">
            <div class="col-md-12">
    <?= $this->Form->create($setting,['role' => 'form']) ?>
        <?php
            echo '<div class="form-group">';        
            echo $this->Form->input('param',['class' => 'form-control', 'placeholder' => 'Param']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('param_value',['class' => 'form-control', 'placeholder' => 'Param Value']);
            echo '</div>';
        ?>
   <?php echo  '<div class="form-group">'; ?>
    <?= $this->Form->button(__('Submit'),['class' => 'btn btn-info']) ?>
    <?= $this->Form->end() ?>
    <?php echo '</div>'; ?>
</div>
        </div>
    </div>
</div>
    </div>
</section>