@extends('layouts.main_layout')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="col-md-6">
        <div class="card p-4 shadow-lg border-0">
            <h3 class="text-center fw-bold mb-4 text-info">Editar Usuário (ID: {{ $user->id }})</h3>
            
            <form action="{{ route('users.update', $user->id) }}" method="POST" novalidate>
                @csrf
                @method('PUT') 

                <div class="mb-3">
                    <label for="name" class="form-label">Nome</label>
                    <input class="form-control @error('name') is-invalid @enderror" 
                           type="text" name="name" value="{{ old('name', $user->name) }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input class="form-control @error('email') is-invalid @enderror" 
                           type="email" name="email" value="{{ old('email', $user->email) }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="cidade" class="form-label">Cidade</label>
                    <input class="form-control @error('cidade') is-invalid @enderror" 
                           type="text" name="cidade" value="{{ old('cidade', $user->cidade) }}">
                    @error('cidade')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="cpf" class="form-label">CPF (Ex: 000.000.000-00)</label>
                    <input class="form-control @error('cpf') is-invalid @enderror" 
                           type="text" name="cpf" value="{{ old('cpf', $user->cpf) }}" placeholder="000.000.000-00">
                    @error('cpf')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="tipo" class="form-label">Tipo de Usuário</label>
                    <select class="form-select @error('tipo') is-invalid @enderror" name="tipo">
                        <option value="">Selecione o tipo</option>
                        <option value="Cliente" {{ old('tipo', $user->tipo) == 'Cliente' ? 'selected' : '' }}>Cliente</option>
                        <option value="Funcionario" {{ old('tipo', $user->tipo) == 'Funcionario' ? 'selected' : '' }}>Funcionário</option>
                    </select>
                    @error('tipo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <hr>
                <p class="text-light">Deixe os campos abaixo em branco para **manter** a senha atual.</p>

                <div class="mb-3">
                    <label for="password" class="form-label">Nova Senha</label>
                    <input class="form-control @error('password') is-invalid @enderror" 
                           type="password" name="password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirmar Nova Senha</label>
                    <input class="form-control" type="password" name="password_confirmation">
                </div>

                <button class="btn btn-primary w-100 fw-bold">Salvar Alterações</button>
            </form>
            <p class="text-center mt-3 mb-0">
                <a href="{{ route('users.index') }}" class="text-info">Cancelar e Voltar</a>
            </p>
        </div>
    </div>
</div>
@endsection