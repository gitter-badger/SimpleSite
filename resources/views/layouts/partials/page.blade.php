@if($hasChild)
<div {!! $attributes !!}>
    {!! $icon !!} {!! $title !!} {!! $badge !!} <i class="dropdown icon"></i>
    <div class="menu">
        @foreach($pages as $page)
            {!! $page->render() !!}
        @endforeach
    </div>
</div>
@else
<a {!! $attributes !!} href="{{ $url }}">{!! $icon !!} {!! $title !!} {!! $badge !!}</a>
@endif

