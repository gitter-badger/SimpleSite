<header class="ui container ">
    <h1 class="ui header">@lang('core.title.portal')</h1>
</header>

<div class="ui attached stackable menu inverted green">
    <div class="ui container">
        <a class="item" href="{{ route('home') }}">@lang('core.title.index')</a>
        <a class="item" href="{{ route('news.index') }}">@lang('core.title.news')</a>
        <a class="item" href="{{ route('gallery.index') }}">@lang('core.title.gallery')</a>
        @if (Auth::guest())
            <a class="item" href="{{ url('/login') }}">@lang('core.title.login')</a>
        @else
            <a class="item" href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>@lang('core.title.logout')</a>
        @endif
    </div>
</div>