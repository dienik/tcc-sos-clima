<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


    <style>
            footer {
            width: 100%;
            text-align: center;
            padding: 10px;
            background-color: white;
            color: black;
            position: fixed;
            bottom: 0;
        }
        .card button a {
    color: white;
    text-decoration: none;
    display: block; /* Faz o link ocupar todo o botão */
    width: 100%;
    height: 100%;
}
        body {
     margin: 0;
     padding: 0;
     font-family: Arial, sans-serif;
     background-color: #28a745;
     color: #fff;
   
     
        }
        .header-home {
     margin-bottom: 50px;
 }

 .header-home h1 {
     font-size: 3em;
     margin: 0;
     display: flex;
     justify-content: center;
     align-items: center;
 }

 .header-home p {
     font-size: 1.2em;
     display: flex;
     justify-content: center;
     align-items: center;
 
 }

 .cards-home {
     display: flex;
     flex-wrap: wrap;
     justify-content: center;
     gap: 20px;
 }
 .card {
     background:white;
     border-radius: 10px;
     padding: 20px;
     width: 250px;
     box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
     transition: transform 0.3s, box-shadow 0.3s;
 }

 .card:hover {
     transform: translateY(-10px);
     box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
 }

 .card h2 {
     font-size: 1.5em;
     margin-bottom: 10px;
 }

 .card p {
     font-size: 1em;
     margin-bottom: 20px;
 }

 .card button {
     background: #4caf50;
     color: white;
     border: none;
     padding: 10px 20px;
     border-radius: 5px;
     cursor: pointer;
     font-size: 1em;
 }

 .card button:hover {
     background: #45a049;
 }
        .container-form {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            width: 50%;
            margin: auto;
            margin-top: 100px;
        }
        .navbar-custom {
            background-color: white;
        }
        .navbar-custom .nav-link {
            color: black;
        }
        .logout-btn {
            position: absolute;
            right: 20px;
        }
    </style>
   
   
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom p-3">
        <div class="container">
            <a class="navbar-brand" href="#">SOS Clima</a>
            <div class="collapse navbar-collapse">
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
    
    <div class="header-home">
            <h1>Ajuda Emergencial</h1>
            <p>Apoie as vítimas de desastres naturais. Sua ajuda faz a diferença.</p>
        </div>
        <div class="cards-home">
            <div class="card">
                <h2>Cadastrar Pessoas</h2>
                <p>Registre informações de pessoas que precisam de ajuda.</p>
                <button class="text-white"><a href="/abrigado/cadastrar">Cadastrar</a></button>
            </div>
            <div class="card">
                <h2>Cadastrar Abrigos</h2>
                <p>Informe a localização e detalhes de novos abrigos disponíveis.</p>
                <button><a href="/abrigo/create">Cadastrar</a></button>
            </div>
            <div class="card">
                <h2>Cadastrar Item recebido em abrigo</h2>
                <p>Atribuição de item a abrigo</p>
                <button><a href="/cadastrar/itemAbrigo">Cadastrar</a></button>
            </div>
            <div class="card">
                <h2>Receber Doação</h2>
                <p>Cadastro de doação recebida</p>
                <button><a href="/voluntario/doacao">Cadastrar</a></button>
            </div>
            <div class="card">
                <h2>Cadastrar Prioridades</h2>
                <p>Cadastro de prioridades em abrigos</p>
                <button><a href="/prioridades">Cadastrar</a></button>
            </div>
        </div>
    </div>
    <footer>
        &copy; 2025 Sistema de gestão de dados para crise climática
    </footer>
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
                        // Redireciona para a página inicial após o logout
                        window.location.href = '/';
                    })
                    .catch(error => {
                        // Caso haja erro
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
