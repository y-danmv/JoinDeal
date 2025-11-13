@extends('layouts.main_layout')

@section('content')
<div class="container d-flex justify-content-center" style="min-height: 80vh;">
    <div class="col-md-8">
        <div class="card p-4 shadow-lg border-0 mt-5">
            <h3 class="fw-bold text-info mb-4">Editar Usuário: {{ $user->nome }}</h3>

            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nome</label>
                        <input type="text" name="nome" class="form-control" value="{{ old('nome', $user->nome) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">CPF</label>
                        <input type="text" name="cpf" class="form-control" value="{{ old('cpf', $user->cpf) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Cidade</label>
                        <input type="text" name="cidade" class="form-control" value="{{ old('cidade', $user->cidade) }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tipo de Conta</label>
                    <select name="tipo" class="form-select">
                        <option value="Cliente" {{ $user->tipo == 'Cliente' ? 'selected' : '' }}>Cliente</option>
                        <option value="Prestador" {{ $user->tipo == 'Prestador' ? 'selected' : '' }}>Prestador</option>
                    </select>
                </div>

                <hr class="border-secondary my-4">
                <h5 class="text-white-50 mb-3">Alterar Senha (Opcional)</h5>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nova Senha</label>
                        <input type="password" name="password" class="form-control" placeholder="Deixe em branco para manter a atual">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Confirmar Nova Senha</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-3">
                    <a href="{{ route('users.index') }}" class="btn btn-outline-light">Cancelar</a>
                    <button type="submit" class="btn btn-primary fw-bold px-5">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection