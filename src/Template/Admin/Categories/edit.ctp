<?php echo $this->element('admin/breadcrumbs', ['action'=> 'Add Category']); ?>
<?php
$catTemplates = [
    'inputContainer' => '{{content}}'
];
$this->Form->setTemplates($catTemplates);
?>
<?= $this->Flash->render() ?>
<section class="content-wrapper content-filter">
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                    <h4><?= __('Add Category') ?> </h4>
                </div>
                <div class="col-sm-4 text-right"><?= $this->Html->link('Go Back', ['action' => 'index'],['class'=>'btn button btn-md','escape' => false]) ?>                        
                </div>   
        </div>
        <div class="row">
        <?= $this->Form->create($spaycCategory,['role' => 'form','novalidate']) ?>
                <?php
                    echo '<div class="col-sm-6 category-dropdown">';
                    echo $this->Form->input('parent_id', ['options' => $parentSpaycCategories,'empty' => 'Select once category','class' => 'form-control']);
                    echo '</div>';
                    echo '<div class="col-sm-6">';        
                    echo $this->Form->input('name',['class' => 'form-control', 'placeholder' => 'Name']);
                    echo '</div>';
                    echo '<div class="col-sm-6 emoji-picker-container">';        
                    echo $this->Form->input('code',['class' => 'form-control','label'=>'Emoji', 'placeholder' => 'Emoji']);
                    echo '</div>';
                ?>
           <?php echo  '<div class="col-sm-6 cat-btn">'; ?>
            <?= $this->Form->button(__('Submit'),['class' => 'btn button btn-md']) ?>
            <?= $this->Form->end() ?>
            <?php echo '</div>'; ?>
        </div>        
    </div>
</section>
<?php echo $this->Html->css(['/emoji/css/jquery.emojipicker']); ?>
<?php echo $this->Html->script(['/emoji/js/jquery.emojipicker']); ?>
<?php echo $this->Html->css(['/emoji/css/jquery.emojipicker.a']); ?>
<?php echo $this->Html->script(['/emoji/js/jquery.emojipicker.a']); ?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#parent-id').multiselect({
            enableCaseInsensitiveFiltering: true,
            enableFiltering: true,
            filterBehavior: 'text',
        });
        $('#code').emojiPicker({
            width: '300px',
            height: '200px'
        });
    });
</script>