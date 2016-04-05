<div class="ui {{ $num or 'tree' }} cards">
    @foreach($posts as $post)
        <div class="card">
            <div class="content">
                <span class="ui top attached @if(!$post->isPastEvent()) pink @endif label">
                    {!! $post->type_title !!}
                </span>

                <h4 class="header">
                    <a href="{{ route('news.show', [$post->id]) }}">{{ $post->title }}</a>
                </h4>

                <div class="description">
                    {!! $post->text_intro !!}
                </div>
                <div class="meta align-right">
                    <span class="type">{!! $post->type_title !!}</span>
                    <span class="time">{{ $post->created_at->format('d F Y') }}</span>
                </div>
            </div>
            @if(!empty($post->thumb))
                <a class="image" href="{{ route('news.show', [$post->id]) }}">
                    <img src="{{ $post->thumb_url }}">
                </a>
            @endif
        </div>
    @endforeach
</div>