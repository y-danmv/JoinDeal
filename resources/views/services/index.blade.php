@extends('layouts.main_layout')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold text-white">Serviços Disponíveis</h1>
        @auth
            @if (Auth::user()->tipo == 'Prestador')
                <a href="{{ route('services.create') }}" class="btn btn-primary fw-bold">
                    <i class="bi bi-plus-circle"></i> Anunciar Novo Serviço
                </a>
            @endif
        @endauth
    </div>

    <div class="row g-4">
        @forelse ($services as $service)
        <div class="col-md-6 col-lg-4">
            <div class="card p-4 shadow-lg h-100 d-flex flex-column">
                <div class="flex-grow-1">
                    <h5 class="fw-bold text-info">{{ $service->titulo }}</h5>
                    <span class="badge bg-secondary mb-2">{{ $service->categoria }}</span>
                    <p>{{ $service->descricao }}</p>
                    <p class="mb-1"><strong>Prestador:</strong> {{ $service->prestador->nome }}</p>
                    <h4 class="fw-bold text-white mt-2">R$ {{ number_format($service->valor, 2, ',', '.') }}</h4>
                </div>

                <div class="mt-3">
                    @auth
                        @if (Auth::id() !== $service->usuario_id)
                        <form action="{{ route('orders.store', $service->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100 fw-bold">Contratar</button>
                        </form>
                        @else
                        <div class="d-flex">
                            <a href="{{ route('services.edit', $service->id) }}" class="btn btn-warning w-50 me-2">Editar</a>
                            <form action="{{ route('services.destroy', $service->id) }}" method="POST" class="w-50" onsubmit="return confirm('Excluir este serviço?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger w-100">Excluir</button>
                            </form>
                        </div>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary w-100 fw-bold">Fazer login para Contratar</a>
                    @endauth
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card p-5 text-center">
                <h5 class="text-white-50">Nenhum serviço cadastrado no momento.</h5>
            </div>
        </div>
        @endforelse
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $services->links() }}
    </div>
</div>
@endsection