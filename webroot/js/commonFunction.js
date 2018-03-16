var emailRex = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
var err=0,msg='',form='',errElement='div',ajaxErr=0;;
var phnMask='000-000-0000';
function openPopup(page,className){
  $('.modal').modal('close');
  $("#cmnPoupUp").removeClass('refer-popup');
  setTimeout(function(){
    $("#cmnPoupUp").addClass(className);
    $("#cmnPoupUp .modal-content").html('');
    $("#cmnPoupUp .modal-content").load(page);
    $("#cmnPoupUp").modal("open");
  },500);
}
function validateRequiredField() {
    var flag = false;
    i = 0;
    form.find("input.required,select.required, textarea.required").each(function () {
        if ($.trim($(this).val()) == "") {
            if ($(this).attr("error")) {
                msg = $(this).attr("error");
            } else {
                msg = "This is required field!";
            }

            error(this);
            flag = true;
            if (i == 0) {
                first_element = $(this);
            }
            i++;
        }
    });
    if (flag) {
        $(first_element).focus();
    }
}

function validateEmail(fieldName) {
    var emailInput = $("input[name='" + fieldName + "']");
    if (emailInput.val() != '') {
        if (emailRex.test($.trim(emailInput.val()))) {
            // valid email
        } else {
            msg = 'Invalid email address!';
            error(emailInput);
        }
    }
}
function validateAlphabetonly(fieldName) {
    var nameInput = $("input[name='" + fieldName + "']");
    var alphabetonly = /^[a-zA-Z\s]+$/;
    if (!alphabetonly.test($.trim(nameInput.val()))) {
        msg = 'Please enter alphabets only!';
        error(nameInput);
    }
}

function validatePhoneNumber(fieldName) {
    var numberInput = $("input[name='" + fieldName + "']");
    if (numberInput.val() != '') {
        // invalid length
        if (numberInput.val().length < 12) {
            msg = 'Please enter correct phone number!';
            error(numberInput);
        }
    }
}
function validatePassword(fieldName,type) {
    var passwordInput = $("input[name='" + fieldName + "']");
    var value = passwordInput.val();
    var passwordErr = 0;
    var pattren = /[!@#$%\^&*(){}[\]<>?/|\-]/;
    if (value != '') {
        if (value.length < 6) {
            passwordErr = 1;
        }
        else if (value.length > 50) {
            passwordErr = 1;
        }
        /*else if (value.search(/^[a-zA-Z0-9\s]+$/) == -1 && type !='login') {
            passwordErr = 1;
        }*/
        if(type!='login'){            
            // if (value.search(/\d/) == -1) {
            //    passwordErr = 1;
            // }
            // else if (value.search(/[a-zA-Z]/) == -1) {
            //    passwordErr = 1;
            // }
    //      else if (value.search(/[A-Z]/) == -1) {
    //          passwordErr = 1;
    //      }
    //      else if (!pattren.test(value)) {
    //          passwordErr = 1;
    //      }
        }
        if (passwordErr == 1) {
            msg = "Invalid password!"
            error(passwordInput);
        }
    }
}
function validateConfirmPassword() {
    var password = $("input[name='password']");
    var confirmPwd = $("input[name='confirm_password']");
    if ($.trim(password.val()) != '' && $.trim(confirmPwd.val()) != '') {
        if (password.val() != confirmPwd.val()) {
            msg = 'Password and Confirm Password did not match.';
            error(confirmPwd);
        }
    }
}
function checkEmailExistence(str) {
    var email = $("input[name='email']");
    if ($.trim(email.val()) != '') {
        if (typeof str === "undefined" || str === null)
            str =  UserUrls.CheckEmail;
        else
            str = UserUrls.CheckEmailWaitlist;

        $.ajax({
            url: str,
            type: 'POST',
            data: {email: email.val()},
            async: false,
            beforeSend: function () {

            },
            success: function (data, status, xhr) {
                if ($.trim(data) == '0') {
                    msg = "Email already exist!";
                    error(email);
                }
            },
            error: function (e, x, t) {
                ajax_error(e);
            },
            complete: function () {

            }
        });
    }
}

function error(element) {
    err = 1;
    var parent = $(element).closest(errElement);
    parent.addClass("bordered-error");
    var errHtm = '<div class="error-message">' +
            '<span>' + msg + '</span>' +
            '</div>';
    parent.find("div.error-message").remove();
    parent.append(errHtm);
    $(element).bind("keypress click", function () {
        err = 0;
        parent = $(element).closest(errElement);
        parent.removeClass("bordered-error");
        parent.find("div.error-message").remove();
    });
}
function checkConnection() {
        var xhr = new XMLHttpRequest();
        var file = PageUrls.Home+"img/genie-logo.png";
        var r = Math.round(Math.random() * 10000);
        xhr.open('HEAD', file + "?subins=" + r, false);
        try {
            xhr.send();
            if (xhr.status >= 200 && xhr.status < 304) {
                return true;
            } else {
                alert("No internet connection.");
                return false;
            }
        } catch (e) {
            alert("No internet connection.");
            return false;
        }
}
function numbersOnly(e){
    // Allow: backspace, delete, tab, escape, enter and 
    //if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13]) !== -1 ||
      // Allow: Ctrl+A,Ctrl+C,Ctrl+V, Command+A
      ((e.keyCode == 65 || e.keyCode == 86 || e.keyCode == 67) && (e.ctrlKey === true || e.metaKey === true)) ||
      // Allow: home, end, left, right, down, up
      (e.keyCode >= 35 && e.keyCode <= 40)) {
      // let it happen, don't do anything
      return;
    }
    // Ensure that it is a number and stop the keypress
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
      e.preventDefault();
    }
}
function resetForm(formid){
    $('#'+formid).find('input:text, input:password, select, textarea').val('');
    $('#'+formid).find('input:radio, input:checkbox').prop('checked', false);
}
function ajax_error(e){
    $("#loader").hide();
    checkConnection(e);
    if (e.status == 403) {
       //openPopup(UserUrls.Login);
       window.location.replace(BASE_URL_ADMIN);
    } else {
        console.log("Something went wrong.");
    }
}
function validateURL(textval) {
    /*var urlregex = new RegExp(
        "^(http:\/\/www.|https:\/\/www.|ftp:\/\/www.|www.){1}([0-9A-Za-z]+\.)");
    return urlregex.test(textval);*/
    var pattern = /^(http|https)?:\/\/[a-zA-Z0-9-\.]+\.[a-z]{2,4}/;
    return pattern.test(textval);
}

