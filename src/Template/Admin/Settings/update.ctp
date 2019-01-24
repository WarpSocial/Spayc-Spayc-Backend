<div class="spaycCategories form">
    <div class="panel panel-default">
        <div class="panel-heading"><?= __('Edit Spayc Category') ?>
            <div class="pull-right rtbutton">
                                <?= $this->Form->postLink('<span class="fa fa-times"></span>&nbsp;&nbsp;Delete',['action' => 'delete', $spaycCategory->id],['class'=>'btn btn-danger','escape' => false,'confirm' => __('Are you sure you want to delete # {0}?', $spaycCategory->id)]) ?>
                                &nbsp;&nbsp;<?= $this->Html->link('<span class="fa fa-list-alt"></span>&nbsp;&nbsp;List ', ['action' => 'index'],['class'=>'btn btn-primary','escape' => false]) ?>        
                        
           </div>
        </div>
        <div class="panel-body">
            <div class="col-md-12">
    <?= $this->Form->create($spaycCategory,['role' => 'form']) ?>
        <?php
            echo '<div class="form-group">';
            echo $this->Form->input('parent_id', ['options' => $parentSpaycCategories],['empty' => true,'class' => 'form-control', 'placeholder' => 'Parent Id']);
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
