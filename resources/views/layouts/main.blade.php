<!DOCTYPE html>
<html lang="en">

<head>
    @include('includes.main-css')
</head>

<body>
    <div class="loader-wrapper">
        <div class="loader-index"><span></span></div>
        <svg>
            <defs></defs>
            <filter id="goo">
                <fegaussianblur in="SourceGraphic" stddeviation="11" result="blur"></fegaussianblur>
                <fecolormatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo"> </fecolormatrix>
            </filter>
        </svg>
    </div>
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">

        <!-- Page Header Start-->
        @include('includes.main-header')
        <!-- Page Header Ends-->

        <!-- Page Body Start-->
        <div class="page-body-wrapper">

            <!-- Page Sidebar Start-->
            @include('includes.main-sidebar')
            <!-- Page Sidebar Ends-->

            <div class="page-body">
                <div class="container-fluid">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-6">
                                <h3>{{$menu_name}}</h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{url('')}}"> <i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item active">{{$menu_name}}</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Container-fluid starts-->

                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- Container-fluid Ends-->
                
                <!-- Form Modal Start -->
                <div class="modal fade" id="form-modal" role="dialog" data-backdrop="static" aria-labelledby="form-modal" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content animated fadeInLeft">
                            <div class="modal-header">
                                <h4 class="modal-title" id="form-modal-title" style="font-size: 18px;"></h4>
                                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div id="form-modal-content"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Form Modal End -->
            </div>

            <!-- footer start-->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 footer-copyright text-center">
                            <p class="mb-0">Copyright 2021 © Paw Development </p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    @include('includes.main-js')
</body>

</html>