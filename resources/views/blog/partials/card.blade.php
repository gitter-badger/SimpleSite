<div class="ui {{ $num or 'tree' }} cards">
    @foreach($posts as $post)
        <div class="card">
            <div class="content">
                <h4 class="header">
                    <a href="{{ $post->link }}">{{ $post->title }}</a>
                </h4>

                <span class="ui mini @if($post->isEvent() and !$post->isPastEvent()) pink @endif label">
                    {!! $post->type_title !!}
                </span>

                <div class="ui divider"></div>

                <div class="description">
                    {!! $post->text_intro !!}
                </div>
                <div class="meta align-right">

                </div>
            </div>
            <div class="extra content">
                <span class="time">{{ $post->created_at->format('d.m.Y') }}</span>
            </div>
            @if(!empty($post->thumb))
            <a class="image" href="{{ route('news.show', [$post->id]) }}">
                <img src="{{ $post->thumb_url }}">
            </a>
            @endif
        </div>
    @endforeach
</div>