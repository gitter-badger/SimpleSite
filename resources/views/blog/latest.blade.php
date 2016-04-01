<div class="news-items box">
    <h2>@lamg('core.post.title.latest')</h2>

    @include('blog.partials.list')

    <div class="news-archive-link">
        <a href="{{ route('news.index') }}">@lamg('core.post.title.archive')</a>
    </div>
</div>