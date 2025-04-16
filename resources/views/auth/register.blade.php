@extends('layouts.auth')

@section('content')
<div class="auth-container">
    <div class="logo">
        <img src="{{ asset('img/logo.png') }}" alt="Logo">
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
            <label for="name" class="form-label">Nome</label>
            <input id="name" type="text" class="form-input" name="name" value="{{ old('name') }}" required autofocus placeholder="Digite seu nome">
            @error('name')
                <span class="error" style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="email" class="form-label">E-mail</label>
            <input id="email" type="email" class="form-input" name="email" value="{{ old('email') }}" required placeholder="Digite seu e-mail">
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

        <div class="form-group">
            <label for="password_confirmation" class="form-label">Confirme a Senha</label>
            <input id="password_confirmation" type="password" class="form-input" name="password_confirmation" required placeholder="Confirme sua senha">
        </div>

        <button type="submit" class="btn btn-primary">
            Cadastrar
        </button>

        <div class="register-link">
            Já possui uma conta? <a href="{{ route('login') }}">Acessar</a>
        </div>

        <div class="terms">
            <a href="#">Termos de uso & Políticas de Privacidade</a>
        </div>
    </form>
</div>
@endsection
