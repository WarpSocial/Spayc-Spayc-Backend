var err=0,msg='',form='',errElement='div',ajaxErr=0;;
function openPopup(page,className){
  //$('.modal').modal('close');  
  if($('#cmnPoupUp').hasClass('show')){
    $("#cmnPoupUp").modal('hide');
  }
  setTimeout(function(){
    $("#cmnPoupUp").addClass(className);
    $("#cmnPoupUp .modal-content").html('');
    $("#cmnPoupUp .modal-content").load(page);
    $("#cmnPoupUp").modal({show: true});
  },500);
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


