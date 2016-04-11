@extends('layouts.app')

@section('content')
    <div class="ui container">
        <div class="ui section divider hidden"></div>
        <div class="ui items">
            <div class="ui item" id="uploadAvatar">

                <div class="ui medium image">
                    <img src="{{ $user->avatar_url_or_blank }}" @if($isOwner) class="popup" data-content="@lang('core.user.message.drag_to_upload')" @endif />
                </div>

                <div class="content">
                    <h1>{{ $user->name }}</h1>

                    <div class="ui section divider"></div>

                    <div class="meta">
                        {{ $user->position }}
                    </div>
                    <div class="description">
                        <div class="ui list">
                            <div class="item">
                                <i class="mail icon"></i>
                                <div class="content">
                                    {!! $user->mail_to !!}
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@if($isOwner)
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
                    uploadMultiple: false,
                    previewsContainer: false,
                    acceptedFiles: 'image/*',
                    success: function(file, response) {
                        if(response) {
                            $('#uploadAvatar img').attr('src', response.user.avatar_url);
                        }
                    }
                });
            });
        </script>
    @endsection
@endif