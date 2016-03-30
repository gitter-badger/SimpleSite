<header class="ui container ">
    <h1 class="ui header">Корпоративный портал</h1>
</header>

<div class="ui attached stackable menu inverted green">
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