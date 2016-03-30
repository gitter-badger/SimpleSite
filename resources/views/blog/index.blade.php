@extends('layouts.app')

@section('content')
    <div class="ui container">
        <div class="news-items box">
            <h2>Архив новостей</h2>

            @include('blog.partials.list')
        </div>

        {!! $posts->render() !!}
    </div>
    <br />
    <br />
@endsection
