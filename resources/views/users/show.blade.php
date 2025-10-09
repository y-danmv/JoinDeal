@extends('layouts.main_layout')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="col-md-6">
        <div class="card p-4 shadow-lg border-0">
            <h3 class="text-center fw-bold mb-4 text-info">Detalhes do Usuário (ID: {{ $user->id }})</h3>
            
            <p><strong>Nome:</strong> {{ $user->name }}</p>
            <p><strong>E-mail:</strong> {{ $user->email }}</p>
            <p><strong>CPF:</strong> {{ $user->cpf }}</p>
            <p><strong>Cidade:</strong> {{ $user->cidade }}</p>
            <p><strong>Tipo:</strong> {{ $user->tipo }}</p>
            <p><strong>Criado em:</strong> {{ $user->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Atualizado em:</strong> {{ $user->updated_at->format('d/m/Y H:i') }}</p>

            <hr>

            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning mb-2">Editar Usuário</a>
            <a href="{{ route('users.index') }}" class="btn btn-outline-light">Voltar para a Lista</a>
        </div>
    </div>
</div>
@endsection