<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <title>@lang('core.title.portal')</title>

    {!! Assets::getCssList() !!}
</head>
<body>
    @include('layouts.partials.header')

    @yield('content')


    @include('layouts.partials.footer')

    <!-- JavaScripts -->
    {!! Assets::getJsList() !!}
    @yield('scripts')
</body>
</html>
