@extends('layouts.app')

@section('content')
    <div class="ui container">
        <div class="news-items box">
            <h2>@lamg('core.post.title.archive')</h2>

            @include('blog.partials.list')
        </div>

        {!! $posts->render() !!}
    </div>
    <br />
    <br />
@endsection
