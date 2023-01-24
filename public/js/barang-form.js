$(function () {
    $(".btn-submit").click(function () {
        submit();
    });

    $("#barang_jenis_id").select2({
        placeholder: 'Pilih Jenis Barang',
        dropdownParent: $("#form-modal"),
        allowClear: true,
        width: '100%',
        ajax: {
            url: base_url('reference/getBarangJenis/'),
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

    $("#barang_kategori_id").select2({
        placeholder: 'Pilih Kategori Barang',
        dropdownParent: $("#form-modal"),
        allowClear: true,
        width: '100%',
        ajax: {
            url: base_url('reference/getBarangkategori/'),
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

    $("#satuan").select2({
        placeholder: 'Pilih Satuan Barang',
        dropdownParent: $("#form-modal"),
        allowClear: true,
        width: '100%',
        ajax: {
            url: base_url('reference/getBarangSatuan/'),
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

    $('#margin_jual').on('keyup', function(){
        calcHargaJual();
    });
    $('#pembulatan').on('keyup', function(){
        calcHargaJual();
    });
    calcHargaJual();
    setMoney();

    if(barang_jenis_id){
        getBarangJenis(barang_jenis_id)
    }
    if(barang_kategori_id){
        getBarangkategori(barang_kategori_id)
    }
    if(satuan){
        getBarangSatuan(satuan)
    }

});

function getBarangJenis(id){
    if (id) {
        var barang_jenis_id = $('#barang_jenis_id');
        $.ajax({
            url: base_url('reference/getTindakan/'),
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
                barang_jenis_id.append(option).trigger('change');
            });
 
            // manually trigger the `select2:select` event
            barang_jenis_id.trigger({
                type: 'change.select2',
                params: {
                    data: data
                }
            });
        });
    }
}
function getBarangkategori(id){
    if (id) {
        var barang_kategori_id = $('#barang_kategori_id');
        $.ajax({
            url: base_url('reference/getBarangkategori/'),
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
                barang_kategori_id.append(option).trigger('change');
            });
 
            // manually trigger the `select2:select` event
            barang_kategori_id.trigger({
                type: 'change.select2',
                params: {
                    data: data
                }
            });
        });
    }
}
function getBarangSatuan(id){
    if (id) {
        var satuan = $('#satuan');
        $.ajax({
            url: base_url('reference/getBarangSatuan/'),
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
                satuan.append(option).trigger('change');
            });
 
            // manually trigger the `select2:select` event
            satuan.trigger({
                type: 'change.select2',
                params: {
                    data: data
                }
            });
        });
    }
}

function calcHargaJual(){
    var harga_beli = $('#harga_beli').val();
    var margin_jual = $('#margin_jual').val();
    var pembulatan = $('#pembulatan').val();
    var harga_jual = ((numeral(harga_beli).value() * numeral(margin_jual).value()) / 100) + (numeral(harga_beli).value() + numeral(pembulatan).value());
    $('#harga_jual').val(numeral(harga_jual).format('0,0'));
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
            pharseError(event, errorThrown);
        }
    });
}