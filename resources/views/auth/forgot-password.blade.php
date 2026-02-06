@extends('layouts.auth')

@section('content')
<div class="auth-container">
    <div class="logo">
        <img src="{{ asset('img/negocios-logo.jpeg') }}" alt="Logo">
    </div>

    @if (session('status'))
        <div class="mb-3" style="font-size: 0.9rem; color: #bbf7d0; background: rgba(22,163,74,0.2); border-radius: 999px; padding: 0.6rem 1rem; border: 1px solid rgba(34,197,94,0.6); text-align: center;">
            {{ session('status') }}
        </div>
    @endif

    <div class="mb-4" style="font-size: 0.88rem; color: rgba(209,213,219,0.9);">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="form-group">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input id="email" type="email" class="form-input" name="email" value="{{ old('email') }}" required autofocus placeholder="Digite seu e-mail">
            @error('email')
                <span class="error" style="color: #fecaca; font-size: 0.875rem; display:block; margin-top:0.25rem;">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">
            {{ __('Email Password Reset Link') }}
        </button>
    </form>
</div>
@endsection
