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

    <h1>Create Venue Profile</h1>
    <form action="/venues" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" name="description" id="description" cols="30" rows="10">{{ old('description') }}</textarea>
        </div>
        <div class="form-group">
            <label for="street">Street</label>
            <input class="form-control" type="text" name="street" id="street" value="{{ old('street') }}">
        </div>
        <div class="form-group">
            <label for="number">Number</label>
            <input class="form-control" type="text" name="number" id="number" value="{{ old('number') }}">
        </div>
        <div class="form-group">
            <label for="zip">ZIP</label>
            <input class="form-control" type="number" name="zip" id="zip" value="{{ old('zip') }}">
        </div>
        <div class="form-group">
            <label for="city">City</label>
            <input class="form-control" type="text" name="city" id="city" value="{{ old('city') }}">
        </div>
        <div class="form-group">
            <label for="website">Website</label>
            <input class="form-control" type="text" name="website" id="website" value="{{ old('website') }}">
        </div>
        <input type="hidden" name="tag" id="tag" value="test">
        <input type="submit" class="btn btn-primary" value="Submit" />
    </form>
</div>
