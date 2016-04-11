<div class="news-items box">
    <h2>@lang('core.post.title.latest')</h2>

    @include('blog.partials.list')

    <div class="news-archive-link">
        <a href="{{ route('news.index') }}" class="ui button">@lang('core.post.title.archive')</a>
    </div>
</div>