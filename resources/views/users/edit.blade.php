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
                    <label for="nome" class="form-label">Nome</label>
                    <input class="form-control @error('nome') is-invalid @enderror" 
                           type="text" name="nome" value="{{ old('nome', $user->nome) }}">
                    @error('nome')
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
                    <select class="form-select @error('cidade') is-invalid @enderror" name="cidade">
                        <option value="">Selecione a Cidade</option>
                        @php
                            $cidadesExemplo = ['São Paulo', 'Rio de Janeiro', 'Belo Horizonte', 'Salvador', 'Curitiba', 'Porto Alegre', 'Recife', 'Brasília'];
                            $cidadeAtual = old('cidade', $user->cidade);
                        @endphp
                        @foreach($cidadesExemplo as $cidade)
                            <option value="{{ $cidade }}" {{ $cidadeAtual == $cidade ? 'selected' : '' }}>
                                {{ $cidade }}
                            </option>
                        @endforeach
                    </select>
                    @error('cidade')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="cpf" class="form-label">CPF</label>
                    <input class="form-control @error('cpf') is-invalid @enderror" 
                           type="text" id="cpf_edit" name="cpf" value="{{ old('cpf', $user->cpf) }}" 
                           placeholder="Apenas números (formatação automática)" maxlength="14">
                    @error('cpf')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="tipo" class="form-label">Tipo de Usuário</label>
                    <select class="form-select @error('tipo') is-invalid @enderror" name="tipo">
                        <option value="">Selecione o tipo</option>
                        <option value="Cliente" {{ old('tipo', $user->tipo) == 'Cliente' ? 'selected' : '' }}>Cliente</option>
                        <option value="Prestador" {{ old('tipo', $user->tipo) == 'Prestador' ? 'selected' : '' }}>Prestador</option>
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

<script>
    // Script de máscara (igual ao que você enviou)
    document.addEventListener('DOMContentLoaded', function() {
        const cpfInput = document.getElementById('cpf_edit');
        function maskCPF(value) {
            value = value.replace(/\D/g, ""); 
            value = value.slice(0, 11); 
            value = value.replace(/(\d{3})(\d)/, "$1.$2");
            value = value.replace(/(\d{3})(\d)/, "$1.$2");
            value = value.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
            return value;
        }
        if (cpfInput.value) {
             cpfInput.value = maskCPF(cpfInput.value.replace(/[^0-9]/g, ''));
        }
        cpfInput.addEventListener('input', function(e) {
            e.target.value = maskCPF(e.target.value);
        });
    });
</script>
@endsection