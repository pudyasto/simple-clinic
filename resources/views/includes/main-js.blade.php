<!-- latest jquery-->
<script src="{{ asset('/theme/cuba/assets/js/jquery-3.5.1.min.js') }}"></script>
<!-- Bootstrap js-->
<script src="{{ asset('/theme/cuba/assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
<!-- feather icon js-->
<script src="{{ asset('/theme/cuba/assets/js/icons/feather-icon/feather.min.js') }}"></script>
<script src="{{ asset('/theme/cuba/assets/js/icons/feather-icon/feather-icon.js') }}"></script>
<!-- scrollbar js-->
<script src="{{ asset('/theme/cuba/assets/js/scrollbar/simplebar.js') }}"></script>
<script src="{{ asset('/theme/cuba/assets/js/scrollbar/custom.js') }}"></script>
<!-- Sidebar jquery-->
<script src="{{ asset('/theme/cuba/assets/js/config.js') }}"></script>
<!-- Plugins JS start-->
<script src="{{ asset('/theme/cuba/assets/js/sidebar-menu.js') }}"></script>
<script src="{{ asset('/theme/cuba/assets/js/tooltip-init.js') }}"></script>
<!-- Plugins JS Ends-->
<!-- Theme js-->
<script src="{{ asset('/theme/cuba/assets/js/script.js') }}"></script>
<!-- login js-->
<!-- Plugin used-->
<script src="{{ asset('/theme/cuba/assets/js/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('/theme/cuba/assets/js/sweet-alert/sweetalert.min.js') }}"></script>
<script src="{{ asset('/theme/cuba/assets/js/datepicker/date-picker/datepicker.js') }}"></script>

<script src="{{ asset('/plugins/jquery-form/jquery.form.min.js')}}"></script>
<script src="{{ asset('/plugins/numeraljs/min/numeral.min.js')}}"></script>
<script src="{{ asset('/plugins/numeraljs/min/locales.min.js')}}"></script>
<script src="{{ asset('/plugins/inputmask/jquery.inputmask.min.js')}}"></script>
<script src="{{ asset('/plugins/moment-js/moment-with-locales.js')}}"></script>
<script src="{{ asset('/plugins/jquery-timeout/jquery.inactivityTimeout.min.js')}}"></script>

<script src="{{ asset('/plugins/toastr/toastr.min.js')}}"></script>

<script src="{{ asset('/js/app.js?v=') . rand(1,9) }}"></script>
<script src="{{ asset('/js/application.js?v=') . rand(1,9) }}"></script>

<script>
    base_url = function(param) {
        var public_url = window.location.origin
        var base_url = public_url + "/" + param;
        return base_url;
    }


    moment.locale('id');

    setInterval(function() {
        var tanggal = moment().format('dddd, DD MMMM YYYY, H:mm:ss');
        $(".date-time").html(tanggal);
    }, 1000);

    $(document).ready(function() {
        $(document).inactivityTimeout({
            inactivityWait: (60 * 60) * 12, // Dalam detik
            dialogWait: 120, // Dalam detik
            logoutUrl: base_url('access/logout'),
            dialogMessage: 'Untuk alasan keamanan, Aplikasi akan otomatis di tutup pada %s detik.' +
                '&nbsp;&nbsp;<a href="#" style="color: #FFF;"><strong>Klik di sini untuk melanjutkan</strong></a>',
        })
    })
</script>
@stack('script-default')