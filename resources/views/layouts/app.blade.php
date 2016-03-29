<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <link href="/css/app.css" rel='stylesheet' type='text/css'>
</head>
<body>

<header class="ui container">
    <h1 class="ui header">Корпоративный портал</h1>
</header>

<div class="ui attached stackable menu">
    <div class="ui container">
        <a class="item" href="{{ route('home') }}">Главная</a>
        <a class="item" href="{{ route('news.index') }}">Новости</a>
        <a class="item" href="{{ route('gallery.index') }}">Фотоархив</a>
        @if (Auth::guest())
            <a class="item" href="{{ url('/login') }}">Авторизация</a>
        @else
            <a class="item" href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Выход</a>
        @endif
    </div>
</div>

@yield('content')

<!-- JavaScripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<script src="/js/semantic.min.js"></script>
<script src="/js/all.js"></script>

</body>
</html>
