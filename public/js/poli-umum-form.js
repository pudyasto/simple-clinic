$(function () {
    $("#diagnosa_utama").select2({
        placeholder: 'Pilih Diagnosa Utama',
        allowClear: true,
        width: '100%',
        ajax: {
            url: base_url('reference/getIcd10/'),
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

    $("#diagnosa_sekunder_1").select2({
        placeholder: 'Pilih Diagnosa Sekunder 1',
        allowClear: true,
        width: '100%',
        ajax: {
            url: base_url('reference/getIcd10/'),
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

    $("#diagnosa_sekunder_2").select2({
        placeholder: 'Pilih Diagnosa Sekunder 2',
        allowClear: true,
        width: '100%',
        ajax: {
            url: base_url('reference/getIcd10/'),
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

    $("#tindakan_id").select2({
        placeholder: 'Pilih Tindakan',
        allowClear: true,
        width: '100%',
        ajax: {
            url: base_url('reference/getTindakan/'),
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

    $("#barang_id").select2({
        placeholder: 'Pilih Obat',
        allowClear: true,
        width: '100%',
        ajax: {
            url: base_url('reference/getBarang/'),
            type: 'GET',
            dataType: 'json',
            delay: 500,
            data: function (params) {
                var query = {
                    q: params.term,
                    kategori: 'Obat',
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

    $('#barang_id').on('select2:select', function (e) {
        var barang_id = $('#barang_id').select2('data');
        console.log(barang_id);
        if (barang_id[0]) {
            $('.satuan-barang').html(barang_id[0]['satuan']);
        }
    });

    $('#barang_id').on('select2:clear', function (e) {
        $('.satuan-barang').html('-');
        $('#qty').val('');
    });

    $('#barang_id').on('select2:unselect', function (e) {
        $('.satuan-barang').html('-');
        $('#qty').val('');
    });

    $(".btn-tambah-tindakan").on('click', function () {
        submitTindakan();
    });

    $(".btn-tambah-barang").on('click', function () {
        submitBarang();
    });

    $(".btn-tambah-penunjang").on('click', function () {
        submitPenunjang();
    });

    $(".btn-submit-dokumen").on('click', function () {
        submitData();
    });

    // Tabel Tindakan
    tableTindakan = $('#tableTindakan').DataTable({
        bProcessing: true,
        bServerSide: true,
        paging: false,
        columnDefs: [{
            "orderable": false,
            "targets": 2
        }],
        lengthMenu: [[-1], ['All']],
        columns: [
            { "data": "tindakan.nama" },
            {
                "data": "tarif",
                render: function (data, type, row) {
                    return numeral(data).format('0,0');
                }
            },
            { "data": "btn" },
        ],
        order: [
            [0, "asc"],
        ],
        ajax: {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                if (tableTindakan.hasOwnProperty('settings')) {
                    tableTindakan.settings()[0].jqXHR.abort();
                }
            },
            url: base_url('poli-umu/tableTindakan'),
            method: 'POST',
            data: function (data) {
                data.registrasi_id = $('#registrasi_id').val();
            }
        },
        sDom: "<'row'<'col-sm-6 mb-0' l ><'col-sm-6 mb-0 text-end'>> t <'row'<'col-sm-6 mb-0' i><'col-sm-6 mb-0 text-end' p>> ",
        oLanguage: datatableLang
    });

    $('#tableTindakan tbody').on('click', 'button.btn-edit-tindakan', function () {
        var data = tableTindakan.row($(this).parents('tr')).data();
        getTindakan(data.tindakan.id);
        $('#poli_tindakan_id').val(data.id);
    });

    $('#tableTindakan tbody').on('click', 'button.btn-hapus-tindakan', function () {
        var data = tableTindakan.row($(this).parents('tr')).data();
        deleteDataTindakan(data.id);
    });

    // Tabel Barang
    tableBarang = $('#tableBarang').DataTable({
        bProcessing: true,
        bServerSide: true,
        paging: false,
        columnDefs: [{
            "orderable": false,
            "targets": 2
        }],
        lengthMenu: [[-1], ['All']],
        columns: [
            { "data": "barang.nama" },
            {
                "data": "harga_jual",
                render: function (data, type, row) {
                    return numeral(data).format('0,0');
                }
            },
            { "data": "btn" },
        ],
        order: [
            [0, "asc"],
        ],
        ajax: {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                if (tableBarang.hasOwnProperty('settings')) {
                    tableBarang.settings()[0].jqXHR.abort();
                }
            },
            url: base_url('poli-umu/tableBarang'),
            method: 'POST',
            data: function (data) {
                data.registrasi_id = $('#registrasi_id').val();
            }
        },
        sDom: "<'row'<'col-sm-6 mb-0' l ><'col-sm-6 mb-0 text-end'>> t <'row'<'col-sm-6 mb-0' i><'col-sm-6 mb-0 text-end' p>> ",
        oLanguage: datatableLang
    });

    $('#tableBarang tbody').on('click', 'button.btn-edit-barang', function () {
        var data = tableBarang.row($(this).parents('tr')).data();
        getBarang(data.barang.id);
        $('#poli_resep_id').val(data.id);
        $('#qty').val(data.qty);
    });

    $('#tableBarang tbody').on('click', 'button.btn-hapus-barang', function () {
        var data = tableBarang.row($(this).parents('tr')).data();
        deleteDataBarang(data.id);
    });

    // Tabel Penunjang
    tablePenunjang = $('#tablePenunjang').DataTable({
        bProcessing: true,
        bServerSide: true,
        paging: false,
        columnDefs: [{
            "orderable": false,
            "targets": 1
        }],
        lengthMenu: [[-1], ['All']],
        columns: [
            { "data": "img" },
            { "data": "btn" },
        ],
        order: [
            [0, "asc"],
        ],
        ajax: {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                if (tablePenunjang.hasOwnProperty('settings')) {
                    tablePenunjang.settings()[0].jqXHR.abort();
                }
            },
            url: base_url('poli-umu/tablePenunjang'),
            method: 'POST',
            data: function (data) {
                data.registrasi_id = $('#registrasi_id').val();
            }
        },
        sDom: "<'row'<'col-sm-6 mb-0' l ><'col-sm-6 mb-0 text-end'>> t <'row'<'col-sm-6 mb-0' i><'col-sm-6 mb-0 text-end' p>> ",
        oLanguage: datatableLang
    });

    $('#tablePenunjang tbody').on('click', 'button.btn-hapus-barang', function () {
        var data = tablePenunjang.row($(this).parents('tr')).data();
        deleteDataPenunjang(data.id);
    });

    if(diagnosa_utama){
        getDiagnosaUtama(diagnosa_utama)
    }

    if(diagnosa_sekunder_1){
        getDiagnosaSekunder1(diagnosa_sekunder_1)
    }

    if(diagnosa_sekunder_2){
        getDiagnosaSekunder2(diagnosa_sekunder_2)
    }
});

// getDiagnosaUtama Start
function getDiagnosaUtama(id) {
    if (id) {
        var diagnosa_utama = $('#diagnosa_utama');
        $.ajax({
            url: base_url('reference/getIcd10/'),
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
                diagnosa_utama.append(option).trigger('change');
            });

            // manually trigger the `select2:select` event
            diagnosa_utama.trigger({
                type: 'change.select2',
                params: {
                    data: data
                }
            });
        });
    }
}

// getDiagnosaSekunder1 Start
function getDiagnosaSekunder1(id) {
    if (id) {
        var diagnosa_sekunder_1 = $('#diagnosa_sekunder_1');
        $.ajax({
            url: base_url('reference/getIcd10/'),
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
                diagnosa_sekunder_1.append(option).trigger('change');
            });

            // manually trigger the `select2:select` event
            diagnosa_sekunder_1.trigger({
                type: 'change.select2',
                params: {
                    data: data
                }
            });
        });
    }
}

// getDiagnosaSekunder2 Start
function getDiagnosaSekunder2(id) {
    if (id) {
        var diagnosa_sekunder_2 = $('#diagnosa_sekunder_2');
        $.ajax({
            url: base_url('reference/getIcd10/'),
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
                diagnosa_sekunder_2.append(option).trigger('change');
            });

            // manually trigger the `select2:select` event
            diagnosa_sekunder_2.trigger({
                type: 'change.select2',
                params: {
                    data: data
                }
            });
        });
    }
}
// Tindakan Start
function getTindakan(id) {
    if (id) {
        var tindakan_id = $('#tindakan_id');
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
                tindakan_id.append(option).trigger('change');
            });

            // manually trigger the `select2:select` event
            tindakan_id.trigger({
                type: 'change.select2',
                params: {
                    data: data
                }
            });
        });
    }
}

function submitTindakan() {
    var registrasi_id = $('#registrasi_id').val();
    var poli_tindakan_id = $('#poli_tindakan_id').val();
    var tindakan_id = $('#tindakan_id').val();
    $.ajax({
        type: "POST",
        url: base_url('poli-umu/submitTindakan'),
        data: {
            "registrasi_id": registrasi_id
            , "poli_tindakan_id": poli_tindakan_id
            , "tindakan_id": tindakan_id
            , '_token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (obj) {
            tableTindakan.ajax.reload();
            if (obj.metadata.code === 200) {
                toastbs(obj.metadata.message, 'Berhasil', 'success');
                resetTindakan();
            } else {
                toastbs(obj.metadata.message, 'Kesalahan', 'error');
            }
        },
        error: function (event, textStatus, errorThrown) {
            pharseError(event, errorThrown);
        }
    });
}

function resetTindakan() {
    $('#poli_tindakan_id').val('');
    $("#tindakan_id").val(null).trigger('change');
}

function deleteDataTindakan(id) {
    swal({
        title: "Konfirmasi Hapus",
        text: "Data yang dihapus, tidak dapat dikembalikan!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((result) => {
        if (result) {
            $.ajax({
                type: "POST",
                url: base_url('poli-umu/deleteDataTindakan'),
                data: {
                    "id": id
                    , "stat": "delete"
                    , '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (obj) {
                    tableTindakan.ajax.reload();
                    if (obj.metadata.code === 200) {
                        toastbs(obj.metadata.message, 'Berhasil', 'success');
                    } else {
                        toastbs(obj.metadata.message, 'Kesalahan', 'error');
                    }
                },
                error: function (event, textStatus, errorThrown) {
                    pharseError(event, errorThrown);
                }
            });
        }
    });
}
// Tindakan End


// Barang Start
function getBarang(id) {
    if (id) {
        var barang_id = $('#barang_id');
        $.ajax({
            url: base_url('reference/getBarang/'),
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
                barang_id.append(option).trigger('change');
                $('.satuan-barang').html(val.satuan);
            });

            // manually trigger the `select2:select` event
            barang_id.trigger({
                type: 'change.select2',
                params: {
                    data: data
                }
            });
        });
    }
}

function submitBarang() {
    var registrasi_id = $('#registrasi_id').val();
    var poli_resep_id = $('#poli_resep_id').val();
    var barang_id = $('#barang_id').val();
    var qty = $('#qty').val();
    $.ajax({
        type: "POST",
        url: base_url('poli-umu/submitBarang'),
        data: {
            "registrasi_id": registrasi_id
            , "poli_resep_id": poli_resep_id
            , "barang_id": barang_id
            , "qty": qty
            , '_token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (obj) {
            tableBarang.ajax.reload();
            if (obj.metadata.code === 200) {
                toastbs(obj.metadata.message, 'Berhasil', 'success');
                resetBarang();
            } else {
                toastbs(obj.metadata.message, 'Kesalahan', 'error');
            }
        },
        error: function (event, textStatus, errorThrown) {
            pharseError(event, errorThrown);
        }
    });
}

function resetBarang() {
    $('#qty').val('');
    $('#poli_resep_id').val('');
    $("#barang_id").val(null).trigger('change');
    $('.satuan-barang').html('-');
}

function deleteDataBarang(id) {
    swal({
        title: "Konfirmasi Hapus",
        text: "Data yang dihapus, tidak dapat dikembalikan!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((result) => {
        if (result) {
            $.ajax({
                type: "POST",
                url: base_url('poli-umu/deleteDataBarang'),
                data: {
                    "id": id
                    , "stat": "delete"
                    , '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (obj) {
                    tableBarang.ajax.reload();
                    if (obj.metadata.code === 200) {
                        toastbs(obj.metadata.message, 'Berhasil', 'success');
                    } else {
                        toastbs(obj.metadata.message, 'Kesalahan', 'error');
                    }
                },
                error: function (event, textStatus, errorThrown) {
                    pharseError(event, errorThrown);
                }
            });
        }
    });
}
// Barang End


// Penunjang Start
function submitPenunjang() {
    var registrasi_id = $('#registrasi_id').val();
    var poli_penunjang_id = $('#poli_penunjang_id').val();
    var nama_file = $('#nama_file').val();
    $("#form_assesment").ajaxForm({
        type: "POST",
        url: base_url('poli-umu/submitPenunjang'),
        data: {
            "registrasi_id": registrasi_id
            , "poli_penunjang_id": poli_penunjang_id
            , "nama_file": nama_file
            , '_token': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
            disabled();
        },
        success: function (obj) {
            enabled();
            tablePenunjang.ajax.reload();
            if (obj.metadata.code === 200) {
                toastbs(obj.metadata.message, 'Berhasil', 'success');
                resetPenunjang();
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

function resetPenunjang() {
    $('#nama_file').val('');
    $('#poli_penunjang_id').val('');
}

function deleteDataPenunjang(id) {
    swal({
        title: "Konfirmasi Hapus",
        text: "Data yang dihapus, tidak dapat dikembalikan!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((result) => {
        if (result) {
            $.ajax({
                type: "POST",
                url: base_url('poli-umu/deleteDataPenunjang'),
                data: {
                    "id": id
                    , "stat": "delete"
                    , '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (obj) {
                    tablePenunjang.ajax.reload();
                    if (obj.metadata.code === 200) {
                        toastbs(obj.metadata.message, 'Berhasil', 'success');
                    } else {
                        toastbs(obj.metadata.message, 'Kesalahan', 'error');
                    }
                },
                error: function (event, textStatus, errorThrown) {
                    pharseError(event, errorThrown);
                }
            });
        }
    });
}
// Penunjang End

// Submit Dokumen Start
function submitData() {
    $("#form_assesment").ajaxForm({
        type: "POST",
        url: base_url('poli-umu/submitData'),
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
            disabled();
        },
        success: function (obj) {
            enabled();
            tablePenunjang.ajax.reload();
            if (obj.metadata.code === 200) {
                toastbs(obj.metadata.message, 'Berhasil', 'success');
                resetPenunjang();
                swal({
                    title: "Berhasil",
                    text: obj.metadata.message,
                    icon: "success",
                }).then((result) => {
                    if (result) {
                        location.replace(base_url('poli-umu'));
                    }
                });
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
// Submit Dokumen End