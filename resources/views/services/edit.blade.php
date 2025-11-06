@extends('layouts.main_layout')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="col-md-6">
        <div class="card p-4 shadow-lg border-0">
            <h3 class="text-center fw-bold mb-4 text-info">Editar Serviço (ID: {{ $service->id }})</h3>
            
            <form action="{{ route('services.update', $service->id) }}" method="POST" novalidate>
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título do Serviço</label>
                    <input class="form-control @error('titulo') is-invalid @enderror" 
                           type="text" name="titulo" value="{{ old('titulo', $service->titulo) }}" required>
                    @error('titulo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição (Max 255 caracteres)</label>
                    <textarea class="form-control @error('descricao') is-invalid @enderror" 
                              name="descricao" rows="3" required>{{ old('descricao', $service->descricao) }}</textarea>
                    @error('descricao')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                         <label for="valor" class="form-label">Valor (R$)</label>
                        <input class="form-control @error('valor') is-invalid @enderror" 
                               type="number" step="0.01" name="valor" value="{{ old('valor', $service->valor) }}" 
                               placeholder="Ex: 50.00" required>
                        @error('valor')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                     <div class="col-md-6 mb-3">
                        <label for="categoria" class="form-label">Categoria</label>
                        <input class="form-control @error('categoria') is-invalid @enderror" 
                               type="text" name="categoria" value="{{ old('categoria', $service->categoria) }}" 
                               placeholder="Ex: Limpeza" required>
                        @error('categoria')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button class="btn btn-primary w-100 fw-bold">Salvar Alterações</button>
            </form>
             <p class="text-center mt-3 mb-0">
                <a href="{{ route('services.index') }}" class="text-info">Cancelar e Voltar</a>
            </p>
        </div>
    </div>
</div>
@endsection