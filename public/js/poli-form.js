$(function () {
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