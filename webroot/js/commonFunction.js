var err=0,msg='',form='',errElement='div',ajaxErr=0;;
function openPopup(page,className){
  //$('.modal').modal('close');  
  if($('#cmnPoupUp').hasClass('show')){
    $("#cmnPoupUp").modal('hide');
  }
  
    $("#cmnPoupUp").removeClass("modal-dialog-lg fade modal-dialog-sm modal-dialog-xs");
    $("#cmnPoupUp").addClass(className);
    $("#cmnPoupUp .modal-content").html('');
    $("#cmnPoupUp .modal-content").load(page,function(){
        $("#cmnPoupUp").modal({show:true});
    });
    
  
}
$(document).on('hidden.bs.modal','#cmnPoupUp', function () {
    //$("#cmnPoupUp").modal('hide');
  $(this).data('bs.modal', null);
});
var messageFadeOut = function (containerClass, message) {    
    if($('.' + containerClass).hasClass('hide')){
      $('.' + containerClass).removeClass('hide');
    } 
    if($('.'+containerClass).css('display') === 'none') {
      $('.'+containerClass).show();
    }
    $('.' + containerClass).text(message).delay(5000)
    .fadeOut('slow', function () {
        $('.' + containerClass).text('');
    });
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
    $(".loader").removeClass('show-loader');
    checkConnection(e);
    if (e.status == 403) {
       window.location.replace(base_url_admin);
    } else {
        console.log("Something went wrong.");
    }
}

function checkConnection() {
        var xhr = new XMLHttpRequest();
        var file = base_url+"images/logo.png";
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


