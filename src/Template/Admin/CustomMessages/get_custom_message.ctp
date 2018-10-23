

<div class="modal-content custom-message text-center">
    <div class="modal-body">
        <?php echo $this->Form->create(NULL, ['id'=>'custom_messages_form','autocomplete' => 'off','novalidate'=>'novalidate']); ?>
        
        <h2>Custom Messages</h2>
        <span style="display: none"><?=$this->Html->image('user.jpg', ['alt' => 'img','id' => 'default_img']);?></span>
        <div class="to-message">
            <b class="to-text">To</b>
            <div class="keywords">

            </div>
            <div class="contact-list">
                <div class="contact-list-dropdown">
                    
                        <?=$this->Html->image('address-book-contacts.png', ['alt' => 'img','class' => 'img-icon']);?>
                    <div class="contact-list-box showup">
                         <label class="check-all-div"><input class="check-all" type="checkbox"> Select All</label>
                        <div class="contact-list-box-wrapper">
                           
                         <select id="options" multiple="multiple" name="users[]" required="">
                         </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <textarea class="message-text text-left" name="message" required="required"></textarea>
        <div class="d-flex pt-20">
            
            <button class="button btn-danger btn-md skip-popup" data-dismiss="modal">Cancel</button>
            <button class="button message-creation send-custom-message btn-md ml-auto">Send Message</button>
            
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>

<script>

</script>
<?php echo $this->Html->script(['admin/user','bootstrap-multiselect.min.js',]); ?>
<?php echo $this->Html->script(['admin/user','theme.js']); ?>

<?php echo $this->Html->script(['admin/spayc','admin/custom-messages']); ?>
