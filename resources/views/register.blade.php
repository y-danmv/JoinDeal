@extends('layouts.main_layout')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="col-md-6">
        <div class="card p-4 shadow-lg border-0">
            <!-- Título corrigido para Cadastro (sem referência a $user) -->
            <h3 class="text-center fw-bold mb-4 text-info">Novo Cadastro de Usuário</h3>
            
            <!-- Ação corrigida para o método registerSubmit do AuthController -->
            <form action="{{ route('register.submit') }}" method="POST" novalidate>
                @csrf
                
                <div class="mb-3">
                    <label for="name" class="form-label">Nome</label>
                    <input class="form-control @error('name') is-invalid @enderror" 
                           type="text" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input class="form-control @error('email') is-invalid @enderror" 
                           type="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- CAMPO: CIDADE (Select com estilo de cores do site) -->
                <div class="mb-3">
                    <label for="cidade" class="form-label">Cidade</label>
                    <select class="form-select @error('cidade') is-invalid @enderror" name="cidade" required>
                        <option value="">Selecione a Cidade</option>
                        @php
                            // Lista de Cidades (apenas para o exemplo)
                            $cidadesExemplo = ['São Paulo', 'Rio de Janeiro', 'Belo Horizonte', 'Salvador', 'Curitiba', 'Porto Alegre', 'Recife', 'Brasília'];
                            $cidadeAtual = old('cidade');
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

                <!-- CAMPO: CPF (Com Máscara JS) -->
                <div class="mb-3">
                    <label for="cpf" class="form-label">CPF</label>
                    <!-- Usamos id="cpf_register" e apenas old('cpf') -->
                    <input class="form-control @error('cpf') is-invalid @enderror" 
                           type="text" id="cpf_register" name="cpf" value="{{ old('cpf') }}" 
                           placeholder="000.000.000-00" maxlength="14" required>
                    @error('cpf')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- CAMPO: TIPO (Select com estilo de cores do site) -->
                <div class="mb-3">
                    <label for="tipo" class="form-label">Tipo de Usuário</label>
                    <select class="form-select @error('tipo') is-invalid @enderror" name="tipo" required>
                        <option value="">Selecione o tipo</option>
                        <option value="Cliente" {{ old('tipo') == 'Cliente' ? 'selected' : '' }}>Cliente</option>
                        <option value="Funcionario" {{ old('tipo') == 'Funcionario' ? 'selected' : '' }}>Funcionário</option>
                    </select>
                    @error('tipo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- CAMPOS DE SENHA PARA NOVO CADASTRO -->
                <div class="mb-3">
                    <label for="password" class="form-label">Senha</label>
                    <input class="form-control @error('password') is-invalid @enderror" 
                           type="password" name="password" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirmar Senha</label>
                    <input class="form-control" type="password" name="password_confirmation" required>
                </div>

                <button class="btn btn-primary w-100 fw-bold">Cadastrar</button>
            </form>
            <p class="text-center mt-3 mb-0">
                <a href="{{ route('login') }}" class="text-info">Já tem conta? Faça Login</a>
            </p>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cpfInput = document.getElementById('cpf_register');

        // Função para aplicar a máscara do CPF: XXX.XXX.XXX-XX
        function maskCPF(value) {
            value = value.replace(/\D/g, ""); // Remove tudo que não for dígito
            value = value.slice(0, 11); // Limita a 11 dígitos
            
            // Aplica a formatação: 123.456.789-00
            value = value.replace(/(\d{3})(\d)/, "$1.$2");
            value = value.replace(/(\d{3})(\d)/, "$1.$2");
            value = value.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
            
            return value;
        }

        // Aplica a máscara ao digitar
        cpfInput.addEventListener('input', function(e) {
            e.target.value = maskCPF(e.target.value);
        });
        
        // Aplica a máscara no valor antigo se houver erro de validação
        if (cpfInput.value) {
            cpfInput.value = maskCPF(cpfInput.target.value);
        }
    });
</script>
@endsection
