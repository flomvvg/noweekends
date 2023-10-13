@include('base.base')
@include('base.nav')
<div class="container">
    <h1>Create User</h1>
    <br>
    <form action="/users" method="POST">
        @csrf
        <div class="form-group">
            <label for="email">E-Mail Address</label><span class="text-danger"> *</span>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}"/>
        </div>
        <div class="form-group">
            <label for="username">Username</label><span class="text-danger"> *</span>
            <input type="text" name="username" id="username" class="form-control" value="{{ old('username') }}"/>
        </div>
        <div class="form-group">
            <label for="password">Password</label><span class="text-danger"> *</span>
            <input type="password" name="password" id="password" class="form-control" />
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
