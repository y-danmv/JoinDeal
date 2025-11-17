@extends('layouts.main_layout')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="col-md-5">
        <div class="card p-4 shadow-lg border-0">
            <h3 class="text-center fw-bold mb-4 text-info">Entrar no JoinDeal</h3>

            <form action="{{ route('login.submit') }}" method="POST" novalidate>
                @csrf

                <div class="mb-3">
                    <label class="form-label">E-mail ou CPF</label>
                    <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}">
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Senha</label>
                    <input class="form-control @error('password') is-invalid @enderror" type="password" name="password">
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
