<!DOCTYPE html>
<html lang="en">

<head>
    @include('includes.auth-css')
</head>

<body>
    <!-- login page start-->
    <div class="container-fluid p-0">
        @yield('content')
        @include('includes.auth-js')
    </div>
</body>

</html>