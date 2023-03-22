<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

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
            @yield('content')
        </div>
    </div>
</div>
<div id='app'></div>
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
