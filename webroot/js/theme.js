$(function () {      
    $('input').bind("keypress click", function () {
      if($(this).hasClass('incorrect-alert')){
        $(this).removeClass('incorrect-alert');  
        $(this).parent().parent().find('.input-alert').text('')
      }
    });    
    if(!$('.error-alert').hasClass('hide') && ($('.error-alert').text().length > 0)){
        $('.error-alert').delay(5000).fadeOut('slow', function () {
        $('.error-alert').text('');
      });
    }    
    $(document).on("click", ".pop", function(){
      var className = $(this).attr('rel');
      if (typeof className !== typeof undefined && className !== false) {
        className=$(this).attr('rel');
      }else{
        className='';
      }
      openPopup($(this).attr('page'),className);
    }); 

    //[setect dropdown]========
    // Default dropdown action to show/hide dropdown content
    $('.js-dropp-action').click(function(e) {
      e.preventDefault();
      $(this).toggleClass('js-open');
      $(this).next('.dropp-body').toggleClass('js-open');
    });
    // Using as fake input select dropdown
    $('label').click(function() {
      $(this).siblings().removeClass('js-open');
      $('.dropp-body,.js-dropp-action').removeClass('js-open');
    });
    // get the value of checked input radio and display as dropp title
    $('input[name="gender"]').change(function() {
      var value = $("input[name='gender']:checked").val();
      $(this).parents('.filter-box').find('.js-value').text(value);
    });
    $('input[name="age_filter"]').change(function() {
      var value = $("input[name='age_filter']:checked").next('span').text();
      $(this).parents('.filter-box').find('.js-value').text(value);
    });

    $('body').mouseup(function(e){
        var subject = $(".dropp-body");
        if(!subject.is(e.target)&&subject.has(e.target).length==0){
            $('.js-dropp-action').removeClass('js-open');
            $('.js-dropp-action').next('.dropp-body').removeClass('js-open');
        }

    });

    //[datepicker]========
    $(".datepicker").datepicker({
      autoclose: true,
      todayHighlight: false,
      placeholder:true
    });

    //[multi select dropdown]========
    $('#boot-multiselect-demo').multiselect({
      includeSelectAllOption: true,
      buttonWidth: 250,
      enableFiltering: true
    });
    //[Tooltip]==================
    $(function () {
      $('[data-toggle="tooltip"]').tooltip();
    })
  });
