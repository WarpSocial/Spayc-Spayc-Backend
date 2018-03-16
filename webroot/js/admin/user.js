jQuery(document).ready(function ($) {
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
    //var err=0;
    $('#adminLogin').submit(function () {        
        $('.input-alert').text('');
        $('input').removeClass('incorrect-alert');

        if ($.trim($('#email').val()) == '') {            
            $('#email').addClass('incorrect-alert');
            $('#emailError').text('Please enter your email.');
            return false;
        }
        if (!pattern.test($.trim($('#email').val()))) {
            $('#email').addClass('incorrect-alert');
            $('#emailError').text('Please enter your valid email.');
            return false;
        }
        if ($.trim($('#password').val()) == '') {
            $('#password').addClass('incorrect-alert');
            $('#passwordError').text('Please enter your password.');
            return false;
        }
    });
    
    $('#ForgetPassword').submit(function(){
        var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
        var re = pattern.test($.trim($('#email').val()));
        $('#emailError').text('');
        if(!re){
            $('#emailError').text('Please enter your email.');
            return false;
        }
    });

    $('#forget_password_btn').on('click', function () {         
        $('.input-alert').text('');
        $('input').removeClass('incorrect-alert');
        var email = $("#ForgetPasswordFrm input[name='email']");
        $('input').removeClass('incorrect-alert');
        if ($.trim(email.val()) == '') { 
            err = 1;           
            email.addClass('incorrect-alert');
            $('#ForgetPasswordFrm #emailError').text('Please enter your email.');
            return false;
        }
        if (!pattern.test($.trim($('#ForgetPasswordFrm #email').val()))) {
            err = 1;
            email.addClass('incorrect-alert');
            $('#ForgetPasswordFrm #emailError').text('Please enter your valid email.');
            return false;
        }
        if(err==0){
        $.ajax({
               type:'POST',
               url:$("#ForgetPasswordFrm").prop('action'),
               data: {email: email.val()},
               dataType:'JSON',
               async: false,
               success:function(data){                
                   if (data.result) {     
                        //location.reload();                        
                        $('#forgotPassword').modal('toggle');
                        $('#success').modal('toggle');
                    } else {                        
                        //$("form#ForgetPasswordFrm").reset();
                        $('#ForgetPasswordFrm #email').addClass('incorrect-alert');
                        $('#ForgetPasswordFrm #emailError').text(data.message);

                    }
               }
           });
        }
           
           
    }); 

    $('#change_password_form').submit(function(e){        
           $('.input-alert').text('');
           $('input').removeClass('incorrect-alert');
           if($.trim($('#old_password').val())==''){
               $('#old_password').addClass('incorrect-alert');
               $('#oldpasswordError').text('Please enter current password.');
               $('#old_password').focus();
               return false;
           }
           if($.trim($('#new_password').val())==''){
               $('#new_password').addClass('incorrect-alert');
               $('#passwordError').text('Please enter new password.');
               $('#new_password').focus();
               return false;
           }
           // if($.trim($('#new_password').val()).length < 6){
           //     $('#passwordError').text('Your password must be at least 6 characters.');
           //     $('#new_password').focus();
           //     return false;
           // }
           if(($('#old_password').val()) == ($('#new_password').val())){
               $('#new_password').addClass('incorrect-alert');
               $('#passwordError').text('Current password & new password cannot be same.');
               $('#new_password').focus();
               return false;
           }
           if($.trim($('#confirm_password').val())==''){
               $('#confirm_password').addClass('incorrect-alert');
               $('#confirmpasswordError').text('Please enter confirm password.');
               $('#confirm_password').focus();
               return false;
           }
           if(($('#confirm_password').val()) != ($('#new_password').val())){
               $('#confirm_password').addClass('incorrect-alert');
               $('#confirmpasswordError').text('The passwords entered do not match.');
               $('#confirm_password').focus();
               return false;
           }
       });

});