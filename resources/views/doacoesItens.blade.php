@extends('layouts.navbar')

@section('content')
<div class="container mt-4">
    <h2>Registrar Nova Doação</h2>

    {{-- Formulário de Cadastro da Doação --}}
    <form action="{{ route('doacoes.store') }}" method="POST">
        @csrf

        {{-- Data de Recebimento --}}
        <div class="mb-3">
            <label for="recebimento" class="form-label">Data de Recebimento:</label>
            <input type="date" class="form-control" id="recebimento" name="recebimento" required>
        </div>

        {{-- Selecionar Doador --}}
        <div class="mb-3">
            <label for="fk_doador" class="form-label">Doador:</label>
            <select class="form-control" id="fk_doador" name="fk_doador" required>
                <option value="">Selecione um doador</option>
                @foreach ($doadores as $doador)
                    <option value="{{ $doador->pk_doador }}">{{ $doador->nome }} {{ $doador->sobrenome }}</option>
                @endforeach
            </select>
        </div>

        {{-- Selecionar Coletor --}}
        <div class="mb-3">
            <label for="fk_coletor" class="form-label">Coletor:</label>
            <select class="form-control" id="fk_coletor" name="fk_coletor" required>
                <option value="">Selecione um coletor</option>
                @foreach ($coletores as $coletor)
                    <option value="{{ $coletor->pk_coletor }}">{{ $coletor->nome }} {{ $coletor->sobrenome }}</option>
                @endforeach
            </select>
        </div>

        {{-- Formulário para adicionar Itens --}}
        <h4>Itens da Doação</h4>
        <div id="itemForm" class="mb-3" style="display: none;">
            <div class="row">
                <div class="col-md-4">
                    <label for="descricao" class="form-label">Descrição do Item:</label>
                    <input type="text" class="form-control" id="descricao">
                </div>
                <div class="col-md-3">
                    <label for="quantidade" class="form-label">Quantidade:</label>
                    <input type="number" class="form-control" id="quantidade">
                </div>
                <div class="col-md-3">
                    <label for="validade" class="form-label">Validade:</label>
                    <input type="date" class="form-control" id="validade">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-primary" onclick="salvarItem()">Salvar Item</button>
                </div>
            </div>
        </div>

        {{-- Tabela de Itens --}}
        <table class="table table-bordered" id="itensTable">
            <thead>
                <tr>
                    <th>Descrição</th>
                    <th>Quantidade</th>
                    <th>Validade</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

        {{-- Botão para adicionar novo item --}}
        <button type="button" class="btn btn-success mb-3" onclick="exibirFormularioItem()">Adicionar Item</button>

        {{-- Input oculto para armazenar os itens antes do envio --}}
        <input type="hidden" name="itens_json" id="itens_json">

        {{-- Botão de Envio --}}
        <button type="submit" class="btn btn-primary">Salvar Doação</button>
    </form>
</div>

<script>
    let itens = [];

    function exibirFormularioItem() {
        document.getElementById('itemForm').style.display = 'block';
    }

    function salvarItem() {
        let descricao = document.getElementById('descricao').value.trim();
        let quantidade = document.getElementById('quantidade').value.trim();
        let validade = document.getElementById('validade').value.trim();

        if (!descricao || !quantidade || isNaN(quantidade) || quantidade <= 0) {
            alert("Preencha os campos corretamente!");
            return;
        }

        let item = { descricao, quantidade, validade: validade || null };
        itens.push(item);
        atualizarTabela();

        // Limpar os campos
        document.getElementById('descricao').value = '';
        document.getElementById('quantidade').value = '';
        document.getElementById('validade').value = '';
    }

    function removerItem(index) {
        itens.splice(index, 1);
        atualizarTabela();
    }

    function atualizarTabela() {
        let tbody = document.querySelector("#itensTable tbody");
        tbody.innerHTML = "";
        
        itens.forEach((item, index) => {
            let row = `<tr>
                <td>${item.descricao}</td>
                <td>${item.quantidade}</td>
                <td>${item.validade ? item.validade : '-'}</td>
                <td><button type="button" class="btn btn-danger btn-sm" onclick="removerItem(${index})">Remover</button></td>
            </tr>`;
            tbody.innerHTML += row;
        });

        // Atualiza o input escondido com os itens
        document.getElementById("itens_json").value = JSON.stringify(itens);
    }
</script>
@endsection
