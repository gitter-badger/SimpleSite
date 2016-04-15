@if(count($users) > 0)
<div class="margin-vr">
    <div class="ui segment">
        <a class="ui orange ribbon label">@lang('core.user.label.nearest_birthdays')</a>

        <div class="ui very relaxed divided list">
            @foreach($users as $user)
            <div class="item">
                <img class="ui avatar mini image" src="{{ $user->avatar_url }}">
                <div class="content">
                    <a class="header" href="{{ $user->link }}">{{ $user->display_name }}</a>
                    <div class="description">
                        <time data-format="D MMMM">{{ $user->birthday }}</time>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif