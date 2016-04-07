@extends('layouts.app')

@section('content')
    <div class="ui container">
        <div class="ui items">
            <div class="news-item item box">
                <div class="content">
                    <span class="ui ribbon @if(!$post->isPastEvent()) pink @endif label">
                        {!! $post->type_title !!}
                    </span>

                    <h1>{{ $post->title }}</h1>

                    <div class="meta">
                        <span class="author">{!! $post->author->name !!}</span> <span>|</span>
                        <span class="date">@lang('core.post.field.created_at'): {{ $post->created_at->format('d F Y') }}</span>
                    </div>

                    <div class="ui section divider"></div>

                    <div class="description">
                        {!! $post->text_intro !!}

                        @if(!empty($post->image))
                            <div class="image">
                                <img src="{{ $post->image_url }}" class="ui rounded image">
                            </div>
                        @endif

                        {!! $post->text !!}
                    </div>

                    @if( !$post->isPastEvent())

                        <br/>
                        <br/>

                        <div ng-app="PostMembers" ng-controller="PostMembersCtrl" ng-init="postId='{{ $post->id }}'" ng-model="postId">
                            <div class="ui labeled button" tabindex="0" ng-hide="is_guest || is_member">
                                <button class="ui green button" ng-click="attend()" ng-hide="is_member">
                                    <i class="checkmark icon"></i> @lang('core.post.button.attend')
                                </button>
                                <a class="ui basic green label" ng-click="showMembers()">
                                    <% count %>
                                </a>
                            </div>
                            <div ng-show="is_guest || is_member">
                                <a class="ui green statistic" ng-click="showMembers()">
                                    <div class="value">
                                        <i class="child icon"></i>  <% count %>
                                    </div>
                                    <div class="label">
                                        @lang('core.post.label.total_members')
                                    </div>
                                </a>
                            </div>

                            <div class="ui modal">
                                <i class="close icon"></i>
                                <div class="header">
                                    @lang('core.post.label.members')
                                </div>
                                <div class="content">
                                    <div class="ui horizontal relaxed selection list">
                                        <div class="item" ng-repeat="member in members">
                                            <img class="ui avatar image" src="<% member.avatar_url %>">
                                            <div class="content">
                                                <span class="header"><% member.name %></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        @if($categories->count() > 0)
            <h1>@lang('core.title.gallery')</h1>
            @include('gallery.partials.categories_list')
        @endif
    </div>
@endsection
