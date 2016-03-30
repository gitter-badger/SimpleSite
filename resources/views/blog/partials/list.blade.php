<div class="ui items news-list">
    @foreach($posts as $post)
        <div class="item news-item">
            <div class="content">
                <h3 class="header">
                    <a href="{{ route('news.show', [$post->id]) }}">{{ $post->title }}</a>
                </h3>

                <div class="description">
                    {!! $post->text_intro !!}
                </div>

                <div class="meta">
                    <span class="date">{{ $post->created_at->format('d F Y') }}</span>
                </div>
            </div>
            @if(!empty($post->thumb))
                <div class="image">
                    <img src="{{ $post->thumb_url }}">
                </div>
            @endif
        </div>

        <div class="ui news-divider divider"></div>
    @endforeach
</div>