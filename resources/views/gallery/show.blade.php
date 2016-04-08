@extends('layouts.app')

@section('content')
    <div class="ui container">
        <div class="photo-category-description box">
            <h1 class="header">{{ $category->title }}</h1>
            @if(!empty($category->description))
                <div class="category-description description">
                    <p>{{ $category->description }}</p>
                </div>
            @endif
        </div>

        <div class="photo-items">
            <div class="ui six doubling cards">
                @foreach($photos as $photo)
                    @include('gallery.partials.photo', ['photo' => $photo])
                @endforeach
            </div>
        </div>

        @if(auth()->user()->isSuperAdmin())
        <div id="upload" class="dropzone" style="margin: 50px 0;">
            Drop files here to upload
        </div>
        @endif
    </div>
@endsection

@if(auth()->user()->isSuperAdmin())
@section('scripts')
        <script>
            $(function () {
                $("#upload").dropzone({
                    url: '/upload/photo/{{ $category->id }}',
                    method: 'POST',
                    addRemoveLinks: true,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(file, response) {
                        if(response) {
                            $('.photo-items .cards').append(response.html);

                            file.photo = response.photo;
                        }
                    },
                    removedfile: function(file) {
                        $.ajax('/delete/photo/' + file.photo.id, {
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            method: 'DELETE',
                            success: function () {
                                $('[data-id="' + file.photo.id + '"]').remove();
                            }
                        });
                    }
                });
            });
        </script>
@endsection

@endif

