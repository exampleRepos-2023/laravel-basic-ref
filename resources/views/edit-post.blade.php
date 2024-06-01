<x-layout>
    <div class="container py-md-5 container--narrow">
        <form action="/post/{{ $post->id }}" method="POST">
            <p><small><strong><a href="/post/{{ $post->id }}">&laquo; Back to post permalink</a></strong></small></p>
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="post-title" class="text-muted mb-1"><small>Title</small></label>
                <input required name="title" id="post-title" class="form-control form-control-lg form-control-title"
                    type="text" value='{{ old('title', $post->title) }}' placeholder="" autocomplete="off" />
                @error('title')
                    <p class="alert m-0 small shadow-sm alert-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="post-body" class="text-muted mb-1"><small>Body Content</small></label>
                <textarea required name="body" id="post-body" class="body-content tall-textarea form-control"
                    type="text"> {{ old('body', $post->body) }} </textarea>
                @error('body')
                    <p class="alert m-0 small shadow-sm alert-danger">{{ $message }}</p>
                @enderror
            </div>

            <button class="btn btn-primary">Save New Post</button>
        </form>
    </div>
</x-layout>
