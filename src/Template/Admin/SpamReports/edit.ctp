<div class="spamReports form">
    <div class="panel panel-default">
        <div class="panel-heading"><?= __('Edit Spam Report') ?>
            <div class="pull-right rtbutton">
                                <?= $this->Form->postLink('<span class="fa fa-times"></span>&nbsp;&nbsp;Delete',['action' => 'delete', $spamReport->id],['class'=>'btn btn-danger','escape' => false,'confirm' => __('Are you sure you want to delete # {0}?', $spamReport->id)]) ?>
                                &nbsp;&nbsp;<?= $this->Html->link('<span class="fa fa-list-alt"></span>&nbsp;&nbsp;List ', ['action' => 'index'],['class'=>'btn btn-primary','escape' => false]) ?>        
                        
           </div>
        </div>
        <div class="panel-body">
            <div class="col-md-12">
    <?= $this->Form->create($spamReport,['role' => 'form']) ?>
        <?php
            echo '<div class="form-group">';        
            echo $this->Form->input('reported_by',['class' => 'form-control', 'placeholder' => 'Reported By']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('reported_to',['class' => 'form-control', 'placeholder' => 'Reported To']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('event_id',['class' => 'form-control', 'placeholder' => 'Event Id']);
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
