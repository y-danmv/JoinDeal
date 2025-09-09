@extends('layouts.main_layout')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="col-md-5">
        <div class="card p-4 shadow-lg border-0">
            <h3 class="text-center fw-bold mb-4 text-info">Entrar no JoinDeal</h3>
            <form action="{{ route('login.submit') }}" method="POST" novalidate>
                @csrf
                <div class="mb-3">
                    <label for="text_username" class="form-label">E-mail</label>
                    <input class="form-control @error('text_username') is-invalid @enderror" 
                           type="text" name="text_username" value="{{ old('text_username') }}">
                    @error('text_username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="text_password" class="form-label">Senha</label>
                    <input class="form-control @error('text_password') is-invalid @enderror" 
                           type="password" name="text_password">
                    @error('text_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button class="btn btn-primary w-100 fw-bold">Entrar</button>
            </form>
            <p class="text-center mt-3 mb-0">
                Ainda não tem conta? <a href="{{ route('register') }}" class="text-info">Cadastre-se</a>
            </p>
        </div>
    </div>
</div>
@endsection
