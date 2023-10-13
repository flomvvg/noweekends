@include('base.base')
@include('base.nav')

<div class="container">
    @if($errors->any())
        @foreach($errors->all() as $error)
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ $error }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endforeach
    @endif

    <h1>Edit Organizer</h1>
    <form action="/organizers/{{ $organizer->id }}" method="POST">
        @csrf @method('PATCH')
        <div class="form-group">
            <label for="name">Name</label><span class="text-danger"> *</span>
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
        <button class="btn btn-primary float-end" type="submit" name="submit" id="submit">Submit</button>
    </form>
    <form action="/organizers/{{ $organizer->id }}" METHOD="POST">
        @csrf @method('DELETE')
        <input class="btn btn-danger" type="submit" name="submit" id="submit" value="Delete Profile">
    </form>
</div>
