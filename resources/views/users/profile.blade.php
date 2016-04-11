@extends('layouts.app')

@section('content')
<div class="ui container">
    <div class="ui section divider hidden"></div>
    <div class="ui items">
        <div class="ui item" id="uploadAvatar">
            <div class="ui inverted dimmer">
                <div class="ui text loader">Loading</div>
            </div>

            <div class="ui medium bordered image">
                <img src="{{ $user->avatar_url_or_blank }}" @can('change-avatar', $user) class="popup" data-content="@lang('core.user.message.drag_to_upload')" @endcan />
            </div>

            <div class="content">
                <h1>{{ $user->name }}</h1>

                <div class="ui section divider"></div>

                <div class="meta">
                    {{ $user->position }}
                </div>
            </div>
        </div>

        <div class="ui segment">
            <span class="ui red ribbon label">@lang('core.user.title.contacts')</span>
            <table class="ui very basic table">
                @foreach($user->contacts() as $contact)
                    <tr>
                        <td>{{ $contact['title'] }}</td>
                        <td><strong>{!! $contact['value'] !!}</strong></td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection

@can('change-avatar', $user)
@section('scripts')
<script>
    $(function () {
        $("#uploadAvatar").dropzone({
            url: "/profile/avatar",
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            params: {
              'user_id': {{ $user->id }}
            },
            clickable: true,
            uploadMultiple: false,
            previewsContainer: false,
            acceptedFiles: 'image/*',
            processing: function(file, response) {
                $('#uploadAvatar').dimmer('show');
            },
            success: function(file, response) {
                if(response) {
                    $('#uploadAvatar img').attr('src', response.user.avatar_url);
                }

                $('#uploadAvatar').dimmer('hide');
            }
        });
    });
</script>
@endsection
@endcan