<div class="ui four doubling cards">
    @foreach($categories as $category)
        <div class="card photo-category">
            <div class="content">
                <h4 class="header">
                    <a href="{{ route('gallery.category', [$category->id]) }}">
                        {{ $category->title }}
                    </a>
                </h4>
            </div>
            <div class="extra content">
                <div class="meta">
                    <small class="date">{{ $category->created_at->format('d F Y') }}</small>
                </div>
            </div>
            <a class="image" href="{{ route('gallery.category', [$category->id]) }}">
                <img src="{{ $category->thumb_url }}">
            </a>
        </div>
    @endforeach
</div>