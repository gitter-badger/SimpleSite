@extends('layouts.app')

@section('content')
    <div class="ui container">
        <div class="ui items">
            <div class="news-item item box">
                <div class="content">
                    <h1>{{ $post->title }}</h1>

                    <div class="meta">
                        <span class="author">{!! $post->author->name !!}</span>
                        <span>|</span>
                        <span class="date">Опубликовано: {{ $post->created_at->format('d F Y') }}</span>
                    </div>

                    <div class="ui section divider"></div>

                    <div class="description">

                        {!! $post->text_intro !!}

                        @if(!empty($post->image))
                            <div class="image">
                                <img src="{{ $post->image_url }}">
                            </div>
                        @endif

                        {!! $post->text !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
