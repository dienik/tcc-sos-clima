@extends('layouts.navbar')

@section('content')

<head>
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
      label {
        display: block;
    }
    body {
        font-family: Arial, sans-serif;
        background-color: #28a745;
        color: #fff;
        text-align: center;
        margin: 0; /* Remove a margem padrão */
        padding: 0; /* Remove o padding padrão */
    }
    .container {
        padding-top: 20px; /* Ajusta o espaçamento do topo */
    }
    .header-home {
        margin-bottom: 50px;
    }
    .table-container {
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        display: inline-block;
        width: 80%;
        margin: 0 auto;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    th, td {
        border: 1px solid #28a745;
        padding: 10px;
        text-align: left;
        color: black;
    }
    th {
        background-color: #f8f9fa;
    }
    tr:nth-child(even) {
        background-color: #eafaf2; /* Verde claro para as linhas pares */
    }
    tr:nth-child(odd) {
        background-color: #ffffff; /* Branco para as linhas ímpares */
    }
    input {
        width: 100%;
        padding: 5px;
        border: 1px solid black;
        border-radius: 5px;
    }
    .edit-btn {
        cursor: pointer;
        background-color: transparent;
        border: none;
        color: #007bff;
    }
    .save-btn {
        background-color: #007bff;
        color: white;
        padding: 10px;
        border: none;
        cursor: pointer;
        border-radius: 5px;
        margin-top: 10px;
    }
</style>
</head>

<body>
    <div class="container">
        <h1>Lista de Abrigados</h1>
        <div class="table-container">
            <input type="text" id="searchInput" placeholder="Buscar por nome, sobrenome ou cidade..." onkeyup="fetchAbrigados()">
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Sobrenome</th>
                        <th>Abrigo</th>
                        <th>Cidade de Origem</th>
                        <th>Telefone</th>
                        <th>Data de Entrada</th>
                        <th>Data de Saída</th>
                        @if(session('is_admin', false))
                         <th>Ações</th>
                        @endif
                    </tr>
                </thead>
                <tbody id="abrigadoTableBody"></tbody>
            </table>
        </div>
    </div>

    <!-- Modal para editar -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-black" id="editModalLabel">Editar Abrigado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form id="editForm">
                        <div class="mb-3">
                            <label for="editNome" class="text-start text-black">Nome</label>
                            <input type="text" class="form-control" id="editNome">
                        </div>
                        <div class="mb-3">
                            <label for="editSobrenome" class="text-start text-black">Sobrenome</label>
                            <input type="text" class="form-control" id="editSobrenome">
                        </div>
                        <div class="mb-3">
                            <label for="editCidadeOrigem" class="text-start text-black">Cidade de Origem</label>
                            <input type="text" class="form-control" id="editCidadeOrigem">
                        </div>
                        <div class="mb-3">
                            <label for="editTelefone" class="text-start text-black">Telefone</label>
                            <input type="text" class="form-control" id="editTelefone">
                        </div>
                        <div class="mb-3">
                            <label for="editSaida" class="text-start text-black">Data de saída</label>
                            <input type="date" class="form-control" id="editSaida">
                        </div>
                        <div class="mb-3">
                            <label for="editComentario" class="text-start text-black">Comentário</label>
                            <input type="text" class="form-control" id="editComentario">
                        </div>
                        <button type="button" class="save-btn" id="saveChanges">Salvar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentPage = 1;
        const isAdmin = {!! json_encode(session('is_admin', false)) !!};
        let currentEditId = null;

        function fetchAbrigados() {
            const search = document.getElementById('searchInput').value;
            axios.get(`/abrigados?search=${search}&page=${currentPage}`)
                .then(response => {
                    const data = response.data;
                    const tableBody = document.getElementById('abrigadoTableBody');
                    tableBody.innerHTML = "";

                    data.data.forEach(abrigado => {
                        let row = `<tr>
                            <td>${abrigado.nome}</td>
                            <td>${abrigado.sobrenome}</td>
                            <td>${abrigado.nome_abrigo}</td>
                            <td>${abrigado.cidade_origem}</td>
                            <td>${abrigado.telefone || '-'}</td>
                            <td>${abrigado.data_entrada}</td>
                            <td>${abrigado.data_saida}</td>
                            ${isAdmin ? `<td><span class="edit-btn" onclick="openEditModal(${abrigado.pk_abrigado})">✏️ Editar</span></td>` : ''}
                        </tr>`;
                        tableBody.innerHTML += row;
                    });
                })
                .catch(error => console.error('Erro ao buscar abrigados:', error));
        }

        function openEditModal(id) {
            currentEditId = id;
            axios.get(`/abrigados/${id}`)
                .then(response => {
                    const abrigado = response.data;
                    document.getElementById('editNome').value = abrigado.nome;
                    document.getElementById('editSobrenome').value = abrigado.sobrenome;
                    document.getElementById('editCidadeOrigem').value = abrigado.cidade_origem;
                    document.getElementById('editTelefone').value = abrigado.telefone;
                    document.getElementById('editSaida').value = abrigado.data_saida;
                    document.getElementById('editComentario').value = abrigado.informacoes;

                    new bootstrap.Modal(document.getElementById('editModal')).show();
                })
                .catch(error => console.error('Erro ao abrir o modal:', error));
        }

        function saveModalChanges() {
            const data = {
                nome: document.getElementById('editNome').value,
                sobrenome: document.getElementById('editSobrenome').value,
                cidade_origem: document.getElementById('editCidadeOrigem').value,
                telefone: document.getElementById('editTelefone').value,
                data_saida: document.getElementById('editSaida').value,
                informacoes: document.getElementById('editComentario').value,
            };

            axios.put(`/abrigados/${currentEditId}`, data, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => {
                Swal.fire({
                    title: 'Sucesso!',
                    text: 'Edição salva com sucesso.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                
                    const modal = document.getElementById('editModal');
                    const modalInstance = bootstrap.Modal.getInstance(modal);
                    if (modalInstance) {
                    modalInstance.hide();
                }
                    fetchAbrigados();
                });
            })
            .catch(error => console.error('Erro ao salvar edição:', error));
        }
       
        document.getElementById('saveChanges').addEventListener('click', saveModalChanges);
        
        document.addEventListener("DOMContentLoaded", fetchAbrigados);
    </script>
</body>
@endsection
