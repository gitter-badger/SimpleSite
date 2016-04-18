@extends('layouts.app')

@section('content')
    <div class="tree">
        @include('users.tree_item')
    </div>
@endsection