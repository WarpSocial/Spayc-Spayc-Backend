<div class="spaycCategories form">
    <div class="panel panel-default">
        <div class="panel-heading"><?= __('Add Spayc Category') ?>
            <div class="pull-right rtbutton">
                                &nbsp;&nbsp;<?= $this->Html->link('<span class="fa fa-list-alt"></span>&nbsp;&nbsp;List ', ['action' => 'categories'],['class'=>'btn btn-primary','escape' => false]) ?>        
                        
           </div>
        </div>
        <div class="panel-body">
            <div class="col-md-12">
    <?= $this->Form->create($spaycCategory,['role' => 'form']) ?>
        <?php
            echo '<div class="form-group">';
            echo $this->Form->input('parent_id', ['options' => $parentSpaycCategories,'empty' => 'Select Category','class' => 'form-control', 'placeholder' => 'Parent Id']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('name',['class' => 'form-control', 'placeholder' => 'Name']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('code',['class' => 'form-control', 'placeholder' => 'Code']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('description',['class' => 'form-control', 'placeholder' => 'Description']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('status',['class' => 'form-control', 'placeholder' => 'Status']);
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
