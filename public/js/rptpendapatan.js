$(function () {
    $(".btn-preview").click(function () {
        previewData();
    });

    $(".btn-print").click(function () {
        
    });

    $('#tgl_mulai').on("selectDate", function (e) {
        $(".btn-preview").click();
    });

    $('#tgl_selesai').on("selectDate", function (e) {
        $(".btn-preview").click();
    });
});

function previewData(){
    var tgl_mulai = $('#tgl_mulai').val();
    var tgl_selesai = $('#tgl_selesai').val();
    $.ajax({
        type: "GET",
        url: base_url('pendapatan/previewData'),
        data: {
            "tgl_mulai": tgl_mulai
            , "tgl_selesai": tgl_selesai
        },
        success: function (obj) {
            $('.preview-data').html(obj);
        },
        error: function (event, textStatus, errorThrown) {
            pharseError(event, errorThrown);
        }
    });
}