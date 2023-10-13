@include('base.base')
@include('base.nav')
<div class="container">
    <h1>Edit Artist Profile</h1>
        <form action="/artists/{{ $artist->id }}" method="POST">
        @csrf @method('PATCH')
        <div class="form-group">
            <label for="name">Name</label><span class="text-danger"> *</span>
            <input type="text" class="form-control" name="name" id="name" value="{{ $artist->name }}">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" name="description" id="description" cols="30" rows="10">{{ $artist->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="spotify">Spotify</label>
            <input class="form-control" type="text" name="spotify" id="spotify" value="{{ $artist->spotify }}">
        </div>
        <div class="form-group">
            <label for="soundcloud">Soundcloud</label>
            <input class="form-control" type="text" name="soundcloud" id="soundcloud" value="{{ $artist->soundcloud }}">
        </div>
        <div class="form-group">
            <label for="youtube">YouTube</label>
            <input class="form-control" type="text" name="youtube" id="youtube" value="{{ $artist->youtube }}">
        </div>
        <div class="form-group">
            <label for="amazon_music">Amazon Music</label>
            <input class="form-control" type="text" name="amazon_music" id="amazon_music" value="{{ $artist->amazon_music }}">
        </div>
        <div class="form-group">
            <label for="apple_music">Apple Music</label>
            <input class="form-control" type="text" name="apple_music" id="apple_music" value="{{ $artist->apple_music }}">
        </div>
        <div class="form-group">
            <label for="website">Website</label>
            <input class="form-control" type="text" name="website" id="website" value="{{ $artist->website }}">
        </div>
        <input type="submit" class="btn btn-primary float-end" value="Submit" />
    </form>
    <form action="/artists/{{ $artist->id }}" METHOD="POST">
        @csrf @method('DELETE')
        <input class="btn btn-danger" type="submit" name="submit" id="submit" value="Delete Profile">
    </form>
</div>
