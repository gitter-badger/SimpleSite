@extends('layouts.app')

@section('content')
    <div class="ui container photo-categories">
        <h1 class="header">@lang('core.title.gallery')</h1>

        @if($categories->count() > 0)
            @include('gallery.partials.categories_list')

            <div class="ui divider hidden"></div>

            {!! $categories->render() !!}
        @else
            <div class="ui positive message">
                <div class="header">
                    @lang('core.message.empty_section')
                </div>
            </div>
        @endif
    </div>
@endsection
