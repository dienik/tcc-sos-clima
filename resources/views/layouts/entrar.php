@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="container-login">
    <div class="form-container-login">
        <h1>Login</h1>
        <form action="{{ route('login') }}" method="POST">
            @csrf

            <!-- E-mail -->
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>

            <!-- Senha -->
            <label for="password">Senha:</label>
            <input type="password" id="password" name="password" required>

            <!-- Botão de Login -->
            <button type="submit">Entrar</button>
        </form>
    </div>
</div>
@endsection