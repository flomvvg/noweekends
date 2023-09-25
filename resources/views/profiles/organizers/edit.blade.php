@include('base.base')
@include('base.nav')

<div class="container">
    <h1>Edit Organizer</h1>
    <form action="/organizers/{{ $organizer->id }}" method="POST">
        @method('PATCH')
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input class="form-control" type="text" name="name" id="name" value="{{ $organizer->name }}" />
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" name="description" id="description" cols="30" rows="10">{{ $organizer->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="website">Website</label>
            <input class="form-control" type="text" name="website" id="website">
        </div>
        <button class="d-inline-block btn btn-primary" type="submit" name="submit" id="submit">Submit</button>
        <form action="/organizers/{{ $organizer->id }}" METHOD="POST">
            @csrf @method('DELETE')
            <input class="btn btn-danger float-right" type="submit" name="submit" id="submit" value="Delete Profile">
        </form>
    </form>
</div>
