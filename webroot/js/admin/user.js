jQuery(document).ready(function ($) { 
    $(document).on('click', '.show-password', function (e) {   
        var attrObj = $(this).parent("div").find('input');
        if (attrObj.attr('type') == 'text') { 
            $(this).text('Show');
             attrObj.prop({type: 'password'});
        } else {            
            $(this).text('Hide');
            attrObj.prop({type: 'text'});
        }
    });
    var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    var passwordPattern = /^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,30}?$/i;
    var err=0;    
    $('#adminLogin').submit(function () {          
        $('.input-alert').text('');
        $('input').removeClass('incorrect-alert');
        if ($.trim($('#email').val()) == '') {            
            $('#email').addClass('incorrect-alert');
            $('#emailError').text(errorSuccessMessage['BLANKEMAIL']);
            return false;
        }
        if (!pattern.test($.trim($('#email').val()))) {
            $('#email').addClass('incorrect-alert');
            $('#emailError').text(errorSuccessMessage['INVALIDEMAIL']);
            return false;
        }
        if ($.trim($('#password').val()) == '') {
            $('#password').addClass('incorrect-alert');
            $('#passwordError').text(errorSuccessMessage['BLANKPASS']);
            return false;
        }
        return true;
    });
   
    $(document).on('submit', '#ForgetPasswordFrm', function (e) {           
        $('.input-alert').text('');
        $('.error-forgot-password-page').addClass('hide');
        $('input').removeClass('incorrect-alert');        
        var email = $("#ForgetPasswordFrm input[name='email']");
        err=0; 
        $('input').removeClass('incorrect-alert');
        if ($.trim(email.val()) == '') { 
            err = 1;           
            email.addClass('incorrect-alert');
            $('#ForgetPasswordFrm #emailError').text(errorSuccessMessage['BLANKEMAIL']);
            return false;
        }
        if (!pattern.test($.trim(email.val()))) {           
            err = 1;
            email.addClass('incorrect-alert');
            $('#ForgetPasswordFrm #emailError').text(errorSuccessMessage['INVALIDEMAIL']);
            return false;
        }          
        if(err==0){ 
        $(".loader").addClass('show-loader');          
          setTimeout(function(){
            $.ajax({
                   type:'POST',
                   url:UserUrls.ForgotPassword,
                   data: {email: email.val()},
                   dataType:'JSON',
                   async: false,             
                   success:function(data){        
                      $(".loader").removeClass('show-loader');        
                       if (data.result) {     
                            $( "#forgotCancel").trigger('click'); 
                            openPopup(UserUrls.Success);                   
                        } else { 
                          messageFadeOut('forgot-password-modal-error',data.message);
                        }
                   },
                  error: function (e,x,t) {
                    $(".loader").removeClass('show-loader'); 
                    ajax_error(e);
                  }
               });
          },10);
        e.preventDefault();
        }  
    }); 

    $('#forgotCancel').on('click', function () { 
      $('.input-alert').text('');
      $('input').removeClass('incorrect-alert');
      $("#ForgetPasswordFrm input[name='email']").val('');
    }); 

    $('#change_password_form').submit(function(e){  
           $('.input-alert').text('');
           $('input').removeClass('incorrect-alert');
           if($.trim($('#old_password').val())==''){
               $('#old_password').addClass('incorrect-alert');
               $('#oldpasswordError').text(errorSuccessMessage['BLANKCUPASS']);
               $('#old_password').focus();
               return false;
           }
           if($.trim($('#new_password').val())==''){
               $('#new_password').addClass('incorrect-alert');
               $('#passwordError').text(errorSuccessMessage['BLANKNPASS']);
               $('#new_password').focus();
               return false;
           }
           if (!passwordPattern.test($.trim($('#new_password').val()))) {
              $('#new_password').addClass('incorrect-alert');
              $('#passwordError').text(errorSuccessMessage['PASSERRMSG']);
              $('#new_password').focus();
              return false;
           }
           if(($('#old_password').val()) == ($('#new_password').val())){
               $('#new_password').addClass('incorrect-alert');
               $('#passwordError').text(errorSuccessMessage['CPASSNPASSMISSMATCH']);
               $('#new_password').focus();
               return false;
           }
           if($.trim($('#confirm_password').val())==''){
               $('#confirm_password').addClass('incorrect-alert');
               $('#confirmpasswordError').text(errorSuccessMessage['BLANKCFPASS']);
               $('#confirm_password').focus();
               return false;
           }
           if(($('#confirm_password').val()) != ($('#new_password').val())){
               $('#confirm_password').addClass('incorrect-alert');
               $('#confirmpasswordError').text(errorSuccessMessage['PASSMISSMATCH']);
               $('#confirm_password').focus();
               return false;
           }
       });

    $('#reset_password_form').submit(function(e){              
           $('.input-alert').text('');
           $('input').removeClass('incorrect-alert');
           
           if($.trim($('#new_password').val())==''){
               $('#new_password').addClass('incorrect-alert');
               $('#passwordError').text(errorSuccessMessage['BLANKNPASS']);
               $('#new_password').focus();
               return false;
           }
           if (!passwordPattern.test($.trim($('#new_password').val()))) {
              $('#new_password').addClass('incorrect-alert');
              $('#passwordError').text(errorSuccessMessage['PASSERRMSG']);
              $('#new_password').focus();
              return false;
           }
           if($.trim($('#confirm_password').val())==''){
               $('#confirm_password').addClass('incorrect-alert');
               $('#confirmpasswordError').text(errorSuccessMessage['BLANKCFPASS']);
               $('#confirm_password').focus();
               return false;
           }
           if(($('#confirm_password').val()) != ($('#new_password').val())){
               $('#confirm_password').addClass('incorrect-alert');
               $('#confirmpasswordError').text(errorSuccessMessage['PASSMISSMATCH']);
               $('#confirm_password').focus();
               return false;
           }
       });

    $(document).on('submit', '#admin_reset_password_form', function (e) {    

        $('.input-alert').text('');        
        $('input').removeClass('incorrect-alert');  
        form = $("form#admin_reset_password_form");  
        err=0; 
           if($.trim($('#new_password').val())==''){
               err = 1;
               $('#new_password').addClass('incorrect-alert');
               $('#passwordError').text(errorSuccessMessage['BLANKNPASS']);
               $('#new_password').focus();
               return false;
           }
           if (!passwordPattern.test($.trim($('#new_password').val()))) {
              err = 1;
              $('#new_password').addClass('incorrect-alert');
              $('#passwordError').text(errorSuccessMessage['PASSERRMSG']);
              $('#new_password').focus();
              return false;
           }
           if($.trim($('#confirm_password').val())==''){
               err = 1;
               $('#confirm_password').addClass('incorrect-alert');
               $('#confirmpasswordError').text(errorSuccessMessage['BLANKCFPASS']);
               $('#confirm_password').focus();
               return false;
           }
           if(($('#confirm_password').val()) != ($('#new_password').val())){
               err = 1;
               $('#confirm_password').addClass('incorrect-alert');
               $('#confirmpasswordError').text(errorSuccessMessage['PASSMISSMATCH']);
               $('#confirm_password').focus();
               return false;
           }         
        if(err==0){ 
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
                   if (data.result) { 
                      $('.admin-reset-pwd').removeClass('error-alert hide');
                      $('.admin-reset-pwd').addClass('success-alert chg-pwd-success-msg');
                      resetForm('admin_reset_password_form');
                      $('.admin-reset-pwd').text(data.message).delay(5000)
                         .fadeOut('slow', function () {
                         $('.admin-reset-pwd').text('');
                         $( ".skip-popup").trigger('click'); 
                      });
                    } else {                                                 
                      messageFadeOut('admin-reset-pwd',data.message);
                    }
               },
               error: function (e,x,t) {
                $(".loader").removeClass('show-loader'); 
                ajax_error(e);
              }
           });
          });
          e.preventDefault();
        }  
    });         
    $(document).on('click', '#set_user_status_btn', function (e) {                         
      form = $("form#set_user_status_form");  
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
              if($('.status_'+$('#user-id').val()).hasClass('block')){
                $('.status_'+$('#user-id').val()).removeClass('block').addClass('unblock');                      
                $('span.status_'+$('#user-id').val()).text('Unblock');
              } else {
                $('.status_'+$('#user-id').val()).removeClass('unblock').addClass('block');                      
                $('span.status_'+$('#user-id').val()).text('Block');
              }
              if (data.status == 'Active') {                      
                $('.users-msg').removeClass('error-alert').addClass('success-alert');  
              } else { 
                $('.users-msg').removeClass('success-alert').addClass('error-alert');
              }
              $('.users-msg').text(data.message);
              messageFadeOut('users-msg',data.message);
            } else {                                                 
              messageFadeOut('users-msg',data.message);
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
