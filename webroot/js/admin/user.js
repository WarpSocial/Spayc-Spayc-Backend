jQuery(document).ready(function ($) {    
    $('input').bind("keypress click", function () {
      if($(this).hasClass('incorrect-alert')){
        $(this).removeClass('incorrect-alert');  
        $(this).parent().parent().find('.input-alert').text('')
      }
    });
    
    if(!$('.error-alert').hasClass('hide') && ($('.error-alert').text().length > 0)){
      $('.error-alert').delay(5000).fadeOut('slow', function () {
        $('.error-alert').text('');
        $('.error-alert').hide();
      });
    }
    
    $(document).on("click", ".pop", function(){
      var className = $(this).attr('name');
      if (typeof className !== typeof undefined && className !== false) {
        className=$(this).attr('name');
      }else{
        className='';
      }
      openPopup($(this).attr('page'),className);
    });  
    $('.show-password').on('click', function () {                    
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
            $('#emailError').text(errorSuccessMessage['2']);
            return false;
        }
        if (!pattern.test($.trim($('#email').val()))) {
            $('#email').addClass('incorrect-alert');
            $('#emailError').text(errorSuccessMessage['3']);
            return false;
        }
        if ($.trim($('#password').val()) == '') {
            $('#password').addClass('incorrect-alert');
            $('#passwordError').text(errorSuccessMessage['4']);
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
            $('#ForgetPasswordFrm #emailError').text(errorSuccessMessage['2']);
            return false;
        }
        if (!pattern.test($.trim(email.val()))) {           
            err = 1;
            email.addClass('incorrect-alert');
            $('#ForgetPasswordFrm #emailError').text(errorSuccessMessage['3']);
            return false;
        }          
        if(err==0){           
        $.ajax({
               type:'POST',
               url:UserUrls.ForgotPassword,
               data: {email: email.val()},
               dataType:'JSON',
               async: true,             
              beforeSend: function () {
                $(".loader").addClass('show-loader');
              },
               success:function(data){        
                  $(".loader").removeClass('show-loader');        
                   if (data.result) {     
                        $( "#forgotCancel").trigger('click'); 
                        openPopup(UserUrls.Success);                   
                    } else { 
                      $('.error-forgot-password-page').text(data.message);
                      $('.error-forgot-password-page').removeClass('hide');
                    }
               },
               error: function (e,x,t) {
              $(".loader").hide();
              ajax_error(e);
            }
           });
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
               $('#oldpasswordError').text(errorSuccessMessage['5']);
               $('#old_password').focus();
               return false;
           }
           if($.trim($('#new_password').val())==''){
               $('#new_password').addClass('incorrect-alert');
               $('#passwordError').text(errorSuccessMessage['8']);
               $('#new_password').focus();
               return false;
           }
           if (!passwordPattern.test($.trim($('#new_password').val()))) {
              $('#new_password').addClass('incorrect-alert');
              $('#passwordError').text(errorSuccessMessage['15']);
              $('#new_password').focus();
              return false;
           }
           if(($('#old_password').val()) == ($('#new_password').val())){
               $('#new_password').addClass('incorrect-alert');
               $('#passwordError').text(errorSuccessMessage['6']);
               $('#new_password').focus();
               return false;
           }
           if($.trim($('#confirm_password').val())==''){
               $('#confirm_password').addClass('incorrect-alert');
               $('#confirmpasswordError').text(errorSuccessMessage['9']);
               $('#confirm_password').focus();
               return false;
           }
           if(($('#confirm_password').val()) != ($('#new_password').val())){
               $('#confirm_password').addClass('incorrect-alert');
               $('#confirmpasswordError').text(errorSuccessMessage['7']);
               $('#confirm_password').focus();
               return false;
           }
       });

    $('#reset_password_form').submit(function(e){              
           $('.input-alert').text('');
           $('input').removeClass('incorrect-alert');
           
           if($.trim($('#new_password').val())==''){
               $('#new_password').addClass('incorrect-alert');
               $('#passwordError').text(errorSuccessMessage['8']);
               $('#new_password').focus();
               return false;
           }
           if (!passwordPattern.test($.trim($('#new_password').val()))) {
              $('#new_password').addClass('incorrect-alert');
              $('#passwordError').text(errorSuccessMessage['15']);
              $('#new_password').focus();
              return false;
           }
           if($.trim($('#confirm_password').val())==''){
               $('#confirm_password').addClass('incorrect-alert');
               $('#confirmpasswordError').text(errorSuccessMessage['9']);
               $('#confirm_password').focus();
               return false;
           }
           if(($('#confirm_password').val()) != ($('#new_password').val())){
               $('#confirm_password').addClass('incorrect-alert');
               $('#confirmpasswordError').text(errorSuccessMessage['7']);
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
               $('#passwordError').text(errorSuccessMessage['8']);
               $('#new_password').focus();
               return false;
           }
           if (!passwordPattern.test($.trim($('#new_password').val()))) {
              err = 1;
              $('#new_password').addClass('incorrect-alert');
              $('#passwordError').text(errorSuccessMessage['15']);
              $('#new_password').focus();
              return false;
           }
           if($.trim($('#confirm_password').val())==''){
               err = 1;
               $('#confirm_password').addClass('incorrect-alert');
               $('#confirmpasswordError').text(errorSuccessMessage['9']);
               $('#confirm_password').focus();
               return false;
           }
           if(($('#confirm_password').val()) != ($('#new_password').val())){
               err = 1;
               $('#confirm_password').addClass('incorrect-alert');
               $('#confirmpasswordError').text(errorSuccessMessage['7']);
               $('#confirm_password').focus();
               return false;
           }         
        if(err==0){           
        $.ajax({
               type:'POST',
               url:form.prop('action'),
               data: form.serialize(),
               dataType:'JSON',
               async: true,             
              beforeSend: function () {
                $(".loader").addClass('show-loader');
              },
               success:function(data){        
                  $(".loader").removeClass('show-loader');        
                   if (data.result) {     
                        $( ".skip-popup").trigger('click'); 
                    } else { 
                      $('.error-forgot-password-page').text(data.message);
                      $('.error-forgot-password-page').removeClass('hide');
                    }
               },
               error: function (e,x,t) {
              $(".loader").hide();
              ajax_error(e);
            }
           });
          e.preventDefault();
        }  
    }); 

});