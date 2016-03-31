<div class="ui four doubling cards">
    @foreach($categories as $category)
        <div class="card photo-category">
            <div class="content">
                <a class="header" href="{{ route('gallery.category', [$category->id]) }}">
                    {{ $category->title }}
                </a>
                <div class="meta">
                    <span class="date">{{ $category->created_at->format('d F Y') }}</span>
                </div>

                @if(!empty($category->description))
                    <div class="description">
                        <p>{{ $category->description }}</p>
                    </div>
                @endif
            </div>

            <a class="image" href="{{ route('gallery.category', [$category->id]) }}">
                <img src="{{ $category->thumb_url }}">
            </a>
        </div>
    @endforeach
</div>