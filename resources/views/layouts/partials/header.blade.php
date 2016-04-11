<header class="ui container ">
    <h1 class="ui header">@lang('core.title.portal')</h1>
</header>

<div class="ui attached stackable menu inverted green">
    <div class="ui container">
        <a class="item" href="{{ route('home') }}">@lang('core.title.index')</a>
        <a class="item" href="{{ route('news.index') }}">@lang('core.title.news')</a>
        <a class="item" href="{{ route('gallery.index') }}">@lang('core.title.gallery')</a>
        <a class="item" href="{{ route('user.index') }}">@lang('core.title.users')</a>

        <div class="right inverted menu">
            @if (Auth::guest())
                <div class="item">
                    <a class="ui button" href="{{ url('/login') }}">@lang('core.title.login')</a>
                </div>
            @else
                @if (Auth::user()->isSuperAdmin())
                <a class="ui olive item" href="{{ url('/admin') }}"><i class="dashboard icon"></i> @lang('core.title.admin')</a>
                @endif

                <a class="item" href="{{ route('profile') }}">{!! Auth::user()->name_with_avatar !!}</a>
                <a class="item" href="{{ url('/logout') }}">@lang('core.title.logout')</a>
            @endif
        </div>
    </div>
</div>