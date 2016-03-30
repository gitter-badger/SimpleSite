@extends('layouts.app')

@section('content')
    <div class="ui container photo-categories">
        <h1 class="header">Фотоархив</h1>

        @if($categories->count() > 0)
            <div class="ui four doubling cards">
                @foreach($categories as $category)
                    <div class="card photo-category">
                        <div class="content">
                            <a class="header" href="{{ route('gallery.category', [$category->id]) }}">
                                {{ $category->title }}
                            </a>
                            <div class="meta">
                                <span class="date">{{ $category->created_at->format('d F Y') }}</span>
                            </div>

                            @if(!empty($category->description))
                                <div class="description">
                                    <p>{{ $category->description }}</p>
                                </div>
                            @endif
                        </div>

                        <a class="image" href="{{ route('gallery.category', [$category->id]) }}">
                            <img src="{{ $category->thumb_url }}">
                        </a>
                    </div>
                @endforeach
            </div>

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
