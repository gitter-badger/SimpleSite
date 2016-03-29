@extends('layouts.app')

@section('content')
    <div class="ui items container">
        <div class="news-item item">
            <div class="ui segment">
                <div class="content">
                    <h1 class="head">{{ $post->title }}</h1>
                    <div class="meta">
                        <span class="date">{{ $post->created_at->format('d F Y') }}</span>
                    </div>

                    <div class="description">

                    {!! $post->text_intro !!}

                    {!! $post->text !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
