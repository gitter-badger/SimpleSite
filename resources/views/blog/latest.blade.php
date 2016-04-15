<div class="news-items box margin-vr padded">
    <h2>@lang('core.post.title.latest')</h2>

    @include('blog.partials.list')

    <div class="news-archive-link">
        <a href="{{ route('news.index') }}" class="ui orange basic button">
            <i class="archive icon"></i>
            @lang('core.post.title.archive')
        </a>
    </div>
</div>