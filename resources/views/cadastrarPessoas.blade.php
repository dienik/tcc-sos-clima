@extends('layouts.navbar')

@section('content')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


<div class="container mt-4">
    <div class="row">
        <!-- Card de Cadastro -->
        <div class="col-md-6">
            <div class="card p-4 shadow">
                <h2 class="text-center">Cadastrar uma Pessoa</h2>
                <form id="formCadastrarPessoa" action="{{ route('abrigado.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <input type="text" class="form-control" name="nome" placeholder="Nome" required>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" name="sobrenome" placeholder="Sobrenome" required>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" name="cidade_origem" placeholder="Cidade de origem" required>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" name="telefone" placeholder="Telefone">
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" name="itemPrioridade" placeholder="Item de Prioridade">
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" name="informacoes" placeholder="Comentário">
                    </div>
                    <div class="mb-3">
                        <label for="data_entrada" class="form-label">Data de Entrada:</label>
                        <input type="date" class="form-control" name="data_entrada">
                    </div>
                    <div class="mb-3">
                        <select class="form-select" name="fk_abrigo" id="abrigo" required>
                            <option value="">Selecione um abrigo</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Cadastrar</button>
                </form>
            </div>
        </div>

        <!-- Card de Upload -->
        <div class="col-md-6">
            <div class="card p-4 shadow">
                <h2 class="text-center">Upload de CSV</h2>
                <form id="formUploadCSV" action="{{ route('abrigado.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <input type="file" class="form-control" name="csv_file" accept=".csv" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Fazer Upload</button>
                </form>
                <div class="text-center mt-3">
                    <a href="{{ route('abrigado.downloadCSV') }}" class="btn btn-success w-100">Baixar CSV Exemplo</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Carregar abrigos no seletor
    fetch("{{ route('abrigo.listar') }}")
            .then(response => response.json())
            .then(data => {
                const selectAbrigo = document.getElementById('abrigo');
                data.forEach(abrigo => {
                    const option = document.createElement('option');
                    option.value = abrigo.pk_abrigo; // Valor deve ser a PK do abrigo
                    option.textContent = abrigo.nome; // Exibe apenas o nome do abrigo
                    selectAbrigo.appendChild(option);
                });
            })

    // Função de feedback com SweetAlert
    function showAlert(success, message) {
        Swal.fire({
            icon: success ? 'success' : 'error',
            title: success ? 'Sucesso' : 'Erro',
            text: message,
            confirmButtonText: 'OK'
        }).then(() => {
            if (success) window.location.reload();
        });
    }

    // Enviar formulário de cadastro
    document.getElementById('formCadastrarPessoa').addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(this);

        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' }
        })
        .then(response => response.json())
        .then(data => showAlert(data.success, data.message))
        .catch(() => showAlert(false, 'Erro ao cadastrar pessoa.'));
    });

    // Enviar formulário de upload de CSV
    document.getElementById('formUploadCSV').addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(this);

        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' }
        })
        .then(response => response.json())
        .then(data => showAlert(data.success, data.message))
        .catch(() => showAlert(false, 'Erro ao fazer upload do CSV.'));
    });
});
</script>
@endsection
