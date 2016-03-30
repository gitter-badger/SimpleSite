<div class="news-items box">
    <h2>Свежие новости</h2>

    @include('blog.partials.list')

    <div class="news-archive-link">
        <a href="{{ route('news.index') }}">Архив новостей</a>
    </div>
</div>