<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="{{ config('app.name') }}">
<meta name="keywords" content="{{ config('app.name') }}">
<meta name="author" content="pawdev.id@gmail.com">
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ config('app.name') }}</title>

<!-- Google font-->
<link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">


<link rel="stylesheet" type="text/css" href="{{ asset('/theme/cuba/assets/css/font-awesome.css') }}">
<!-- ico-font-->
<link rel="stylesheet" type="text/css" href="{{ asset('/theme/cuba/assets/css/vendors/icofont.css') }}">
<!-- Themify icon-->
<link rel="stylesheet" type="text/css" href="{{ asset('/theme/cuba/assets/css/vendors/themify.css') }}">
<!-- Flag icon-->
<link rel="stylesheet" type="text/css" href="{{ asset('/theme/cuba/assets/css/vendors/flag-icon.css') }}">
<!-- Feather icon-->
<link rel="stylesheet" type="text/css" href="{{ asset('/theme/cuba/assets/css/vendors/feather-icon.css') }}">

<!-- Plugins css start-->
<link rel="stylesheet" type="text/css" href="{{ asset('/theme/cuba/assets/css/vendors/scrollbar.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('/theme/cuba/assets/css/vendors/select2.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('/theme/cuba/assets/css/vendors/sweetalert2.css') }}">

<link rel="stylesheet" type="text/css" href="{{ asset('/theme/cuba/assets/css/vendors/date-picker.css') }}">
<!-- Plugins css Ends-->

<!-- Bootstrap css-->
<link rel="stylesheet" type="text/css" href="{{ asset('/theme/cuba/assets/css/vendors/bootstrap.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('/plugins/toastr/toastr.min.css') }}">

@stack('style-default')
<!-- App css-->
<link rel="stylesheet" type="text/css" href="{{ asset('/theme/cuba/assets/css/style.css') }}">
<link id="color" rel="stylesheet" href="{{ asset('/theme/cuba/assets/css/color-1.css') }}" media="screen">
<!-- Responsive css-->
<link rel="stylesheet" type="text/css" href="{{ asset('/theme/cuba/assets/css/responsive.css') }}">

<link rel="stylesheet" type="text/css" href="{{ asset('/css/application.css?v='.rand(1,10)) }}">