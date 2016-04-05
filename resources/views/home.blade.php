@extends('layouts.app')

@section('content')
<div class="ui container">
    @include('blog.latest')
    @include('poll.active')
</div>
@endsection
