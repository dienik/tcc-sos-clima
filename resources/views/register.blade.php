<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-vindo</title>
    <link rel="stylesheet" href="css/index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">

</head>
<body>
    <div class="left-half">
        <img src="https://imagens.ebc.com.br/jcYYTVffunDKCmyZVKarpo1744Q=/1170x700/smart/https://agenciabrasil.ebc.com.br/sites/default/files/thumbnails/image/2024/05/05/53700836959_11ef9d9e77_o_0.jpg?itok=XxMk8rTg" alt="Chuvas no RS" class="gif-image">
    </div>
    <div class="right-half">
        <div class="container-index">
           
        </div>
        
        <!-- Área onde os formulários serão carregados -->
        <div class="formContainer">

        <a class="mdi mdi-home" href="/">Voltar</a>

        <div class="form-container1">
       

    <h2 >Cadastro</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('register.store') }}" method="POST">
    @csrf
    
    <div class="form-group">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="{{ old('nome') }}" required>

        <label for="sobrenome">Sobrenome:</label>
        <input type="text" id="sobrenome" name="sobrenome" value="{{ old('sobrenome') }}" required>
    </div>

    <div class="form-group ">
        <label for="telefone">Telefone:</label>
        <input type="tel" id="telefone" name="telefone" value="{{ old('telefone') }}" required>

        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
    </div>

    <div class="form-group">
        <label for="senha">Senha:</label>
        <input type="password" id="password" name="password" required>

        <label for="password_confirmation">Confirmar Senha:</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required>
    </div>

  
    <button type="submit">Cadastrar</button>
</form>

</div>

        </div>
    </div>

    <script src="js/index.js"></script>
</body>
</html>




