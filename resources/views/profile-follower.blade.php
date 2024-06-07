<x-profile :sharedData="$sharedData">
    <div class="list-group">
        @foreach ($followers as $follow)
            <a href="/profile/{{ $follow->userDoingtFollowing->username }}" class="list-group-item list-group-item-action">
                <img class="avatar-tiny" src={{ $follow->userDoingtFollowing->avatar }} />
                {{ $follow->userDoingtFollowing->username }}
            </a>
        @endforeach
    </div>
</x-profile>
