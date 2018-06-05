<div class="advertisement form">
    <div class="panel panel-default">
        <div class="panel-heading"><?= __('Edit Advertisement') ?>
            <div class="pull-right rtbutton">
                                <?= $this->Form->postLink('<span class="fa fa-times"></span>&nbsp;&nbsp;Delete',['action' => 'delete', $advertisement->id],['class'=>'btn btn-danger','escape' => false,'confirm' => __('Are you sure you want to delete # {0}?', $advertisement->id)]) ?>
                                &nbsp;&nbsp;<?= $this->Html->link('<span class="fa fa-list-alt"></span>&nbsp;&nbsp;List ', ['action' => 'index'],['class'=>'btn btn-primary','escape' => false]) ?>        
                        
           </div>
        </div>
        <div class="panel-body">
            <div class="col-md-12">
    <?= $this->Form->create($advertisement,['role' => 'form']) ?>
        <?php
            echo '<div class="form-group">';        
            echo $this->Form->input('user_id', ['options' => $users],['class' => 'form-control', 'placeholder' => 'User Id']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('name',['class' => 'form-control', 'placeholder' => 'Name']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('price',['class' => 'form-control', 'placeholder' => 'Price']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('description',['class' => 'form-control', 'placeholder' => 'Description']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('url',['class' => 'form-control', 'placeholder' => 'Url']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('image',['class' => 'form-control', 'placeholder' => 'Image']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('status',['class' => 'form-control', 'placeholder' => 'Status']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('views',['class' => 'form-control', 'placeholder' => 'Views']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('balance',['class' => 'form-control', 'placeholder' => 'Balance']);
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
