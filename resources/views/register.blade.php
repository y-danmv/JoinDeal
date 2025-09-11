@extends('layouts.main_layout')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="col-md-6">
        <div class="card p-4 shadow-lg border-0">
            <h3 class="text-center fw-bold mb-4 text-info">Cadastrar no JoinDeal</h3>
            <form action="{{ route('register.submit') }}" method="POST" novalidate>
                @csrf
                

                <div class="mb-3">
                    <label for="name" class="form-label">Nome</label>
                    <input class="form-control @error('name') is-invalid @enderror" 
                           type="text" name="name" value="{{ old('name') }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input class="form-control @error('email') is-invalid @enderror" 
                           type="email" name="email" value="{{ old('email') }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Senha</label>
                    <input class="form-control @error('password') is-invalid @enderror" 
                           type="password" name="password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirmar senha</label>
                    <input class="form-control" type="password" name="password_confirmation">
                </div>

                <button class="btn btn-primary w-100 fw-bold">Cadastrar</button>
            </form>
            <p class="text-center mt-3 mb-0">
                Já tem conta? <a href="{{ route('login') }}" class="text-info">Entrar</a>
            </p>
        </div>
    </div>
</div>
@endsection
