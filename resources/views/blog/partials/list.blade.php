@if($posts->count() > 0)
<div class="ui items">
    @foreach($posts as $post)
        <div class="item news-item">
            <div class="content">
                <h3 class="header">
                    <a href="{{ route('news.show', [$post->id]) }}">{{ $post->title }}</a>
                </h3>
                <div class="meta">
                    <span class="author">{{ $post->author->name }}</span>
                </div>
                <div class="description">
                    {!! $post->text_intro !!}
                </div>
                <div class="meta align-right">
                    <span class="time align">{{ $post->created_at->format('d F Y') }}</span>
                </div>
            </div>
        </div>
    @endforeach
</div>
@else
    <div class="ui positive message">
        <div class="header">
            В разделе нет новостей
        </div>
    </div>
@endif