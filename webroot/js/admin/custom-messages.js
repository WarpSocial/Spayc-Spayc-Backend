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
                $(".loader").removeClass('show-loader');
                $(".skip-popup").trigger('click');
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


    $(".img-icon").click(function () {
        $(".contact-list-box").toggle();
        $(".select2-search__field").trigger('click');

    })

});


function getUsers(id, msg_id) {
    $(".loader").addClass('show-loader');
    $.ajax({
        type: 'POST',
        url: UserUrls.resendMessageUsers,
        data: {id: id},
        dataType: 'JSON',
        async: true,
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
        "placeholder": "Pick options",
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
                updateSelect();
            })
            .on("select2:unselect", function (e) {
                updateSelect();
            })
            .on("select2:change", function (e) {
                updateSelect();
            });


    $(document).on('click', '.close-keyword', function () {
        $("#options option[value='" + $(this).parent("span").prop('id') + "']").remove();
        updateSelect();
    })
    $(".check-all").click(function () {
        updateCheck()
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
function updateCheck() {
    $(".keywords").html('');
    $("#options").val('');
    $.each(options_arr, function (key, item) {
        $("#options").select2("trigger", "select", {
            data: {id: item.id, text: item.text, email: item.email}
        });
    })
}
function template(data) {
    options_arr.push(data);
    var array = $("#options").val();
    if (jQuery.inArray(data.id, array) !== -1) {
        var checked = "<input class='list-checkbox' type='checkbox' id='chk_" + data.id + "' checked='checked'>";
    } else {
        var checked = "<input class='list-checkbox' type='checkbox' id='chk_" + data.id + "'>";
    }

    return "<div class='user-list'>\
                    " + checked + "\
                <div class='user-image'><span><img src ='" + data.image_url + "' class='image-responsive'></span></div>\
                <div class='user-list-info'>\
                <span class='user-name ell'>" + data.text + "</span><br>\
                <span class='user-id ell'>" + data.email + "</span>\
                </div></div>";
}
