<div class="reportedWarps form">
    <div class="panel panel-default">
        <div class="panel-heading"><?= __('Add Reported Warp') ?>
            <div class="pull-right rtbutton">
                                &nbsp;&nbsp;<?= $this->Html->link('<span class="fa fa-list-alt"></span>&nbsp;&nbsp;List ', ['action' => 'index'],['class'=>'btn btn-primary','escape' => false]) ?>        
                        
           </div>
        </div>
        <div class="panel-body">
            <div class="col-md-12">
    <?= $this->Form->create($reportedWarp,['role' => 'form']) ?>
        <?php
            echo '<div class="form-group">';        
            echo $this->Form->input('spayc_id', ['options' => $spaycs],['class' => 'form-control', 'placeholder' => 'Spayc Id']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('matrix_room_id',['class' => 'form-control', 'placeholder' => 'Matrix Room Id']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('reported_by',['class' => 'form-control', 'placeholder' => 'Reported By']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('message',['class' => 'form-control', 'placeholder' => 'Message']);
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
