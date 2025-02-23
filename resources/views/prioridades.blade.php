@extends('layouts.navbar')

@section('content')
<div class="container mt-5">
    <div class="row">
        <!-- Formulário para Cadastrar Prioridade -->
        <div class="col-md-6">
            <h2>Cadastrar Prioridade</h2>
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <form action="{{ route('prioridades.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Descrição da Prioridade:</label>
                    <input type="text" class="form-control" name="descricao" required>
                </div>
                <button type="submit" class="btn btn-primary">Cadastrar</button>
            </form>
        </div>

        <!-- Formulário para Atribuir Prioridade ao Abrigo -->
        <div class="col-md-6">
            <h2>Atribuir Prioridade a um Abrigo</h2>
            <form action="{{ route('prioridades.atribuir') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Abrigo:</label>
                    <select class="form-control" name="fk_abrigo" required>
                        <option value="">Selecione um abrigo</option>
                        @foreach($abrigos as $abrigo)
                            <option value="{{ $abrigo->pk_abrigo }}">{{ $abrigo->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Prioridade:</label>
                    <select class="form-control" name="fk_prioridades" required>
                        <option value="">Selecione uma prioridade</option>
                        @foreach($prioridades as $prioridade)
                            <option value="{{ $prioridade->pk_prioridade }}">{{ $prioridade->descricao }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Está precisando?</label>
                    <select class="form-control" name="precisando">
                        <option value="1">Sim</option>
                        <option value="0">Não</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Atribuir Prioridade</button>
            </form>
        </div>
    </div>
</div>


@endsection
