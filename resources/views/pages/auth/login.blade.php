@extends('layouts.auth-layout')

@section('content')
<div class="card-body p-4">
    <div class="text-center mt-2">
        <h5 class="text-primary">Toy Store</h5>
    </div>
    <div class="p-2 mt-4">
        <form action="{{ route('login.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" name="email" id="email" value="{{ old('email') }}" placeholder="Enter email" autocomplete="current-email">
                <small class="text-danger">{{ $errors->first('email') }}</small>
            </div>

            <div class="mb-3">
                <div class="float-end">
                    <a href="{{ route('forgot') }}" class="text-muted">Forgot password?</a>
                </div>
                <label class="form-label" for="password-input">Password</label>
                <div class="position-relative auth-pass-inputgroup mb-3">
                    <input type="password" class="form-control pe-5 password-input" name="password" placeholder="Enter password" id="password-input" autocomplete="current-password">
                    <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                </div>
                <small class="text-danger">{{ $errors->first('password') }}</small>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="auth-remember-check">
                <label class="form-check-label" for="auth-remember-check">Remember me</label>
            </div>

            <div class="mt-4">
                <button class="btn btn-success w-100" type="submit">Sign In</button>
            </div>
        </form>
    </div>
</div>
@endsection
