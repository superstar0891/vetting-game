@extends('layouts.auth')

@section('content')

@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif
<div class="account-box">
    <form class="form-signin" method="POST" action="{{ route('password.email') }}">
        <div class="account-logo">
            <a href="#"><img src="{{ asset('assets/img/logo.png')}}" alt=""></a>
        </div>
        @csrf
        
        <div class="form-group">
            <label>Enter Your Email</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group text-center">
            <button class="btn btn-primary account-btn" type="submit">Reset Password</button>
        </div>
        <div class="text-center register-link">
            <a href="{{ route('login') }}">Back to Login</a>
        </div>
    </form>
</div>

@endsection
