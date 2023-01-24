$(function () {
    tableRiwayat = $('#tableRiwayat').DataTable({
        bProcessing: true,
        bServerSide: true,
        columnDefs: [{
            "orderable": false,
            "targets": 6
        }],
        lengthMenu: [[10, 25, 50, 100, 250], [10, 25, 50, 100, 250]],
        columns: [
            {
                "data": "tgl_kunjungan",
                render: function (data, type, row) {
                    return tgl_id_short(data);
                },
                className: 'text-center'
            },
            { "data": "kode" },
            { "data": "pasien.no_rm" },
            { "data": "pasien.nama_pasien" },
            { "data": "pegawai.nama" },
            { "data": "keluhan" },
            { "data": "btn" },
        ],
        order: [
            [0, "desc"],
            [1, "desc"],
        ],
        ajax: {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                if (tableRiwayat.hasOwnProperty('settings')) {
                    tableRiwayat.settings()[0].jqXHR.abort();
                }
            },
            url: base_url('registrasi/tableRiwayat'),
            method: 'POST',
            data: function (data) {
                data.riwayat_registrasi_id = $('#riwayat_registrasi_id').val();
                data.riwayat_pasien_id = $('#riwayat_pasien_id').val();
            }
        },
        sDom: "<'row'<'col-sm-6 mb-0' l ><'col-sm-6 mb-0 text-end'>> t <'row'<'col-sm-6 mb-0' i><'col-sm-6 mb-0 text-end' p>> ",
        oLanguage: datatableLang
    });


    $('#tableRiwayat tfoot th').each(function () {
        var title = $('#tableRiwayat tfoot th').eq($(this).index()).text();
        if (title !== "ID") {
            $(this).html('<input type="text" class="form-control form-control-sm form-datatable" style="width:100%;border-radius: 0px;" placeholder="Cari ' + title + '" />');
        } else {
            $(this).html('');
        }
    });

    tableRiwayat.columns().every(function () {
        var that = this;
        $('input', this.footer()).on('keyup change', function (ev) {
            //if (ev.keyCode == 13) { //only on enter keypress (code 13)
            that
                .search(this.value)
                .draw();
            //}
        });
    });


    $('#tableRiwayat tbody').on('click', 'button.btn-preview', function () {
        var data = tableRiwayat.row($(this).parents('tr')).data();
        console.log(data);
        getRiwayatPoli(data.id);
        $('.pasien-keluhan').html(data.keluhan);
        $('.riwayat-pasien').hide('fast');
    });
});

function getRiwayatPoli(id){
    $.ajax({
        type: "POST",
        url: base_url('poli-umu/getRiwayatPoli'),
        data: {
            "id": id
            , '_token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (obj) {
            if (obj.metadata.code === 200) {
                var riwayat = obj.response;
                console.log(riwayat);
                $('.pasien-norm').html(riwayat.pasien.no_rm);
                $('.pasien-goldarah').html(riwayat.pasien.gol_darah);
                $('.pasien-kelamin').html(riwayat.pasien.jenis_kelamin);

                if(riwayat.pasien.alergi!==null){
                    $('.pasien-alergi').html(riwayat.pasien.alergi).show();
                }

                if(riwayat.pasien.penyakit!==null){
                    $('.pasien-penyakit').html(riwayat.pasien.penyakit).show();
                }
                
                $('#riwayat_fisik_td_mm').val((riwayat.fisik_td_mm!==null) ? riwayat.fisik_td_mm : '');
                $('#riwayat_fisik_td_hg').val((riwayat.fisik_td_hg!==null) ? riwayat.fisik_td_hg : '');

                $('#riwayat_fisik_nadi').val((riwayat.fisik_nadi!==null) ? riwayat.fisik_nadi : '');
                $('#riwayat_fisik_nafas').val((riwayat.fisik_nafas!==null) ? riwayat.fisik_nafas : '');

                $('#riwayat_fisik_suhu').val((riwayat.fisik_suhu!==null) ? riwayat.fisik_suhu : '');
                $('#riwayat_fisik_tb').val((riwayat.fisik_tb!==null) ? riwayat.fisik_tb : '');
                $('#riwayat_fisik_bb').val((riwayat.fisik_bb!==null) ? riwayat.fisik_bb : '');

                if(riwayat.diag_utama!==null){
                    $('#riwayat_diagnosa_utama').val(riwayat.diag_utama.code_icd + ' - ' + riwayat.diag_utama.title_icd);
                }

                if(riwayat.diag_sekunder_1!==null){
                    $('#riwayat_diagnosa_sekunder_1').val(riwayat.diag_sekunder_1.code_icd + ' - ' + riwayat.diag_sekunder_1.title_icd);
                }

                if(riwayat.diag_sekunder_2!==null){
                    $('#riwayat_diagnosa_sekunder_2').val(riwayat.diag_sekunder_2.code_icd + ' - ' + riwayat.diag_sekunder_2.title_icd);
                }

                if(riwayat.ringkasan!==null){
                    $('#riwayat_ringkasan').val(riwayat.ringkasan);
                }

                if(riwayat.ket_diagnosa_sekunder!==null){
                    $('#riwayat_ket_diagnosa_sekunder').val(riwayat.ket_diagnosa_sekunder);
                }

                getTindakan(riwayat.politindakan);
                getResep(riwayat.poliresep);
                getPenunjang(riwayat.polipenunjang);
                $('.riwayat-pasien').show('fast');
            } else {
                toastbs(obj.metadata.message, 'Kesalahan', 'error');
            }
        },
        error: function (event, textStatus, errorThrown) {
            pharseError(event, errorThrown);
        }
    });
}

function getTindakan(dataArr){
    $('.daftar-tindakan').html('');
    var no = 1;
    if(dataArr.length > 0){
        dataArr.forEach(element => {
            console.log(element);
            $('.daftar-tindakan').append('<tr>' + 
                    '<td>' + no +  '</td>' + 
                    '<td>' + element.nama +  '</td>' + 
                '</tr>');
                no++;
        });
    }
}

function getResep(dataArr){
    $('.daftar-resep').html('');
    var no = 1;
    if(dataArr.length > 0){
        dataArr.forEach(element => {
            console.log(element);
            $('.daftar-resep').append('<tr>' + 
                    '<td>' + no +  '</td>' + 
                    '<td>' + element.nama +  '</td>' + 
                    '<td>' + numeral(element.qty).format('0,0') +  '</td>' + 
                '</tr>');
                no++;
        });
    }
}

function getPenunjang(dataArr){
    $('.daftar-penunjang').html('');
    var no = 1;
    if(dataArr.length > 0){
        dataArr.forEach(element => {
            console.log(element);
            $('.daftar-penunjang').append('<tr>' + 
                    '<td>' + no +  '</td>' + 
                    '<td><a href="' + base_url('assesment/attachdata/?id=' + element.id + '&registrasi_id=' + element.registrasi_id) + '" target="blank"><img src="' + base_url('/files/penunjang/' + element.nama_file) +'" class="img img-round" style="max-height: 100px;" alt="' + element.nama_file + '"/></a></td>' + 
                '</tr>');
                no++;
        });
    }
}