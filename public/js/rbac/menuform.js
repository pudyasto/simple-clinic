$(function () {
    showMainMenu();
    getMainMenu();

    $("#chk_main_menu").click(function () {
        showMainMenu();
        getMainMenu();
    });

    $(".btn-submit").click(function () {
        submit();
    });
});


function submit() {
    $("#form_add").ajaxForm({
        type: "POST",
        url: $("#form_add").attr('action'),
        data: {
            "request": true
        },
        beforeSend: function (result) {
            disabled();
        },
        success: function (obj) {
            enabled();
            if (obj.metadata.code === 200) {
                toastbs(obj.metadata.message, 'Berhasil', 'success');
                tableMain.ajax.reload();
                $('#form-modal').modal("hide");
            } else {
                toastbs(obj.metadata.message, 'Kesalahan', 'error');
            }
        },
        error: function (event, textStatus, errorThrown) {
            enabled();
            pharseError(event, errorThrown);
        }
    });
}

function getMainMenu() {
    $.ajax({
        type: "POST",
        url: base_url('menu/getMainMenu'),
        data: {
            "request": true
            , "main_id": main_id
            , "_token": $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
            $('#main_id').html("");
        },
        success: function (resp) {
            $.each(resp, function (key, value) {
                $('#main_id')
                    .append($("<option></option>")
                        .attr("value", value.id)
                        .text(value.menu_name));
                if (main_id) {
                    $('#main_id').val(main_id);
                }
            });
        },
        error: function (event, textStatus, errorThrown) {
            pharseError(event, errorThrown);
        }
    });
}

function showMainMenu() {
    if ($("#chk_main_menu").prop("checked") === true) {
        $("#main_id").attr('required', false)
            .attr('disabled', true);
        $(".form-mainmenu").hide();
        $(".form-icon").show();
        $(".header-menu").show();
        if (!link) {
            link = "#";
        }
        $("#link").attr('required', false)
            .val(link);
    } else {
        $("#main_id").attr('required', true)
            .attr('disabled', false);
        $("#main_id").val(main_id);
        $(".form-mainmenu").show();
        $(".form-icon").hide();
        $(".header-menu").hide();
        $('#link').attr('required', true)
            .val(link);
    }
}