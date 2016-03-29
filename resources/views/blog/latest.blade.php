<div class="news-items">
    <h2>Свежие новости</h2>

    @include('blog.partials.card')

    <div class="news-archive-link">
        <a href="{{ route('news.index') }}">Архив новостей</a>
    </div>
</div>
