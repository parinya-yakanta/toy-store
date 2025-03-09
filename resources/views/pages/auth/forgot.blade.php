@extends('layouts.auth-layout')

@section('content')
<div class="card-body p-4">
    <div class="text-center mt-2">
        <h5 class="text-primary">Forget Password</h5>
    </div>
    <div>
        @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
        @endif
        @if (Session::has('fail'))
        <div class="alert alert-danger">{{ Session::get('fail') }}</div>
        @endif
    </div>
    <div class="p-2 mt-4">
        <form action="{{ route('forgot.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" name="email" id="email" value="{{ old('email') }}" placeholder="Enter email" autocomplete="current-email">
                <small class="text-danger">{{ $errors->first('email') }}</small>
            </div>

            <div class="mt-4">
                <button class="btn btn-success w-100" type="submit">Request new password</button>
            </div>
        </form>
    </div>
    <a href="{{ route('login') }}" class="p-2 mt-4">go to login.</a>
</div>
@endsection
