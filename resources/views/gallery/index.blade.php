@extends('layouts.app')

@section('content')
    <div class="ui container photo-categories">
        <h1 class="header">Фотоархив</h1>

        @if($categories->count() > 0)
            @include('gallery.partials.categories_list')

            <div class="ui divider hidden"></div>

            {!! $categories->render() !!}
        @else
            <div class="ui positive message">
                <div class="header">
                    В разделе нет информации
                </div>
            </div>
        @endif
    </div>
@endsection
