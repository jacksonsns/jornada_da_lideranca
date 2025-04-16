@extends('layouts.auth')

@section('content')
<div class="auth-container">
    <div class="logo">
        <img src="{{ asset('img/logo.png') }}" alt="Logo">
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label for="email" class="form-label">E-mail</label>
            <input id="email" type="email" class="form-input" name="email" value="{{ old('email') }}" required autofocus placeholder="Digite seu e-mail">
            @error('email')
                <span class="error" style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password" class="form-label">Senha</label>
            <input id="password" type="password" class="form-input" name="password" required placeholder="Digite sua senha">
            @error('password')
                <span class="error" style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span>
            @enderror
        </div>

        <div class="remember-forgot">
            <label class="remember-me">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <span>Mantenha-me conectado</span>
            </label>

            @if (Route::has('password.request'))
                <a class="forgot-password" href="{{ route('password.request') }}">
                    Esqueci a senha
                </a>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">
            Acessar
        </button>

        <div class="register-link">
            Não possui uma conta? <a href="{{ route('register') }}">Cadastrar</a>
        </div>

        <div class="terms">
            <a href="#">Termos de uso & Políticas de Privacidade</a>
        </div>
    </form>
</div>
@endsection
