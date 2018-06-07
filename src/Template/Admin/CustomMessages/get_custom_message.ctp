<style>

    select {
        width: 300px;
    }
    .user-list .user-image {
        width: 50px;
        height: 50%;
        border-radius: 50%;
        overflow: hidden;
    }
    .user-list .user-image span {
        width: 100%;
        height: 100%;
        display: block;
    }
    .user-list .user-image img {
        height: 100%;
        width: 100%;
        object-fit: cover;
    }
    .keywords{height: 210px;
    overflow-y: scroll;}
    .select2-selection__choice{display: none !important; }
    .contact-list-dropdown {position: relative}
    .select2{position: absolute; right: 0; display: none}

</style>

<div class="modal-content custom-message text-center">
    <div class="modal-body">
        <?php echo $this->Form->create(NULL, ['id'=>'custom_messages_form','autocomplete' => 'off','novalidate'=>'novalidate']); ?>
        
        <h2>Custom Messages</h2>
        <div class="to-message">
            <b class="to-text">To</b>
            <div class="keywords">

            </div>
            <div class="contact-list">
                <div class="contact-list-dropdown">
                    
                        <?=$this->Html->image('address-book-contacts.png', ['alt' => 'img','class' => 'img-icon']);?>
                    
                    <button type="button" class="button  btn-sm ml-auto check-all">CheckAll</button>
                    <select id="options" multiple="multiple" name="users[]" required="">
                    </select>
                </div>
            </div>
        </div>
        <textarea class="message-text text-left" name="message"></textarea>
        <div class="d-flex pt-20">
            
            <button class="button btn-danger btn-lg-lg ml-auto skip-popup" data-dismiss="modal">Cancel</button>
            <button class="button message-creation send-custom-message btn-lg-lg ml-auto">Send Message</button>
            
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>

<script>

</script>
<?php echo $this->Html->script(['admin/user','bootstrap-multiselect.min.js',]); ?>
<?php echo $this->Html->script(['admin/user','theme.js']); ?>

<?php echo $this->Html->script(['admin/spayc','admin/custom-messages']); ?>
