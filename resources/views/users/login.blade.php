@include('base.base')
@include('base.nav')

<div class="container">
    <br>
    <h1>Login</h1>
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
    <form action="/login" method="POST">
        @csrf
        <div class="form-group">
            <label for="email">E-Mail Address</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}"/>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" />
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
