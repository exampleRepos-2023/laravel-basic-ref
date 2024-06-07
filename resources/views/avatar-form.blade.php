x-<x-layout doctitle="Upload Avatar">
    <div class="container py-md-5 container--narrow">
        <h2 class='mb-4 text-center'>
            <img class="avatar-small" src="https://gravatar.com/avatar/b9408a09298632b5151200f3449434ef?s=128" />
            Upload a New Avatar
        </h2>
        <form action="/manage-avatar" method="POST" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-4">
                <label for="avatar">Change avatar</label>
                <input type="file" name="avatar" id="avatar" class="form-control-file">
                @error('avatar')
                    <span class="small alert-danger shadow-sm">{{ $message }}</span>
                @enderror
            </div>
            <input type="submit" value="Upload" class="btn btn-primary">
        </form>
    </div>
</x-layout>
