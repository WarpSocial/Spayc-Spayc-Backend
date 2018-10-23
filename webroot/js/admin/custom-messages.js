jQuery(document).ready(function ($) {

    $(".send-custom-message").click(function (e) {
        e.preventDefault();
        $(".send-custom-message").attr("disabled", "disabled");
        $(".send-custom-message").text("Please Wait...");
        form = $("form#custom_messages_form");
        $(".loader").addClass('show-loader');
        $.ajax({
            type: 'POST',
            url: form.prop('action'),
            data: form.serialize(),
            dataType: 'JSON',
            success: function (data) {
                $(".skip-popup").trigger('click');
                $(".loader").removeClass('show-loader');                
                if (data.result) {
                    messageFadeOut('users-msg', data.message);
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
                } else {
                    messageFadeOut('users-msg', data.message);
                }
            },
            error: function (e, x, t) {
                $(".loader").removeClass('show-loader');
                ajax_error(e);
            }
        });
        e.preventDefault();
    });


    
    $(".img-icon").click(function (event) {
        $(".loader").addClass('show-loader');
          event.stopPropagation();
//        $(".contact-list-box").toggle("fast");
        
        $('.contact-list-box').show(); 
        
        
        setTimeout(function(){
        $(".select2-search__field").trigger('click');
        $(".loader").removeClass('show-loader');
        },200);
        

    })
    
    $(".showup").on("click", function (event) {
        event.stopPropagation();
    });
    $(document).on('click', '.select2-container', function (event) {
         $("body").css("overflow","hidden");
        event.stopPropagation();
    });
    $(document).on('click', '.select2-search__field', function (event) {
        event.stopPropagation();
    });
    
    $(document).on("click", function () {
        $(".showup").hide();
    });

});

function getUsers(id, msg_id) {
    $(".loader").addClass('show-loader');
    $.ajax({
        type: 'POST',
        url: UserUrls.resendMessageUsers,
        data: {id: id},
        dataType: 'JSON',        
        success: function (data) {
            if (data.results) {
                setTimeout(function () {
                    var results = data.results;
                    $.each(results, function (key, item) {
                        $("#options").select2("trigger", "select", {
                            data: {id: item.id, text: item.text, email: item.email}
                        });
                    })
                    $(".message-text").val($("#msg_" + msg_id).text());

                    $(".loader").removeClass('show-loader');
                }, 1000);
            } else {
                messageFadeOut('users-msg', data.message);

                $(".loader").removeClass('show-loader');
            }

        }
    });
}



var options_arr = [];
$(function () {
    $('#options').select2({
        "placeholder": "Search",
        "multiple": true,
        closeOnSelect: false,
        ajax: {
            type: 'POST',
            url: UserUrls.searchUser,
            dataType: 'json',
            delay: 250,
            data: function (term) {
                options_arr = [];
                return {
                    q: term
                };
            }
        },
        templateResult: template,
        escapeMarkup: function (m) {

            return m;
        }
    })
            .on("select2:select", function (e) {
                e.preventDefault();
                updateSelect();
            })
            .on("select2:unselect", function (e) {
                e.preventDefault();
                updateSelect();
            })
            .on("select2:change", function (e) {
                e.preventDefault();
                updateSelect();
            });


    $(document).on('click', '.close-keyword', function () {
        $("#options option[value='" + $(this).parent("span").prop('id') + "']").remove();
        updateSelect();
    })
    $(".check-all").click(function () {
        if( $(this).is(':checked') ){ 
        $(".loader").addClass('show-loader');
        setTimeout(function(){
        updateCheck(1);
        },200);
    }else{
        updateCheck(0);
    }
    })


});


function updateSelect() {
    var array = $("#options").val();
    var data = $("#options").select2("data");
    $(".keywords").html('');
    $(".list-checkbox").prop("checked", false);
    $.each(array, function (i) {
        $(".keywords").append('<span id="' + array[i] + '" >' + data[i].text + ' <i class="close-keyword"></i></span>');
        $("#chk_" + array[i]).prop("checked", true);
    });
}
function updateCheck(check) {
    $(".keywords").html('');
    $("#options").val('');
    if(check){
    $.each(options_arr, function (key, item) {
        $("#options").select2("trigger", "select", {
            data: {id: item.id, text: item.text, email: item.email}
        });
    })
    }
    $(".select2-search__field").trigger('click');
    $(".select2-search__field").trigger('click');
    $(".loader").removeClass('show-loader');
}
function template(data) {
    options_arr.push(data);
    var array = $("#options").val();
    if (jQuery.inArray(data.id, array) !== -1) {
        var checked = "<input class='list-checkbox' type='checkbox' id='chk_" + data.id + "' checked='checked'>";
    } else {
        var checked = "<input class='list-checkbox' type='checkbox' id='chk_" + data.id + "'>";
    }
      setTimeout(function(){
         $( ".select2-results" ).prepend( $( ".check-all-div" ) );
        },100);
        if(!data.image_url){
            data.image_url=$("#default_img").attr('src');
        }
    return "<div class='user-list'>\
                    " + checked + "\
                <div class='user-image'><span><img src ='" + data.image_url + "' class='image-responsive'></span></div>\
                <div class='user-list-info'>\
                <span class='user-name ell'>" + data.text + "</span><br>\
                <span class='user-id ell'>" + data.email + "</span>\
                </div></div>";
}
