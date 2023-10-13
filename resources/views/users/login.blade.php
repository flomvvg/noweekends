@include('base.base')
@include('base.nav')

<div class="container">
    <br>
    <h1>Login</h1>
    <br>
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
