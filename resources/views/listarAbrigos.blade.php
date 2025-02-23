<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Abrigos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .search-container {
            display: flex;
            justify-content: center;
            width: 100%;
        }
        label {
            display: block;
        }
        #searchInput {
            width: 50%; /* Ajuste este valor conforme necessário */
            max-width: 400px; /* Limite máximo para não ficar muito grande */
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #28a745;
            color: #fff;
            text-align: center;
        }

        .container-listar-abrigos {
            display: flex;
            flex-direction: column; 
            align-items: center; 
            padding: 20px;
        }

        .title {
            margin-bottom: 20px;
        }

        #abrigos-cards {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            max-width: 1200px; 
            margin: 0 auto;
        }

        .card {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            color: black; 
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin: 10px;
            padding: 20px;
            width: 250px;
            transition: transform 0.2s;
            position: relative; 
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card h2 {
            font-size: 20px;
            margin: 0;
        }

        .card p {
            margin: 5px 0;
        }

        .status-indicator {
            width: 15px;
            height: 15px;
            border-radius: 50%;
            display: inline-block; 
            margin-left: 5px;
            vertical-align: middle; 
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

        .edit-btn {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        .edit-btn:hover {
            background-color: #0056b3;
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
                <li class="nav-item"><a class="nav-link" href="/home/voluntario">Área do Administrador</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Contato</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('abrigos.prioridades') }}">Prioridades dos Abrigos</a></li>
            </ul>
            <button class="btn btn-danger logout-btn" onclick="logout()">Logout</button>
        </div>
    </div>
</nav>

<div class="container-listar-abrigos">
    <div class="title">
        <h1>Ajuda Emergencial</h1>
        <p>Apoie as vítimas de desastres naturais. Sua ajuda faz a diferença.</p>
    </div>
    <div class="search-container">
        <input type="text" id="searchInput" placeholder="Buscar por nome, cidade ou estado..." onkeyup="fetchAbrigos()" class="form-control mb-3">
    </div>
    
    <div id="abrigos-cards">
        <!-- Os cards serão inseridos aqui -->
    </div>
    
    <div class="pagination">
        <button id="prevPage" onclick="changePage(-1)" class="btn btn-primary">Anterior</button>
        <span id="pageInfo"></span>
        <button id="nextPage" onclick="changePage(1)" class="btn btn-primary">Próximo</button>
    </div>
</div>

<!-- Modal para editar abrigo -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-black" id="editModalLabel">Editar Abrigo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body ">
                <form id="editForm">
                <input  type="hidden" id="pk_abrigo" name="pk_abrigo" /> <!-- Campo oculto para o ID do abrigo -->

                    <div class="mb-3">
                        <label for="nome" class=" text-start text-black">Nome</label>
                        <input type="text" class="form-control" id="nome">
                    </div>
                    <div class="mb-3">
                        <label for="numero" class="text-start text-black">Número</label>
                        <input type="text" class="form-control" id="numero">
                    </div>
                    <div class="mb-3">
                        <label for="estado" class="text-start text-black">Estado</label>
                        <input type="text" class="form-control" id="estado">
                    </div>
                    <div class="mb-3">
                        <label for="telefone" class="text-start text-black">Telefone</label>
                        <input type="text" class="form-control" id="telefone">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="text-start text-black">Email</label>
                        <input type="email" class="form-control" id="email">
                    </div>
                    <div class="mb-3">
                        <label for="capacidade_maxima" class="text-start text-black text-black">Capacidade Máxima</label>
                        <input type="number" class="form-control" id="capacidade_maxima">
                    </div>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </form>
            </div>
        </div>
    </div>
</div>

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

    let currentPage = 1;
    const isAdmin = {!! json_encode(session('is_admin', false)) !!};

    function fetchAbrigos() {
        const search = document.getElementById('searchInput').value;
        
        axios.get(`/abrigos?search=${search}&page=${currentPage}`)
            .then(response => {
                const data = response.data;
                const abrigos = data.data; // Laravel retorna os dados dentro de 'data'
                const cardContainer = document.getElementById('abrigos-cards');
                cardContainer.innerHTML = "";
                
                abrigos.forEach(abrigo => {
                    const statusColor = abrigo.statusColor;
                    let editButton = '';

                    if (isAdmin) {
                        editButton = `<button class="edit-btn" onclick="editAbrigo(${abrigo.pk_abrigo})">Editar</button>`;
                    }


    const card = `<div class="card" data-id="${abrigo.pk_abrigo}">                        <h2>${abrigo.nome}</h2>
                        <p><strong>Rua:</strong> ${abrigo.rua}, Nº ${abrigo.numero}</p>
                        <p><strong>Cidade:</strong> ${abrigo.cidade} - ${abrigo.estado}</p>
                        <p><strong>Telefone:</strong> ${abrigo.telefone || '-'}</p>
                        <p><strong>Email:</strong> ${abrigo.email || '-'}</p>
                        <p><strong>Capacidade Máxima:</strong> ${abrigo.capacidade_maxima || '-'}</p>
                        <p><strong>Status:</strong> 
                            <span class="status-indicator" style="background-color: ${statusColor};"></span>
                        </p>
                        ${editButton}
                    </div>`;
                    
                    cardContainer.innerHTML += card;
                });
                
                // Atualizar a informação da página
                document.getElementById('pageInfo').textContent = `Página ${currentPage} de ${data.last_page}`;
                document.getElementById('prevPage').disabled = currentPage === 1;
                document.getElementById('nextPage').disabled = currentPage === data.last_page;
            })
            .catch(error => console.log(error));
    }

    function changePage(direction) {
        currentPage += direction;
        fetchAbrigos();
    }

    function editAbrigo(id) {
        // Fazer uma requisição para obter os dados do abrigo
        axios.get(`/abrigos/${id}`)
            .then(response => {
                const abrigo = response.data;
                
                // Preencher o formulário de edição com os dados do abrigo
                document.getElementById('nome').value = abrigo.nome;
                document.getElementById('numero').value = abrigo.numero;
                document.getElementById('estado').value = abrigo.estado;
                document.getElementById('telefone').value = abrigo.telefone;
                document.getElementById('email').value = abrigo.email;
                document.getElementById('capacidade_maxima').value = abrigo.capacidade_maxima;
                document.getElementById('pk_abrigo').value = id;

                // Exibir o modal de edição
                new bootstrap.Modal(document.getElementById('editModal')).show();
            })
            .catch(error => console.log(error));
    }

    document.getElementById('editForm').addEventListener('submit', function (e) {
    e.preventDefault();

    // Pegando o ID do abrigo (supondo que está armazenado em um atributo data do modal)
    const id = document.getElementById('pk_abrigo').value;
    // Pegando os valores do formulário
    const nome = document.getElementById('nome').value.trim();
    const numero = document.getElementById('numero').value.trim();
    const estado = document.getElementById('estado').value.trim();
    const telefone = document.getElementById('telefone').value.trim();
    const email = document.getElementById('email').value.trim();
    const capacidade_maxima = document.getElementById('capacidade_maxima').value.trim();

    // Garantir que os campos vazios mantenham os valores originais
    axios.get(`/abrigos/${id}`).then(response => {
        const abrigo = response.data;

        const data = {
            nome: nome || abrigo.nome,
            numero: numero || abrigo.numero,
            estado: estado || abrigo.estado,
            telefone: telefone || abrigo.telefone,
            email: email || abrigo.email,
            capacidade_maxima: capacidade_maxima || abrigo.capacidade_maxima
        };

        // Enviar a requisição PUT com os dados atualizados
        axios.put(`/abrigos/${id}`, data)
            .then(response => {
                // Exibir alerta de sucesso com SweetAlert
                Swal.fire({
                    title: 'Sucesso!',
                    text: 'Abrigo atualizado com sucesso.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    // Fechar o modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('editModal'));
                    modal.hide();

                    // Atualizar a lista de abrigos
                    fetchAbrigos();
                });
            })
            .catch(error => {
                console.error('Erro ao atualizar abrigo:', error);
                Swal.fire({
                    title: 'Erro!',
                    text: 'Ocorreu um erro ao atualizar o abrigo.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
    }).catch(error => console.error('Erro ao buscar abrigo:', error));
});



    // Chama o fetch de abrigos ao carregar a página
    fetchAbrigos();
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
