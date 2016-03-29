@extends('layouts.app')

@section('content')
    <div class="ui container">
        <div class="news-items">
            <h2>Архив новостей</h2>

            @include('blog.partials.list')

            {!! $posts->render() !!}
        </div>
    </div>
@endsection
