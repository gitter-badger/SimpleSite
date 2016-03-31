<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>Laravel</title>

    <link href="/css/app.css" rel='stylesheet' type='text/css'>

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    <script src="/js/semantic.min.js"></script>
    <script src="/js/all.js"></script>
</head>
<body>
    @include('layouts.partials.header')
    @yield('content')
</body>
</html>
