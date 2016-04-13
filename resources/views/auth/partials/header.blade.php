@if (Auth::guest())
    <div class="item">
        <a class="ui button" href="{{ url('/login') }}">@lang('core.user.link.login')</a>
    </div>
@else
    <div class="ui dropdown item">
        {!! Auth::user()->name_with_avatar !!}
        <i class="dropdown icon"></i>
        <div class="menu">
            <a class="item" href="{{ route('profile') }}">
                <i class="circular inverted teal user icon"></i> @lang('core.user.link.profile')
            </a>
            @if (Auth::user()->isSuperAdmin())
                <a class="item" href="{{ url('/admin') }}">
                    <i class="circular inverted blue dashboard icon"></i> @lang('core.user.link.admin')
                </a>
            @endif
            <div class="ui divider"></div>
            <a class="item" href="{{ url('/logout') }}">
                <i class="circular inverted red power icon"></i> @lang('core.user.link.logout')
            </a>
        </div>
    </div>
@endif