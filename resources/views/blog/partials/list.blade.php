<div class="ui items news-list">
    @foreach($posts as $post)
        <div class="item news-item">
            <div class="content">
                <span class="ui ribbon @if($post->isEvent() and !$post->isPastEvent()) pink @endif label">
                    {!! $post->type_title !!}
                </span>

                <h2>
                    <a href="{{ $post->link }}">{{ $post->title }}</a>
                </h2>

                <div class="description">
                    {!! $post->text_intro !!}
                </div>

                <div class="meta">
                    <span class="date">
                        <time>{{ $post->created_at }}</time>
                    </span>
                </div>
            </div>

            @if(!empty($post->thumb))
            <div class="image">
                <img src="{{ $post->thumb_url }}">
            </div>
            @endif
        </div>

        <div class="members">
            @if($post->members->count() > 0)
                <h4>@lang('core.post.label.members')</h4>
                <div class="members-list">
                    @foreach($post->members as $member)
                        {!! $member->profile_link !!}
                    @endforeach
                </div>
                <br />
            @endif

            @if(policy($post)->participate(auth()->user(), $post))
                @if(!auth()->guest())
                    {!! Form::model($post , ['route' => ['post.members.add', $post->id], 'method' => 'PUT']) !!}
                    <button class="ui green small button">
                        <i class="checkmark icon"></i> @lang('core.post.button.attend')
                    </button>
                    {!! Form::close() !!}
                @else
                    <button class="ui green small button" disabled>
                        <i class="checkmark icon"></i> @lang('core.post.label.authorize_to_participate')
                    </button>
                @endif
            @endif
        </div>

        <div class="ui news-divider divider"></div>
    @endforeach
</div>