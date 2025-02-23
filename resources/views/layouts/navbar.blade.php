<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta name="csrf-token" content="{{ csrf_token() }}">

<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- Meta tag CSRF -->
     <!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <title>Sistema de Abrigos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin-top: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #28a745; /* Cor de fundo verde */
            color: #fff;
             display: flex;
            /* flex-direction: column;
            align-items: center; */
            justify-content: center; 
            min-height: 100vh; /* Garante que ocupe toda a altura da tela */
        }
        .navbar-custom {
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 100%; /* Navbar ocupa toda a largura */
            position: fixed; /* Fixa no topo */
            top: 0;
            z-index: 1000; /* Garante que fique acima de outros elementos */
        }

        .navbar-custom .navbar-brand,
        .navbar-custom .nav-link {
            color: black;
        }

        .navbar-custom .nav-link:hover {
            color: #28a745; /* Verde ao passar o mouse */
        }

        .logout-btn {
            background-color: #dc3545; /* Vermelho para o botão de logout */
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .logout-btn:hover {
            background-color: #c82333; /* Vermelho mais escuro ao passar o mouse */
        }

        .content {
    margin-top: 80px; /* Ajuste conforme necessário para descer após a navbar */
    width: 100%;
    max-width: 1200px;
    padding: 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
}


        .card-custom {
            background: white;
            border-radius: 10px;
            padding: 20px;
            width: 100%;
            max-width: 600px; /* Largura máxima dos cards */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px;
        }

        .card-custom h2 {
            color: #28a745; /* Verde para o título */
            margin-bottom: 20px;
        }

        .card-custom input,
        .card-custom select,
        .card-custom button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .card-custom button {
            background-color: #28a745; /* Verde para o botão */
            color: white;
            border: none;
            cursor: pointer;
        }

        .card-custom button:hover {
            background-color: #218838; /* Verde mais escuro ao passar o mouse */
        }

        footer {
            width: 100%;
            text-align: center;
            padding: 10px;
            background-color: white;
            color: black;
            position: fixed;
            bottom: 0;
        }
        
    </style>

</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom p-3">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">SOS Clima</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="/home">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="/home/voluntario">Area do administrador</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Contato</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('abrigos.prioridades') }}">Prioridades dos Abrigos</a></li>
                </ul>
                <button class="btn btn-danger logout-btn" onclick="logout()">Logout</button>
            </div>
        </div>
    </nav>

    <!-- Conteúdo Centralizado -->
    <div class="content">
        @yield('content') <!-- Aqui será injetado o conteúdo das views que estenderem este layout -->
    </div>

    <footer>
        &copy; 2025 Sistema de gestão de dados para crise climática
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function logout() {
        // Exibir alerta de confirmação antes de fazer logout
        Swal.fire({
            title: 'Você tem certeza?',
            text: "Você será desconectado!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sim, logout!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Realizar logout via axios
                axios.post('/logout')
                    .then(response => {
                        window.location.href = '/';
                    })
                    .catch(error => {
                        Swal.fire(
                            'Erro!',
                            'Ocorreu um erro ao tentar fazer logout.',
                            'error'
                        );
                    });
            }
        });
    }
</script>
</body>
</html>
