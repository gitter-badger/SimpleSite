@extends('layouts.app')

@section('content')
<div class="ui container">
    <div class="ui grid">
        <div class="ten wide column">
            @include('blog.latest')
        </div>
        <div class="six wide column">
            <div class="margin-vr">
                @include('poll.active')
            </div>

            @include('users.birthdays')
        </div>
    </div>
</div>
@endsection
