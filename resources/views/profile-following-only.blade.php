<div class="list-group">
    @foreach ($followings as $follow)
        <a href="/profile/{{ $follow->userBeingFollowed->username }}" class="list-group-item list-group-item-action">
            <img class="avatar-tiny" src={{ $follow->userBeingFollowed->avatar }} />
            {{ $follow->userBeingFollowed->username }}
        </a>
    @endforeach
</div>
