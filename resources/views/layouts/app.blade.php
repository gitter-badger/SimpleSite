<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>@lang('core.title.portal')</title>
    <link href="{{ asset('css/app.css') }}" rel='stylesheet' type='text/css'>
</head>
<body>
    @include('layouts.partials.header')

    @yield('content')


    @include('layouts.partials.footer')

    <!-- JavaScripts -->
    <script src="{{ asset('api/settings.js') }}"></script>
    <script src="{{ asset('js/all.js') }}"></script>
    <script src="{{ asset('js/controllers.js') }}"></script>
    @yield('scripts')
</body>
</html>
