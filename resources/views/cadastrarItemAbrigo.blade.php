@extends('layouts.navbar')

@section('content')
<div class="container mt-5">
    <h2>Cadastrar Itens no Abrigo</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('itens.store') }}" method="POST">
        @csrf

        <!-- Seleção de Abrigo -->
        <div class="mb-3">
            <label for="fk_abrigo" class="form-label">Abrigo</label>
            <select class="form-control" id="fk_abrigo" name="fk_abrigo" required>
                <option value="">Selecione um abrigo</option>
                @foreach($abrigos as $abrigo)
                    <option value="{{ $abrigo->pk_abrigo }}">{{ $abrigo->nome }}</option>
                @endforeach
            </select>
        </div>

        <!-- Grupo de Itens Dinâmicos -->
        <div id="itens-group">
            <div class="item-row mb-3">
                <div class="row">
                    <div class="col-md-5">
                        <label class="form-label">Item</label>
                        <select class="form-control item-select" name="fk_itens[]" required>
                            <option value="">Selecione um item</option>
                            @foreach($itens as $item)
                                <option value="{{ $item->pk_itens }}" data-max="{{ $item->quantidade }}">{{ $item->descricao }} (Disponível: {{ $item->quantidade }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Quantidade</label>
                        <input type="number" class="form-control quantidade-input" name="quantidade[]" required min="1">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Observação</label>
                        <input type="text" class="form-control" name="observacao[]">
                    </div>

                    <div class="col-md-1 d-flex align-items-end">
                        <button type="button" class="btn btn-danger remove-item">X</button>
                    </div>
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-success mt-2" id="add-item">Adicionar Item</button>
        <button type="submit" class="btn btn-primary mt-3">Cadastrar</button>
    </form>
</div>

<script>

    document.addEventListener("DOMContentLoaded", function() {
        function updateMaxQuantity(selectElement) {
            let maxQuantity = selectElement.selectedOptions[0].getAttribute("data-max") || 1;
            let quantidadeInput = selectElement.closest(".row").querySelector(".quantidade-input");
            quantidadeInput.setAttribute("max", maxQuantity);
        }

        document.querySelectorAll(".item-select").forEach(select => {
            select.addEventListener("change", function() {
                updateMaxQuantity(this);
            });
        });

        document.getElementById("add-item").addEventListener("click", function() {
            let itemRow = document.querySelector(".item-row").cloneNode(true);
            itemRow.querySelector("select").value = "";
            itemRow.querySelectorAll("input").forEach(input => input.value = "");
            document.getElementById("itens-group").appendChild(itemRow);

            itemRow.querySelector(".item-select").addEventListener("change", function() {
                updateMaxQuantity(this);
            });
        });

        document.addEventListener("click", function(event) {
            if (event.target.classList.contains("remove-item")) {
                if (document.querySelectorAll(".item-row").length > 1) {
                    event.target.closest(".item-row").remove();
                }
            }
        });
    });
</script>

@endsection
