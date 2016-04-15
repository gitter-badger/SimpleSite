@extends('layouts.app')

@section('content')
    <div class="ui container" ng-init="postId='{{ $post->id }}'">
        <div class="ui items">
            <div class="news-item item box margin-vr padded">
                <div class="content">
                    <span class="ui ribbon @if(!$post->isPastEvent()) pink @endif label">
                        {!! $post->type_title !!}
                    </span>

                    <h1>{{ $post->title }}</h1>

                    <div class="ui section divider"></div>

                    <div class="description">
                        {!! $post->text_intro !!}

                        @if(!empty($post->image))
                            <br/>
                            <div class="image">
                                <img src="{{ $post->image_url }}" class="ui rounded image">
                            </div>
                            <br/>
                        @endif

                        {!! $post->text !!}
                    </div>

                    @if($post->isEvent() and !$post->isPastEvent())
                        <br/>
                        <br/>
                        @include('blog.partials.members')
                    @endif

                    <div class="ui section divider"></div>

                    <div class="meta">
                        {{-- <span class="author">{!! $post->author->name !!}</span>  <span>|</span> --}}
                        <span class="date">
                            @lang('core.post.field.created_at'): <time>{{ $post->created_at }}</time>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        @if($categories->count() > 0)
            <h1>@lang('core.title.gallery')</h1>
            @include('gallery.partials.categories_list')
        @endif
    </div>
@endsection
