@include('base.base')
@include('base.nav')
<div class="container">
    <h1>Create User</h1>
    <br>
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
