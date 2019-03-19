<div class="userFeedbacks form">
    <div class="panel panel-default">
        <div class="panel-heading"><?= __('Add User Feedback') ?>
            <div class="pull-right rtbutton">
                                &nbsp;&nbsp;<?= $this->Html->link('<span class="fa fa-list-alt"></span>&nbsp;&nbsp;List ', ['action' => 'index'],['class'=>'btn btn-primary','escape' => false]) ?>        
                        
           </div>
        </div>
        <div class="panel-body">
            <div class="col-md-12">
    <?= $this->Form->create($userFeedback,['role' => 'form']) ?>
        <?php
            echo '<div class="form-group">';        
            echo $this->Form->input('user_id', ['options' => $users],['class' => 'form-control', 'placeholder' => 'User Id']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('message',['class' => 'form-control', 'placeholder' => 'Message']);
            echo '</div>';
            echo '<div class="form-group">';        
            echo $this->Form->input('attachment',['class' => 'form-control', 'placeholder' => 'Attachment']);
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
