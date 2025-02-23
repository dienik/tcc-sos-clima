

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Abrigo</title>
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
        body {
            background-color: #28a745;
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
    <script>
        document.getElementById('abrigoForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Impede o envio padrão do formulário

        let formData = new FormData(this);

        fetch("{{ route('abrigo.store') }}", {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                Swal.fire({
                    title: "Sucesso!",
                    text: data.message,
                    icon: "success",
                    confirmButtonText: "OK"
                }).then(() => {
                    window.location.reload(); // Recarrega a página após o alerta
                });
            }
        })
        .catch(error => {
            console.error("Erro ao cadastrar abrigo:", error);
            Swal.fire({
                title: "Erro!",
                text: "Não foi possível cadastrar o abrigo.",
                icon: "error"
            });
        });
    });
        function autoPreencherCEP() {
            const cep = document.getElementById('cep').value;
            if (cep.length === 8 || cep.length === 9) {
                fetch(`https://viacep.com.br/ws/${cep}/json/`)
                    .then(response => response.json())
                    .then(data => {
                        if (!data.erro) {
                            document.getElementById('rua').value = data.logradouro || '';
                            document.getElementById('cidade').value = data.localidade || '';
                            document.getElementById('estado').value = data.uf || '';
                        } else {
                            alert('CEP não encontrado!');
                        }
                    })
                    .catch(error => console.error('Erro ao buscar CEP:', error));
            } else {
                alert('Digite um CEP válido!');
            }
        }
    </script>
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
    
    <div class="container-form">
        <h2 class="text-center">Cadastrar Abrigo</h2>
        <form action="{{ route('abrigo.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            <div class="mb-3 d-flex">
                <div class="me-2">
                    <label for="cep" class="form-label">CEP</label>
                    <input type="text" class="form-control" id="cep" name="cep" required>
                </div>
                <div class="align-self-end">
                    <button type="button" class="bg-#28a745" onclick="autoPreencherCEP()">Auto Preencher</button>
                </div>
            </div>
            <div class="mb-3">
                <label for="rua" class="form-label">Rua</label>
                <input type="text" class="form-control" id="rua" name="rua" required>
            </div>
            <div class="mb-3">
                <label for="numero" class="form-label">Número</label>
                <input type="text" class="form-control" id="numero" name="numero" required>
            </div>
            <div class="mb-3">
                <label for="cidade" class="form-label">Cidade</label>
                <input type="text" class="form-control" id="cidade" name="cidade" required>
            </div>
            <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <input type="text" class="form-control" id="estado" name="estado" maxlength="2" required>
            </div>
            <div class="mb-3">
                <label for="telefone" class="form-label">Telefone</label>
                <input type="text" class="form-control" id="telefone" name="telefone">
            </div>
            <div class="mb-3">
                <label for="cnpj" class="form-label">CNPJ</label>
                <input type="text" class="form-control" id="cnpj" name="cnpj">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>
            <button type="submit" class="btn btn-primary w-100">Cadastrar</button>
        </form>
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
    }</script>
</body>
</html>
