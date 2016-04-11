@extends('layouts.app')

@section('content')
    <div class="ui container">
        <div class="news-items box">
            <h2>@lang('core.title.users')</h2>

            <table class="ui selectable padded very basic small table">
                <colgroup>
                    <col />
                    <col width="100px" />
                    <col width="150px" />
                    <col width="200px" />
                </colgroup>
                <thead>
                    <tr>
                        <th></th>
                        <th class="center aligned">@lang('core.user.field.phone_internal')</th>
                        <th class="right aligned">@lang('core.user.field.phone_mobile')</th>
                        <th>@lang('core.user.field.email')</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>
                            <h5 class="ui image header">
                                @if($user->avatar_url)
                                <img src="{{ $user->avatar_url }}" class="ui mini rounded image">
                                @endif
                                <div class="content">
                                    {{ $user->name }}
                                    <div class="sub header">
                                        {{ $user->position }}
                                    </div>
                                </div>
                            </h5>
                        </td>
                        <td class="center aligned">
                            @if($user->phone_internal > 0)
                            <strong>{{ $user->phone_internal }}</strong>
                            @endif
                        </td>
                        <td class="right aligned">
                            {{ $user->phone_mobile }}
                        </td>
                        <td>
                            <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
