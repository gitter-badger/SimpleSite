<ul>
    @foreach($tree as $user)
        <li>
            <div class="card">
                {!! array_get($user, 'profile_link') !!}
                @if(!empty($user['position']))
                <br />
                {{ array_get($user, 'position') }}
                @endif
            </div>

            @if(!empty($user['children']))
                @include('users.tree_item', ['tree' => $user['children']])
            @endif
        </li>
    @endforeach
</ul>

