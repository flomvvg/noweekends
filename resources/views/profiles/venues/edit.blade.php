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

    <h1>Edit Venue Profile</h1>
    <form action="/venues/{{ $venue->id }}" method="POST">
        @csrf @method('PATCH')
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ $venue->name }}">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" name="description" id="description" cols="30" rows="10">{{ $venue->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="street">Street</label>
            <input class="form-control" type="text" name="street" id="street" value="{{ $venue->street }}">
        </div>
        <div class="form-group">
            <label for="number">Number</label>
            <input class="form-control" type="text" name="number" id="number" value="{{ $venue->number }}">
        </div>
        <div class="form-group">
            <label for="zip">ZIP</label>
            <input class="form-control" type="number" name="zip" id="zip" value="{{ $venue->zip }}">
        </div>
        <div class="form-group">
            <label for="city">City</label>
            <input class="form-control" type="text" name="city" id="city" value="{{ $venue->city }}">
        </div>
        <div class="form-group">
            <label for="website">Website</label>
            <input class="form-control" type="text" name="website" id="website" value="{{ $venue->website }}">
        </div>
        <input type="submit" class="btn btn-primary" value="Submit" />
    </form>
</div>
