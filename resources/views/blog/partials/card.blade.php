<div class="ui four cards">
    @foreach($posts as $post)
        <div class="card">
            <div class="content">
                <h4 class="header">
                    <a href="{{ route('news.show', [$post->id]) }}">{{ $post->title }}</a>
                </h4>

                <div class="description">
                    {!! $post->text_intro !!}
                </div>
                <div class="meta align-right">
                    <span class="time align">{{ $post->created_at->format('d F Y') }}</span>
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