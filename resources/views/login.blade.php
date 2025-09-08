@extends('layouts.main_layout')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-sm-8">
            <div class="card p-5">
                <!-- Imagem do logotipo -->
                 <div class="text-center p-3">
                    <img src="assets/images/logo.png" alt="Logo Notes">
                 </div>
                <!-- Formulário -->
                 <div class="row justify-content-center">
                    <div class="col-md-10 col-12">
                        {{-- <form action="/loginSubmit" method="POST"> --}}
                            <form action="{{ route('login.submit') }}" method="POST" novalidate>
                            @csrf
                            <div class="mb-3">
                                <label for="text_username">Username</label>
                                <input class="form-control bg-dark text-info"                            type="text" name="text_username" value="{{ old('text_username') }}" >
                                @error('text_username')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="text_password">Password</label>
                                <input class="form-control bg-dark text-info"                            type="password" name="text_password" value="{{ old('text_password') }}" >
                                @error('text_password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-secondary w-100" type="submit">LOGIN</button>
                            </div>
                        </form>
                        {{-- @if($errors->any())
                            <div class="alert alert-danger mt-3">
                                <ol class="m-0">
                                    @foreach ($errors->all() as $error )
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ol>
                            </div>
                        @endif --}}
                    </div>
                 </div>

                 <div class="text-center text-secondary mt-3">
                    <small>&copy; <?= date('Y') ?> Notes</small>
                 </div>

            </div>

        </div>

    </div>


</div>


@endsection