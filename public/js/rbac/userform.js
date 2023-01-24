$(function () {
    $(".btn-submit").click(function () {
        submit();
    });

    $('#pegawai_id').on('change', function () {
        var nama = $("#pegawai_id option:selected").text();
        $('#name').val(nama);
    });

    getUserGroup();
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
                $('#form-modal').modal("hide");
                toastbs(obj.metadata.message, 'Berhasil', 'success');
                tableMain.ajax.reload();
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

function getUserGroup() {
    $.ajax({
        type: "POST",
        url: base_url('user/getUserGroup'),
        data: {
            "request": true
            , "_token": $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
            $('#group_id').html("");
        },
        success: function (obj) {
            $.each(obj.response, function (key, value) {
                $('#group_id')
                    .append($("<option></option>")
                        .attr("value", value.id)
                        .text(value.name));
                if (group_id) {
                    $('#group_id').val(group_id);
                }
            });
        },
        error: function (event, textStatus, errorThrown) {
            pharseError(event, errorThrown);
        }
    });
}