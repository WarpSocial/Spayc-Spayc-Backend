$(function () {

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
      $('[data-toggle="tooltip"]').tooltip()
    })
  });
