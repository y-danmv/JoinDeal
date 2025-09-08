@extends('layouts.main_layout')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-sm-8">
            <div class="card p-5 shadow-lg border-0 rounded-4">
                <div class="text-center p-3">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Logo Notes" style="max-width: 100px;">
                    <h4 class="fw-bold mt-3">Crie sua conta</h4>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-10 col-12">
                        <form action="{{ route('register.submit') }}" method="POST" novalidate>
                            @csrf
                            <div class="mb-3">
                                <label for="text_username" class="form-label fw-bold">E-mail</label>
                                <input class="form-control bg-dark text-info @error('text_username') is-invalid @enderror" 
                                       type="email" 
                                       name="text_username" 
                                       value="{{ old('text_username') }}">
                                @error('text_username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="text_password" class="form-label fw-bold">Senha</label>
                                <input class="form-control bg-dark text-info @error('text_password') is-invalid @enderror" 
                                       type="password" 
                                       name="text_password">
                                @error('text_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button class="btn btn-success w-100 fw-bold" type="submit">Cadastrar</button>
                        </form>
                    </div>
                </div>

                <div class="text-center text-secondary mt-3">
                    <small>&copy; {{ date('Y') }} Notes</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
