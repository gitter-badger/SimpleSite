@extends('layouts.app')

@section('content')
    <div class="ui container">
        <div class="box padded">
            <h1>@lang('core.post.title.edit')</h1>
            <link rel="stylesheet" href="//cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
            <script src="//cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
            <script>
                $(function () {
                    var simplemde = new SimpleMDE({element: document.getElementById("inputText")});

                    var zone = new FileDrop('textArea', {input: false});
                    zone.event('send', function (files) {
                        files.each(function (file) {
                            file.event('done', function (xhr) {
                                var response = JSON.parse(xhr.responseText)
                                simplemde.codemirror.replaceSelection(' ![' + response.name + '](' + response.file_url + ') ');
                            });
                            file.sendTo('/upload/image?_token=' + $('meta[name="csrf-token"]').attr('content'));
                        })
                    })
                });
            </script>

            {!! Form::model($post , [
                'route' => ['news.update', $post->id],
                'class' => 'ui form',
                'method' => 'PUT'
            ]) !!}


            @if (count($errors) > 0)
                <div class="ui warning message">
                    <ul class="list">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="field">
                <label class="control-label">@lang('core.post.field.title')</label>
                {!! Form::text('title', null, ['id' => 'inputTitle']) !!}
            </div>

            <div class="field" id="textArea">
                {!! Form::textarea('text_source', null, ['rows' => 30, 'id' => 'inputText']) !!}
            </div>

            <div class="field">
                {!! Form::select('photo_categories[]', $categories, $selected_categories, [
                 'multiple', 'class' => 'ui fluid  dropdown'
                ]) !!}
            </div>

            {!! Form::button('<i class="icon checkmark"></i> '.trans('core.post.button.save'), [
                'type' => 'submit', 'value' => 'save',
                'class' => 'ui big positive button'
            ]) !!}

            {!! Form::close() !!}

        </div>
    </div>
@endsection
