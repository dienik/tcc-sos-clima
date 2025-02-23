<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">

</head>
<body>
    <div class="left-half">
        <img src="https://imagens.ebc.com.br/jcYYTVffunDKCmyZVKarpo1744Q=/1170x700/smart/https://agenciabrasil.ebc.com.br/sites/default/files/thumbnails/image/2024/05/05/53700836959_11ef9d9e77_o_0.jpg?itok=XxMk8rTg" alt="Chuvas no RS" class="gif-image">
    </div>
    <div class="right-half">
        <div class="form-container">
        <a class="mdi mdi-home" href="/">Voltar</a>
            <h2>Login</h2>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf

                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>

                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" required>

                <button type="submit">Entrar</button>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/index.js') }}"></script>
</body>
</html>
