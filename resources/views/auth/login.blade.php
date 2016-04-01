@extends('layouts.app')

@section('content')
    <style type="text/css">
        .column {
            margin-top: 50px;
            max-width: 450px;
        }
    </style>
    <div class="ui middle center aligned grid">
        <div class="column">
            <h2 class="ui teal header">
                @lang('core.title.login')
            </h2>
            <form class="ui large form" role="form" method="POST" action="{{ url('/login') }}">

                {!! csrf_field() !!}

                <div class="ui  segment">
                    <div class="field {{ $errors->has('email') ? 'error' : '' }}">
                        <div class="ui left icon input">
                            <i class="user icon"></i>
                            <input type="text" name="email" value="{{ old('email') }}" placeholder="E-mail address">
                        </div>
                    </div>
                    <div class="field {{ $errors->has('password') ? 'error' : '' }}">
                        <div class="ui left icon input">
                            <i class="lock icon"></i>
                            <input type="password" name="password" placeholder="Password">
                        </div>
                    </div>

                    <div class="field">
                        <div class="ui checkbox">
                            <input type="checkbox" name="remember" tabindex="0" class="hidden">
                            <label>Remember Me</label>
                        </div>
                    </div>

                    <button class="ui fluid large teal submit button">Login</button>
                </div>

                @if (count($errors) > 0)
                    <div class="ui error message">
                        <ul class="list">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        </ul>
                    </div>
                @endif
            </form>
        </div>
    </div>
@endsection
