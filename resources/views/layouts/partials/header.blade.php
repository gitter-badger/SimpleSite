<header class="ui container ">
    <h1 class="ui header">@lang('core.title.portal')</h1>
</header>

<div class="ui attached stackable menu inverted green">
    <div class="ui container">
        {!! app('front.navigation')->render() !!}

        <div class="right inverted menu">
            @include('auth.partials.header')
        </div>
    </div>
</div>