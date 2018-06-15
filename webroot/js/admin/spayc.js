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
       success:function(data){   
          $( ".skip-popup").trigger('click');   
          $(".loader").removeClass('show-loader');           
           if (data.result) {
              if($('.status_'+$('#spayc-id').val()).hasClass('block')){
                $('.status_'+$('#spayc-id').val()).removeClass('block').addClass('unblock');                      
                $('span.status_'+$('#spayc-id').val()).text('Unblock');
                if($(".spayc-div-listing").hasClass('square-box'))
                $('.status_'+$('#spayc-id').val()).closest('.square-box').addClass('disabled');  
                else if($(".spayc-div-listing").hasClass('subspayc-box'))
                $('.status_'+$('#spayc-id').val()).closest('.subspayc-box').addClass('disabled');  
              } else {
                $('.status_'+$('#spayc-id').val()).removeClass('unblock').addClass('block');                      
                $('span.status_'+$('#spayc-id').val()).text('Block');
                if($(".spayc-div-listing").hasClass('square-box'))
                $('.status_'+$('#spayc-id').val()).closest('.square-box').removeClass('disabled');
                else if($(".spayc-div-listing").hasClass('subspayc-box'))
                $('.status_'+$('#spayc-id').val()).closest('.subspayc-box').removeClass('disabled');
              }
              if (data.status == 'Active') {                      
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




    $(document).on('click', '#delete_spayc_btn', function (e) {                         
      form = $("form#delete_spayc_form");  
      $(".loader").addClass('show-loader'); 
      var subSpace = false;   
      setTimeout(function(){
      $.ajax({
       type:'POST',
       url:form.prop('action'),
       data: form.serialize(),
       dataType:'JSON',            
       success:function(data){        
          $( ".skip-popup").trigger('click'); 
          $(".loader").removeClass('show-loader');                                      
           if (data.result) {             
              if (data.status == 'Deleted') {                      
                $('.spaycs-msg').removeClass('error-alert').addClass('success-alert');    
              } else { 
                $('.spaycs-msg').removeClass('success-alert').addClass('error-alert');
                if($(".spayc-div-listing").hasClass('square-box'))
                  $('.status_'+$('#spayc-id').val()).closest('.square-box').hide('slow').remove();  
                else if($(".spayc-div-listing").hasClass('table-row')) 
                  $('.status_'+$('#spayc-id').val()).closest('.table-row').hide('slow').remove();  
                else if($(".spayc-div-listing").hasClass('subspayc-box')){
                 subSpace = true;  
                 $('.status_'+$('#spayc-id').val()).closest('.subspayc-box').hide('slow').remove(); 
                }

              }
              if (!$(".spayc-div-listing")[0]){
                if(subSpace)
                  $('.sub_spaycs_count').html('(0)');
                var no_spayc = $("#no-spayc").html();
                $(".main-spayc-div").html(no_spayc);
              };
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
