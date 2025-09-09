@extends('layouts.main_layout')

@section('content')
<div class="container text-center mt-5">
    <h1 class="fw-bold text-white">Bem-vindo ao <span class="text-info">JoinDeal</span></h1>
    <p class="lead text-light">Aqui você pode contratar e anunciar serviços de forma rápida e segura.</p>

    <!-- Botões principais -->
    <div class="mt-4">
        <a href="{{ route('login') }}" class="btn btn-primary btn-lg me-2">Quero contratar</a>
        <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg">Quero anunciar</a>
    </div>

    <!-- Cards -->
    <div class="row mt-5 g-4">
        <div class="col-md-4">
            <div class="card p-4 shadow-sm border-0">
                <h5 class="fw-bold text-info">Serviços variados</h5>
                <p>Encontre profissionais de diversas áreas para atender sua necessidade.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-4 shadow-sm border-0">
                <h5 class="fw-bold text-info">Segurança</h5>
                <p>Cadastre-se e anuncie com segurança e confiança na plataforma.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-4 shadow-sm border-0">
                <h5 class="fw-bold text-info">Praticidade</h5>
                <p>Interface moderna e simples para facilitar sua experiência.</p>
            </div>
        </div>
    </div>
</div>
@endsection
