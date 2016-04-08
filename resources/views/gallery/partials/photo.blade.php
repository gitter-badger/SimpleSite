<div class="card" data-id="{{ $photo->id }}">
    <a class="image image-link" href="{{ $photo->image_url }}">
        <img src="{{ $photo->thumb_url }}">
    </a>
    @if(!empty($photo->caption) or !empty($photo->description))
    <div class="content">
        @if(!empty($photo->caption))
            <h5 class="ui header">{{ $photo->caption }}</h5>
        @endif
        @if(!empty($photo->description))
            <div class="description">
                <p>{{ $photo->description }}</p>
            </div>
        @endif
    </div>
    @endif
</div>