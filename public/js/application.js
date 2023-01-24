tableMain = '';

datatableLang = {
    "sLengthMenu": "_MENU_",
    "sZeroRecords": "Tidak ada data",
    "sProcessing": "Silahkan Tunggu",
    "sInfo": "_START_ - _END_ / _TOTAL_",
    "sInfoFiltered": "",
    "sInfoEmpty": "0 - 0 / 0",
    "infoFiltered": "(_MAX_)",
};

$('#form-modal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var title = button.data('title');
    var action_url = button.data('action-url');
    var post_id = button.data('post-id');
    var width = button.data('width');
    if (width) {
        $(".modal-dialog").css("min-width", width);
    } else {
        $(".modal-dialog").css("min-width", "");
    }
    if (action_url !== undefined) {
        $.ajax({
            type: "GET",
            url: base_url(action_url),
            data: { "id": post_id },
            beforeSend: function () {
                $("#form-modal-content").html('');
            },
            success: function (resp) {
                $("#form-modal-content").html(resp);
                set_controls();
            },
            error: function (event, textStatus, errorThrown) {
                pharseError(event, errorThrown);
            }
        });
        var modal = $(this);
        modal.find('.modal-title').text(title);
    }
});

$('#form-modal').on('hidden.bs.modal', function () {
    $(".modal-dialog").css("min-width", "");
    $("#form-modal-content").html("");
});

var bulan = ["Nama Bulan", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
var bulan_short = ["Nama Bulan", "Jan", "Feb", "Mar", "Apr", "Mei", "Juni", "Juli", "Agt", "Sept", "Okt", "Nov", "Des"];

function dateconvert(param) {
    var yyyy = param.substring(0, 4);
    var mm = param.substring(5, 7);
    var dd = param.substring(8, 10);
    return dd + "-" + (mm) + "-" + yyyy;
}

function bln_id_short(param) {
    var yyyy = param.substring(0, 4);
    var mm = param.substring(5, 7);
    return bulan_short[Number(mm)] + " " + yyyy;
}

function tgl_id_short(param) {
    var yyyy = param.substring(0, 4);
    var mm = param.substring(5, 7);
    var dd = param.substring(8, 10);
    var jam = param.substring(10, 20);
    return dd + " " + bulan_short[Number(mm)] + " " + yyyy + " " + jam;
}

function tgl_id_long(param) {
    var yyyy = param.substring(0, 4);
    var mm = param.substring(5, 7);
    var dd = param.substring(8, 10);
    return dd + " " + bulan[Number(mm)] + " " + yyyy;
}

function pharseError(event, errorThrown) {
    var message = event.responseText;
    if (isJson(message)) {
        message = JSON.parse(event.responseText);
        message = message.message;
    }else if(message==undefined){
        message = event.statusText;
    }
    
    toastbs(message, errorThrown, 'error');
}

function toastbs(message, title, typemessage) {
    if (!typemessage) {
        typemessage = "info";
    }
    if (!title) {
        title = "Informasi";
    }
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "1000",
        "hideDuration": "1000",
        "timeOut": "2000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
    toastr[typemessage](message, title);
}

set_controls();

function set_controls() {
    $("input:text").focus(function () {
        $(this).select();
    });

    $("input").focus(function () {
        $(this).select();
    });

    $("textarea").focus(function () {
        $(this).select();
    });


    $('.date-mask').inputmask('99-99-9999', { placeholder: 'dd-mm-yyyy' });
    $('.time-mask').inputmask('99:99', { placeholder: 'hh-mm' });

    $('.year').datepicker({
        startView: "year",
        minViewMode: "years",
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: false,
        autoclose: true,
        format: "yyyy"
    });

    $('.calendar').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: false,
        autoclose: true,
        format: "dd-mm-yyyy"
    });

    $('.month').datepicker({
        startView: "year",
        minViewMode: "months",
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: false,
        autoclose: true,
        format: "mm-yyyy"
    });

    $(".qty").blur(function (e) {
        var v = $(this).val();
        var n = numeral(v).format('0,0');
        $(this).val(n);
    });

    $(".qty").focus(function (e) {
        var v = $(this).val();
        var n = numeral(v).value();
        $(this).val(n);
        $(this).select();
    });

    $(".money").blur(function (e) {
        var v = $(this).val();
        var n = numeral(v).format('0,0.00');
        $(this).val(n);
    });

    $(".money").focus(function (e) {
        var v = $(this).val();
        var n = numeral(v).value();
        $(this).val(n);
        $(this).select();
    });

    $(".percent").blur(function (e) {
        var v = $(this).val();
        var n = numeral(v).format('0,0.00');
        $(this).val(n);
    });

    $(".percent").focus(function (e) {
        var v = $(this).val();
        var n = numeral(v).value();
        $(this).val(n);
    });

    $("input:text").attr('autocomplete', 'off');
    $(".form-control").attr("autocomplete", 'off');
}

function disabled() {
    $(".form-control").attr("disabled", true);
    $(".btn").attr("disabled", true);
    // $(".page-loader-wrapper").css({'display':''});
}

function enabled() {
    $(".form-control").attr("disabled", false);
    $(".btn").attr("disabled", false);
    // $(".page-loader-wrapper").css({'display':'none'});
}

function getMoney() {
    $('.money').each(function (obj) {
        $(this).val(numeral($(this).val()).value());
    });
    $('.qty').each(function (obj) {
        $(this).val(numeral($(this).val()).value());
    });
}

function setMoney() {
    $('.money').each(function (obj) {
        $(this).val(numeral($(this).val()).format('0,0'));
    });
    $('.qty').each(function (obj) {
        $(this).val(numeral($(this).val()).value());
    });
}

function isJson(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}

function printElement(element) {
    var mywindow = window.open('', 'PRINT', 'height=400,width=600');

    mywindow.document.write('<html><head><title>' + document.title + '</title>');
    mywindow.document.write('</head><body >');
    mywindow.document.write(document.getElementById(element).innerHTML);
    mywindow.document.write('</body></html>');

    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/

    mywindow.print();
    mywindow.close();

    return true;
}

function formatResultPasien(data) {
    if (data.loading) {
        return data.text;
    }
    var container = $(
        "<div class='clearfix'>" +
        "<div>" + data.text + "</div>" +
        "<div>Tgl Lahir : " + tgl_id_long(data.tgl_lahir) + ", Usia : " + (data.usia) + "</div>" +
        "<div>Alamat : " + data.alamat + "</div>" +
        "</div>"
    );
    return container;
}

function formatResultPoli(data) {
    if (data.loading) {
        return data.text;
    }
    var container = $(
        "<div class='clearfix'>" +
        "<div>" + data.text + "</div>" +
        "<div>Poli : " + data.nama_poli + "</div>" +
        "</div>"
    );
    return container;
}


function formatResultIcd(data) {
    if (data.loading) {
        return data.text;
    }
    var container = $(
        "<div class='clearfix'>" +
        "<div>" + data.text + "</div>" +
        "<div>" + data.title_icd + "</div>" +
        "</div>"
    );
    return container;
}

function formatResult(data) {
    if (data.loading) {
        return data.text;
    }
    var container = $(
        "<div class='clearfix'>" +
        "<div><strong>" + data.text + "<strong></div>" +
        "</div>"
    );
    return container;
}

function formatSelection(data) {
    return data.text;
}

function popupwindow(url, title, w, h) {
    var left = (screen.width/2)-(w/2);
    var top = (screen.height/2)-(h/2);
    return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
  } 