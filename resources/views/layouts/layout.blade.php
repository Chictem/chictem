<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <title>@yield('title', env('APP_NAME_DISPLAY', '安全课程教学网站'))</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <!-- CSS Libs -->
    <link rel="stylesheet" type="text/css" href="{{ config('voyager.assets_path') }}/lib/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="{{ config('voyager.assets_path') }}/lib/css/animate.min.css">
    <link rel="stylesheet" type="text/css" href="{{ config('voyager.assets_path') }}/lib/css/bootstrap-switch.min.css">
    <link rel="stylesheet" type="text/css" href="{{ config('voyager.assets_path') }}/lib/css/checkbox3.min.css">
    <link rel="stylesheet" type="text/css" href="{{ config('voyager.assets_path') }}/lib/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="{{ config('voyager.assets_path') }}/lib/css/dataTables.bootstrap.css">
    <link rel="stylesheet" type="text/css" href="{{ config('voyager.assets_path') }}/lib/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="{{ config('voyager.assets_path') }}/lib/css/toastr.min.css">
    <link rel="stylesheet" type="text/css" href="{{ config('voyager.assets_path') }}/css/bootstrap-toggle.min.css">
    <link rel="stylesheet" type="text/css" href="{{ config('voyager.assets_path') }}/js/icheck/icheck.css">

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    @stack('scripts-lib')

    @stack('css')
</head>

<body>

<div id="page-content-wrapper">
    @yield('wrapper')
</div>

<!-- Javascript Libs -->
<script type="text/javascript" src="{{ config('voyager.assets_path') }}/lib/js/jquery.min.js"></script>
<script type="text/javascript" src="{{ config('voyager.assets_path') }}/lib/js/bootstrap.min.js"></script>
<script type="text/javascript" src="{{ config('voyager.assets_path') }}/lib/js/bootstrap-switch.min.js"></script>
<script type="text/javascript" src="{{ config('voyager.assets_path') }}/lib/js/jquery.matchHeight-min.js"></script>
<script type="text/javascript" src="{{ config('voyager.assets_path') }}/lib/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{ config('voyager.assets_path') }}/lib/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="{{ config('voyager.assets_path') }}/lib/js/select2.full.min.js"></script>
<script type="text/javascript" src="{{ config('voyager.assets_path') }}/js/bootstrap-toggle.min.js"></script>
<script type="text/javascript" src="{{ config('voyager.assets_path') }}/js/jquery.cookie.js"></script>

@stack('scripts-lib')

@stack('scripts')

@stack('modals')

</body>
</html>
