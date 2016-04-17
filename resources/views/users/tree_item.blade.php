<ul>
    @foreach($tree as $user)
        <li>
            <a href="#">{{ array_get($user, 'display_name') }}</a>
            @if(!empty($user['childNodes']))
                @include('users.tree_item', ['tree' => $user['childNodes']])
            @endif
        </li>
    @endforeach
</ul>

