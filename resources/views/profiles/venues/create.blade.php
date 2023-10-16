@include('base.base')
@include('base.nav')
<div class="container">
    <h1>Create Venue Profile</h1>
    <form action="/venues" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name</label><span class="text-danger"> *</span>
            <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" name="description" id="description" cols="30" rows="10">{{ old('description') }}</textarea>
        </div>
        <div class="form-group">
            <label for="street">Street</label><span class="text-danger"> *</span>
            <input class="form-control" type="text" name="street" id="street" value="{{ old('street') }}">
        </div>
        <div class="form-group">
            <label for="number">Number</label><span class="text-danger"> *</span>
            <input class="form-control" type="text" name="number" id="number" value="{{ old('number') }}">
        </div>
        <div class="form-group">
            <label for="zip">ZIP</label><span class="text-danger"> *</span>
            <input class="form-control" type="number" name="zip" id="zip" value="{{ old('zip') }}">
        </div>
        <div class="form-group">
            <label for="city">City</label><span class="text-danger"> *</span>
            <input class="form-control" type="text" name="city" id="city" value="{{ old('city') }}">
        </div>
        <div class="form-group">
            <label for="website">Website</label>
            <input class="form-control" type="text" name="website" id="website" value="{{ old('website') }}">
        </div>
        <input type="hidden" name="tag" id="tag" value="s">
        <input type="submit" class="btn btn-primary" value="Submit" />
    </form>
</div>
