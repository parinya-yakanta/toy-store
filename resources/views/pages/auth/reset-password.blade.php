@extends('layouts.auth-layout')

@section('content')
<div class="card-body p-4">
    <div class="text-center mt-2">
        <h5 class="text-primary">You reset a new password.</h5>
    </div>
    <div>
        @if (Session::has('fail'))
            <div class="alert alert-danger">{{ Session::get('fail') }}</div>
        @endif
    </div>
    <div class="p-2 mt-4">
        <form action="{{ route('auth.reset.password.store') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" name="email" id="email" value="{{ $email }}" placeholder="Enter email">
                <small class="text-danger">{{ $errors->first('email') }}</small>
            </div>

            <div class="mb-3">
                <label class="form-label" for="password-input">Password</label>
                <div class="position-relative auth-pass-inputgroup mb-3">
                    <input type="password" class="form-control pe-5 password-input" name="password" placeholder="Enter password"
                        id="password-input">
                    <button
                        class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                        type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                </div>
                <small class="text-danger">{{ $errors->first('password') }}</small>
            </div>

            <div class="mb-3">
                <label class="form-label" for="password-input">Confirm Password</label>
                <div class="position-relative auth-pass-inputgroup mb-3">
                    <input type="password" class="form-control pe-5 password-input" name="password_confirmation" placeholder="Enter password"
                        id="password-input">
                    <button
                        class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                        type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                </div>
                <small class="text-danger">{{ $errors->first('password_confirmation') }}</small>
            </div>

            <div class="mt-4">
                <button class="btn btn-success w-100" type="submit">Reset Password</button>
            </div>
        </form>
    </div>
</div>
@endsection
