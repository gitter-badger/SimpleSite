@extends('layouts.app')

@section('content')
    <div class="ui container" id="userProfile">
        <div class="ui items">
            <div class="ui item margin-vr box" id="uploadAvatar">
                <div class="ui inverted dimmer">
                    <div class="ui text loader">Loading</div>
                </div>

                <div class="ui medium image">
                    @can('change-avatar', $user)
                    <a class="ui orange left corner label link"> <i class="photo icon"></i> </a>
                    @endcan

                    <img src="{{ $user->avatar_url_or_blank }}"/>
                </div>

                <div class="content description">
                    <h1>{{ $user->display_name }}</h1>

                    <table class="ui very basic table">
                        <colgroup>
                            <col width="200px"/>
                            <col/>
                        </colgroup>
                        <tbody>
                            @if(!is_null($chief))
                                <tr>
                                    <td>@lang('core.user.field.chief')</td>
                                    <td>{!! $chief->profile_link !!}</td>
                                </tr>
                            @endif
                            <tr>
                                <td>@lang('core.user.field.position')</td>
                                <td>{{ $user->position }}</td>
                            </tr>
                            @if($user->birthday)
                                <tr>
                                    <td>@lang('core.user.label.birthday')</td>
                                    <td><time data-format="D MMMM" data-value="{{ $user->birthday }}"></time></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="ui margin-vr box padded">
                <span class="ui red ribbon label">@lang('core.user.title.contacts')</span>
                <table class="ui very basic table">
                    <colgroup>
                        <col width="200px"/>
                        <col/>
                    </colgroup>
                    @foreach($contacts as $contact)
                        <tr>
                            <td>{{ $contact['title'] }}</td>
                            <td><strong>{!! $contact['value'] !!}</strong></td>
                        </tr>
                    @endforeach
                </table>
            </div>

            @if(count($events) > 0)
                <div class="ui margin-vr box padded">
                    <span class="ui red ribbon label">@lang('core.user.title.events')</span>
                    <div class="ui hidden divider"></div>
                    @include('blog.partials.card', ['posts' => $events])
                </div>
            @endif

            <div class="margin-vr box padded">
                <span class="ui red ribbon label">@lang('core.user.title.calendar')</span>
                <div id='calendar'></div>
            </div>
        </div>
    </div>
@endsection

@can('change-avatar', $user)
@section('scripts')
    <script>
        $("#uploadAvatar").dropzone({
            url: Asset.path('profile/avatar'),
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            params: {
                'user_id': {{ $user->id }}
            },
            uploadMultiple: false,
            previewsContainer: false,
            acceptedFiles: 'image/*',
            clickable: ".image .corner",
            processing: function (file, response) {
                $('#uploadAvatar').dimmer('show');
            },
            success: function (file, response) {
                if (response) {
                    $('#uploadAvatar img').attr('src', response.user.avatar_url);
                }

                $('#uploadAvatar').dimmer('hide');
            }
        });

        $('#calendar').fullCalendar({
            lang: window.settings.locale,
            events: {
                url: Asset.path('api/user/'+{{ $user->id }}+'/calendar.json'),
                success
        :
        function (events) {
            return events;
        }
        }
        })
        ;
    </script>
@endsection
@endcan