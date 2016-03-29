@extends('layouts.app')

@section('content')
    <div class="ui container">
        <div class="news-items">
            <h2>Фотоархив</h2>

            <div class="ui five cards">
                @foreach($categories as $category)
                    <div class="card">
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

                        <div class="image">
                            <img src="{{ $category->thumb }}">
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="ui divider hidden"></div>

            {!! $categories->render() !!}
        </div>
    </div>
@endsection
