<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    <link rel="stylesheet" href="{{ mix('css/employee.css') }}">
</head>
<body>
@include('layouts.partials.admin_header')
@include('layouts.partials.admin_sidebar')
<div class="content-wrapper" style="min-height: 384.4px;">
    <div class="content-header">
        <div class="container-fluid">
            @yield('contentHeader')
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div id='app'>
            </div>
            @yield('content')
        </div>
    </div>
</div>

<script src="{{ mix('js/app.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@yield('script')
</body>
</html>
