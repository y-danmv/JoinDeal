@extends('layouts.main_layout')

@section('content')
<div class="container d-flex justify-content-center mt-5">
    <div class="col-md-6">
        <div class="card p-5 shadow-lg text-center">
            <div class="mb-4">
                <i class="bi bi-person-circle text-info" style="font-size: 4rem;"></i>
            </div>
            
            <h2 class="fw-bold">{{ $user->nome }}</h2>
            <p class="text-info fs-5">{{ $user->tipo }}</p>
            
            <div class="text-start mt-4 p-3 bg-dark rounded border border-secondary">
                <p class="mb-2"><strong>Email:</strong> {{ $user->email }}</p>
                <p class="mb-2"><strong>CPF:</strong> {{ $user->cpf }}</p>
                <p class="mb-2"><strong>Cidade:</strong> {{ $user->cidade }}</p>
                <p class="mb-0"><strong>Membro desde:</strong> {{ $user->created_at->format('d/m/Y') }}</p>
            </div>

            <div class="mt-4">
                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary w-100 mb-2">Editar Meus Dados</a>
                <a href="{{ route('home') }}" class="btn btn-outline-light w-100">Voltar ao Início</a>
            </div>
        </div>
    </div>
</div>
@endsection