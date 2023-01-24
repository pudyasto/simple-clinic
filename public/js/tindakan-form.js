$(function () {
    $(".btn-submit").click(function () {
        submit();
    });

    $("#icd9").select2({
        placeholder: 'Masukkan Kode ICD9',
        allowClear: true,
        width: '100%',
        dropdownParent: $('#form-modal'),
        ajax: {
            url: base_url('reference/getIcd9/'),
            type: 'GET',
            dataType: 'json',
            delay: 500,
            data: function (params) {
                var query = {
                    q: params.term,
                    page: params.page || 1,
                    limit: 10
                };
                return query;
            },
            processResults: function (data, params) {
                params.page = params.page || 1;
                return {
                    results: data.results,
                    pagination: {
                        more: (params.page * 10) < data.total_count
                    }
                };
            },
            cache: true
        },
        escapeMarkup: function (markup) {
            return markup;
        }
    });

    if(icd9){
        getIcd9(icd9);
    }
});

function getIcd9(id){
    if (id) {
        var icd9 = $('#icd9');
        $.ajax({
            url: base_url('reference/getIcd9/'),
            type: 'GET',
            dataType: 'json',
            delay: 250,
            data: {
                id: id
            },
            beforeSend: function () {
 
            },
        }).then(function (data) {
 
            // create the option and append to Select2
            $.each(data.results, function (i, val) {
                var option = new Option(val.text, val.id, true, true);
                icd9.append(option).trigger('change');
            });
 
            // manually trigger the `select2:select` event
            icd9.trigger({
                type: 'change.select2',
                params: {
                    data: data
                }
            });
        });
    }
}

function submit() {
    getMoney();
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
            setMoney();
        },
        error: function (event, textStatus, errorThrown) {
            enabled();
            setMoney();
            pharseError(event, errorThrown);
        }
    });
}