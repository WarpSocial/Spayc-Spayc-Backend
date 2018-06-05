<style>

select {
        width: 300px;
    }

</style>

<div class="modal-content custom-message text-center">
<div class="modal-body">
            <h2>Custom Messages</h2>
            <div class="to-message">
              <b class="to-text">To</b>
              <div class="keywords">
              
              </div>
              <div class="contact-list">
                <div class="contact-list-dropdown">
                  <select id="options" multiple="multiple">
                  </select>
                </div>
              </div>
            </div>
            <p class="message-text text-left">
              Another greater WordCampKL after 7 years! We have 16 speakers from around the globe,
              covering diverse topics related to; technical, business, e-commerce, entrepreneurship,
              and blogging. We also have speakers from Automattic (the company behind Another greater
              WordCampKL after 7 years! We have 16 speakers from around the globe,.
            </p>
            <div class="d-flex pt-20">
              <button class="button message-creation btn-lg-lg ml-auto">Send Message</button>
            </div>
          </div>
</div>

<script>

$(function(){
    $('#options').select2({
    "placeholder": "Pick options",
    "multiple": true,
     ajax: {
                   type:'POST',
                   url:UserUrls.searchUser,
                  dataType: 'json',
                delay: 250,
                data: function (term) {
                return {
                q: term
                 };
                }
               },
        templateResult: template,
      escapeMarkup: function(m) {
           return m;
        }
  })
  .on("select2:select", function(e) {
            var array = $("#options").val();
            $(".keywords").html('');
            $.each(array,function(i){
            $(".keywords").append('<span>'+array[i]+' <i class="close-keyword"></i></span>');
            });
  })
  .on("select2:unselect", function(e) {
            var array = $("#options").val();
            $(".keywords").html('');
            $.each(array,function(i){
            $(".keywords").append('<span>'+array[i]+' <i class="close-keyword"></i></span>');
            });
  });

$('.close-keyword').bind('click', function() {

alert($(this).val());
})

       
});


function template(data) {
	return "<div class='user-list'>\
                <div class='user-image'><span><img src ='"+data.image_url+"' class='image-responsive'></span></div>\
		<div class='user-list-info'>\
		<span class='user-name ell'>"+data.text+"</span><br>\
		<span class='user-id ell'>"+data.email+"</span>\
		</div></div>";

	//return "<div style='color:red'>"+data.text+"</div><div><small>............</small></div>";
}

</script>
<?php echo $this->Html->script(['admin/user','bootstrap-multiselect.min.js',]); ?>
<?php echo $this->Html->script(['admin/user','theme.js']); ?>
