<style>

select {
        width: 300px;
    }
    .to-bottom, .keywords {
        width:320px;
        height:200px;

    }
    .to-bottom .select2  {
        height:150px;

    }
    .to-bottom .select2-container--default .select2-selection--multiple .select2-selection__rendered{
        position:relative;
        top:40px
    }

    .keywords .select2  {
        position:relative;
        top:50px;

    }
    .keywords .select2-container--default .select2-selection--multiple .select2-selection__rendered,
    .keywords .select2-search__field{
        position:relative;
        top:-40px
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
                    <option value="jQuery"><span>dadasdads </span>jQuery Tutorials</span></option>
                    <option value="Bootstrap">Bootstrap Framework</option>
                    <option value="HTML">HTML</option>
                    <option value="CSS" >CSS</option>
                    <option value="Angular">Angular</option>
                    <option value="Angular">javascript</option>
                    <option value="Java">Java</option>
                    <option value="Python">Python</option>
                    <option value="MySQL">MySQL</option>
                    <option value="Oracle">Oracle</option>
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
                   url:UserUrls.ForgotPassword,
                   data: {keyword: "sachin"},
                   dataType:'JSON',          
                   processResults:function(data){        
                     return {
                    results: data
                  };
                   }
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
</script>
<?php echo $this->Html->script(['admin/user','bootstrap-multiselect.min.js',]); ?>
<?php echo $this->Html->script(['admin/user','theme.js']); ?>
