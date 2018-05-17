jQuery(document).ready(function ($) { 
 
    $(document).on('click', '#set_spayc_status_btn', function (e) {                         
      form = $("form#set_spayc_status_form");  
      $(".loader").addClass('show-loader');          
      setTimeout(function(){
      $.ajax({
       type:'POST',
       url:form.prop('action'),
       data: form.serialize(),
       dataType:'JSON',
       async: false,             
       success:function(data){        
          $(".loader").removeClass('show-loader'); 
          $( ".skip-popup").trigger('click');                            
           if (data.result) {
              if($('.status_'+$('#spayc-id').val()).hasClass('block')){
                $('.status_'+$('#spayc-id').val()).removeClass('block').addClass('unblock');                      
                $('span.status_'+$('#spayc-id').val()).text('Unblock');
              } else {
                $('.status_'+$('#spayc-id').val()).removeClass('unblock').addClass('block');                      
                $('span.status_'+$('#spayc-id').val()).text('Block');
              }
              if (data.status == 'Block') {                      
                $('.spaycs-msg').removeClass('error-alert').addClass('success-alert');  
              } else { 
                $('.spaycs-msg').removeClass('success-alert').addClass('error-alert');
              }
              $('.spaycs-msg').text(data.message);
              messageFadeOut('spaycs-msg',data.message);
            } else {                                                 
              messageFadeOut('spaycs-msg',data.message);
            }
       },
       error: function (e,x,t) {
        $(".loader").removeClass('show-loader'); 
        ajax_error(e);
      }
   });
  });
    e.preventDefault();
  });  


});
