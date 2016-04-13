<div class="ui items news-list">
    @foreach($posts as $post)
        <div class="item news-item">
            <div class="content">
                <span class="ui ribbon @if($post->isEvent() and !$post->isPastEvent()) pink @endif label">
                    {!! $post->type_title !!}
                </span>

                <h2>
                    <a href="{{ $post->link }}">{{ $post->title }}</a>
                </h2>

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