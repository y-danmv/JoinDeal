@extends('layouts.main_layout')

@section('content')

{{-- VERSÃO PARA QUEM *NÃO* ESTÁ LOGADO (Visitante) --}}
@guest
<div class="container text-center mt-5">
    <h1 class="fw-bold text-white">Bem-vindo ao <span class="text-info">JoinDeal</span></h1>
    <p class="lead text-light">A plataforma simples para contratar e anunciar serviços.</p>
    
    <div class="mt-4">
        <a href="{{ route('login') }}" class="btn btn-primary btn-lg me-2 fw-bold">Quero Contratar</a>
        <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg fw-bold">Quero Anunciar</a>
    </div>
    
    <div class="row mt-5 g-4">
        <div class="col-md-4">
            <div class="card p-4 shadow-sm border-0 h-100">
                <div class="card-body">
                    <i class="bi bi-search text-info fs-1 mb-3"></i>
                    <h5 class="fw-bold text-white">Encontre Fácil</h5>
                    <p class="text-white-50">Busque profissionais qualificados em segundos.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-4 shadow-sm border-0 h-100">
                <div class="card-body">
                    <i class="bi bi-shield-check text-info fs-1 mb-3"></i>
                    <h5 class="fw-bold text-white">Segurança</h5>
                    <p class="text-white-50">Seus dados e contratações protegidos.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-4 shadow-sm border-0 h-100">
                <div class="card-body">
                    <i class="bi bi-graph-up-arrow text-info fs-1 mb-3"></i>
                    <h5 class="fw-bold text-white">Cresça</h5>
                    <p class="text-white-50">Anuncie seus serviços e aumente sua renda.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endguest


{{-- VERSÃO PARA QUEM *ESTÁ* LOGADO (Dashboard) --}}
@auth
<div class="container mt-4">
    <div class="row mb-4 align-items-center">
        <div class="col-md-8">
            <h2 class="fw-bold text-white">Olá, <span class="text-info">{{ Auth::user()->nome }}</span>!</h2>
            <p class="text-white-50">Aqui está o resumo das suas atividades no JoinDeal.</p>
        </div>
        <div class="col-md-4 text-end">
            <span class="badge bg-dark border border-info text-info p-2 rounded-pill">
                <i class="bi bi-person-badge me-1"></i> Conta: {{ Auth::user()->tipo }}
            </span>
        </div>
    </div>

    {{-- CARDS DE ESTATÍSTICAS --}}
    <div class="row g-4 mb-5">
        
        <div class="col-md-4">
            <div class="card shadow-lg border-0 h-100 position-relative overflow-hidden">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-white-50 mb-1 fw-bold text-uppercase" style="font-size: 0.8rem;">Contratações</p>
                            <h2 class="fw-bold text-white mb-0">{{ $totalCompras ?? 0 }}</h2>
                        </div>
                        <div class="bg-primary bg-opacity-25 p-3 rounded-circle text-primary">
                            <i class="bi bi-bag-check fs-3"></i>
                        </div>
                    </div>
                    <a href="{{ route('orders.index') }}" class="stretched-link mt-3 d-block text-decoration-none text-info small fw-bold">
                        Ver detalhes <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        @if(Auth::user()->tipo == 'Prestador')
        <div class="col-md-4">
            <div class="card shadow-lg border-0 h-100 position-relative overflow-hidden">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-white-50 mb-1 fw-bold text-uppercase" style="font-size: 0.8rem;">Meus Serviços</p>
                            <h2 class="fw-bold text-white mb-0">{{ $totalMeusServicos ?? 0 }}</h2>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded-circle text-warning">
                            <i class="bi bi-briefcase fs-3"></i>
                        </div>
                    </div>
                    <a href="{{ route('services.index') }}" class="stretched-link mt-3 d-block text-decoration-none text-warning small fw-bold">
                        Gerenciar <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-lg border-0 h-100 position-relative overflow-hidden">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-white-50 mb-1 fw-bold text-uppercase" style="font-size: 0.8rem;">Vendas/Pedidos</p>
                            <h2 class="fw-bold text-white mb-0">{{ $totalVendas ?? 0 }}</h2>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded-circle text-success">
                            <i class="bi bi-currency-dollar fs-3"></i>
                        </div>
                    </div>
                    <a href="{{ route('orders.index') }}" class="stretched-link mt-3 d-block text-decoration-none text-success small fw-bold">
                        Ver pedidos <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
        @else
        <div class="col-md-8">
            <div class="card shadow-lg border-0 h-100" style="background: linear-gradient(45deg, #2d3949, #1e293b);">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="fw-bold text-white">Precisa de algo hoje?</h4>
                        <p class="text-white-50 mb-0">Temos centenas de prestadores prontos para te atender.</p>
                    </div>
                    <a href="{{ route('services.index') }}" class="btn btn-info fw-bold text-white px-4 py-2 rounded-pill">
                        Buscar Serviços
                    </a>
                </div>
            </div>
        </div>
        @endif

    </div>

    {{-- ÁREA DE AÇÕES RÁPIDAS --}}
    <h4 class="fw-bold text-white mb-3">O que você deseja fazer?</h4>
    <div class="row g-3">
        <div class="col-md-3">
            <a href="{{ route('services.index') }}" class="btn btn-outline-light w-100 p-3 text-start d-flex align-items-center hover-card">
                <i class="bi bi-search fs-4 me-3 text-info"></i>
                <div>
                    <div class="fw-bold">Procurar Serviços</div>
                    <div class="small text-white-50">Contrate professionals</div>
                </div>
            </a>
        </div>

        @if(Auth::user()->tipo == 'Prestador')
        <div class="col-md-3">
            <a href="{{ route('services.create') }}" class="btn btn-outline-light w-100 p-3 text-start d-flex align-items-center hover-card">
                <i class="bi bi-plus-circle fs-4 me-3 text-warning"></i>
                <div>
                    <div class="fw-bold">Anunciar Serviço</div>
                    <div class="small text-white-50">Crie um novo anúncio</div>
                </div>
            </a>
        </div>
        @endif

        <div class="col-md-3">
            <a href="{{ route('users.show', Auth::id()) }}" class="btn btn-outline-light w-100 p-3 text-start d-flex align-items-center hover-card">
                <i class="bi bi-person-gear fs-4 me-3 text-primary"></i>
                <div>
                    <div class="fw-bold">Meu Perfil</div>
                    <div class="small text-white-50">Edite seus dados</div>
                </div>
            </a>
        </div>
    </div>
</div>
@endauth
@endsection