@extends('layouts.app')

@section('content')
    <div class="ui container">
        <div class="box">
            <h2>@lang('core.title.users')</h2>

            <table class="ui selectable padded very basic small table searchable">
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
                @foreach($users as $char => $_users)
                    <tr>
                        <th colspan="4">{{ $char }}</th>
                    </tr>
                    @foreach($_users as $user)
                    <tr>
                        <td>
                            <h4 class="ui image header">
                                @if($user->avatar_url)
                                <a class="image-link" href="{{ $user->avatar_url }}" title="{{ $user->display_name }}">
                                    <img src="{{ $user->avatar_url }}" class="ui mini rounded image">
                                </a>
                                @endif
                                <div class="content">
                                    <a href="{{ route('user.profile', [$user->id]) }}">{{ $user->display_name }}</a>
                                    <div class="sub header">
                                        {{ $user->position }}
                                    </div>
                                </div>
                            </h4>
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
                            {!! $user->mail_to !!}
                        </td>
                    </tr>
                    @endforeach
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
