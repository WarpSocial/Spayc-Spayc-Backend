<div class="spaycs form">
    <div class="panel panel-default">
        <div class="panel-heading"><?= __('Edit Spayc') ?>
            <div class="pull-right rtbutton">
                                <?= $this->Form->postLink('<span class="fa fa-times"></span>&nbsp;&nbsp;Delete',['action' => 'delete', $spayc->id],['class'=>'btn btn-danger','escape' => false,'confirm' => __('Are you sure you want to delete # {0}?', $spayc->id)]) ?>
                                &nbsp;&nbsp;<?= $this->Html->link('<span class="fa fa-list-alt"></span>&nbsp;&nbsp;List ', ['action' => 'index'],['class'=>'btn btn-primary','escape' => false]) ?>        
                        
           </div>
        </div>
        <div class="panel-body">
            <div class="col-md-12">
    <?= $this->Form->create($spayc,['role' => 'form']) ?>
        <?php
            echo '<div class="form-group">';        
            echo $this->Form->input('user_id', ['options' => $users],['class' => 'form-control', 'placeholder' => 'User Id']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('name',['class' => 'form-control', 'placeholder' => 'Name']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('location',['class' => 'form-control', 'placeholder' => 'Location']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('type',['class' => 'form-control', 'placeholder' => 'Type']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('group_type',['class' => 'form-control', 'placeholder' => 'Group Type']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('start_date',['class' => 'form-control', 'placeholder' => 'Start Date']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('end_date',['class' => 'form-control', 'placeholder' => 'End Date']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('passcode',['class' => 'form-control', 'placeholder' => 'Passcode']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('description',['class' => 'form-control', 'placeholder' => 'Description']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('image',['class' => 'form-control', 'placeholder' => 'Image']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('longitude',['class' => 'form-control', 'placeholder' => 'Longitude']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('latitude',['class' => 'form-control', 'placeholder' => 'Latitude']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('status',['class' => 'form-control', 'placeholder' => 'Status']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('matrix_room_id',['class' => 'form-control', 'placeholder' => 'Matrix Room Id']);
            echo '</div>';
            echo '<div class="form-group">';
            echo $this->Form->input('parent_id', ['options' => $parentSpaycs],['empty' => true,'class' => 'form-control', 'placeholder' => 'Parent Id']);
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
