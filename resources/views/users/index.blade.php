@extends('layouts.app')

@section('content')
    <div class="ui container">
        <div class="box padded">
            <h2>@lang('core.title.users')</h2>

            <table class="ui selectable padded very basic table searchable">
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
                            <h4 class="header">
                                @if($user->avatar_url)
                                    <a class="image-link" style="float: left" href="{{ $user->avatar_url }}" title="{{ $user->display_name }}">
                                        <img src="{{ $user->avatar_url }}" class="ui mini circular image">
                                    </a>
                                @endif

                                <div class="content" style="float: left; padding-left: 20px">
                                    <a href="{{ route('user.profile', [$user->id]) }}">{{ $user->display_name }}</a>
                                    <br />
                                    <small class="sub">
                                        {{ $user->position }}
                                    </small>
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

@section('scripts')
<script>
    $('.searchable').filterTable({
        label: '<i class="search icon"></i>',
        containerTag: 'div',
        placeholder: 'Введите слово для поиска',
        containerClass: 'ui large fluid icon input input-search'
    });
</script>
@endsection