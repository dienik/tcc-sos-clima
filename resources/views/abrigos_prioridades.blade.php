@extends('layouts.navbar')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Prioridades dos Abrigos</h2>
    
    <div class="row">
        @foreach($abrigos as $abrigo)
        <div class="col-md-4">
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h4 class="card-title text-success">{{ $abrigo->nome }}</h4>
                    <p><strong>Contato:</strong> {{ $abrigo->telefone }}</p>
                    <p><strong>Endereço:</strong> {{ $abrigo->rua . ', ' . $abrigo->numero . ' - ' . $abrigo->cidade }}</p>
                    
                    <h5 class="mt-3">Prioridades:</h5>
                    <ul class="list-group">
                    @foreach($abrigo->prioridades as $prioridade)
    <li class="list-group-item d-flex justify-content-between align-items-center">
        {{ $prioridade->descricao }}
        @if($prioridade->pivot->precisando)
            <span class="badge bg-danger">Precisando</span>
            @if(session('is_admin', false))
                <button class="btn btn-sm btn-success btn-recebido"
                    data-prioridade="{{ $prioridade->pk_prioridade }}"
                    data-abrigo="{{ $abrigo->pk_abrigo }}">
                    Recebido
                </button>
            @endif
        @else
            <span class="badge bg-success">OK</span>
        @endif
    </li>
@endforeach

                    </ul>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".btn-recebido").forEach(button => {
        button.addEventListener("click", function () {
            let prioridadeId = this.getAttribute("data-prioridade");
            let abrigoId = this.getAttribute("data-abrigo");

            if (!prioridadeId || !abrigoId) {
                console.error("ID da prioridade ou abrigo não encontrado.");
                return;
            }

            fetch(`/abrigos/${abrigoId}/prioridades/${prioridadeId}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                    "Content-Type": "application/json"
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    Swal.fire({
                        title: "Sucesso!",
                        text: "Prioridade removida com sucesso.",
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then(() => {
                        this.closest("li").remove(); // Remove a prioridade da lista
                        window.location.reload()
                    });
                } else {
                    Swal.fire({
                        title: "Erro!",
                        text: "Erro ao remover prioridade.",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                }
            })
            .catch(error => console.error("Erro:", error));
        });
    });
});

</script>
@endsection
