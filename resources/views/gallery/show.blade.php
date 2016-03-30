@extends('layouts.app')

@section('content')
    <div class="ui container">
        <div class="photo-category-description box">
            <h1 class="header">{{ $category->title }}</h1>
            @if(!empty($category->description))
                <div class="category-description description">
                    <p>{{ $category->description }}</p>
                </div>
            @endif
        </div>
    </div>

    <div class="photo-items">
        <div class="ui six doubling cards">
            @foreach($photos as $photo)
                <div class="card">
                    <a class="image image-link" href="{{ $photo->image_url }}">
                        <img src="{{ $photo->thumb_url }}">
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
    </div>


    <div class="ui container">
        {!! $photos->render() !!}
    </div>

@endsection
