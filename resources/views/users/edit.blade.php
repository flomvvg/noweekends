@include('base.base')
@include('base.nav')
<div class="container">
    <br>
    <h1>Edit User</h1>
    <br>
    <form action="/users/{{ $user->id }}" method="POST">
        @method('PATCH')
        @csrf
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" class="form-control" value="{{ $user->username }}"/>
        </div>
        <button type="submit" class="d-inline btn btn-primary float-end">Submit</button>
    </form>
    <form action="/users/{{ $user->id }}">
        @method('DELETE')
        <input type="submit" class="btn btn-danger " value="Delete User"/>
    </form>

</div>
