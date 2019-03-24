<div class="modal-content custom-message text-center">
    <div class="modal-body">
        <?php echo $this->Form->create(NULL, ['id'=>'custom_messages_form','autocomplete' => 'off','novalidate'=>'novalidate']); ?>
        
        <h2>Custom Messages</h2>
        <span style="display: none"><?=$this->Html->image('user.jpg', ['alt' => 'img','id' => 'default_img']);?></span>
        <div class="to-message">
            <select class="form-control" id="user-list" name="users[]" multiple="multiple" required="required"></select>
        </div>
        <textarea class="message-text text-left" id="cmessage" name="message" required="required"></textarea>
        <span class="char-count">0 characters</span>
        <span class="cmerror hide" style="color:#eb5656;margin:0px 10px">Max 200 characters allowed</span>
        <div class="d-flex pt-20">
            
            <button class="button btn-danger btn-md skip-popup" data-dismiss="modal">Cancel</button>
            <button class="button message-creation send-custom-message btn-md ml-auto">Send Message</button>
            
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#user-list').select2({
            placeholder: 'Select users',
            ajax: {
                url: base_url_admin+'custom-messages/user-list',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: data
                    };
                }                
            },            
            escapeMarkup: function (markup) { return markup; },
            templateResult: formatRepo,
            templateSelection: formatRepoSelection
        });
    });
    function formatRepo (repo) {
        if (repo.loading) {
          return repo.text;
        }
        console.log(repo);
        var markup = "<div class='select2-result-repository clearfix'>" +
          "<div class='select2-result-repository__avatar'><img src='" + repo.avatar_url + "' /></div>" +
          "<div class='select2-result-repository__meta'>" +
          "<div class='select2-result-repository__title'>" + repo.text + "</div>"+
         "</div></div>";

        return markup;
    }
    function formatRepoSelection (repo) {
        return repo.full_name || repo.text;
    }
</script>