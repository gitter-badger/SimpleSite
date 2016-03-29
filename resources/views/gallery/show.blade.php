@extends('layouts.app')

@section('content')
    <div class="ui container">
        <br />
        <div class="ui stacked segment">
            <h2 class="ui header">{{ $category->title }}</h2>
            @if(!empty($category->description))
                <div class="category-description description">
                    <p>{{ $category->description }}</p>
                </div>
            @endif
        </div>

    <div class="ui five cards">
        @foreach($photos as $photo)
            <div class="card">
                <a class="image image-link" href="{{ $photo->file }}">
                    <img src="{{ $photo->thumb }}">
                </a>
                <div class="content">
                    @if(!empty($photo->caption))
                    <h5 class="ui header">{{ $photo->caption }}</h5>
                    @endif
                    @if(!empty($photo->description))
                        <div class="description">
                            <p>{{ $photo->description }}</p>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <div class="ui divider hidden"></div>

    {!! $photos->render() !!}
    </div>
@endsection
