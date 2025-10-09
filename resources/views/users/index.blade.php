@extends('layouts.main_layout')

@section('content')
<div class="container mt-5">
    <h1 class="fw-bold text-white mb-4">Gerenciamento de Usuários</h1>

    <div class="card p-4 shadow-lg border-0">
        <h5 class="fw-bold text-info mb-3">Lista de Usuários Cadastrados</h5>
        <div class="table-responsive">
            <table class="table table-dark table-hover">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nome</th>
                        <th scope="col">E-mail</th>
                        <th scope="col">CPF</th>       <th scope="col">Cidade</th>    <th scope="col">Tipo</th>      <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <th scope="row">{{ $user->id }}</th>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->cpf }}</td>    <td>{{ $user->cidade }}</td> <td>{{ $user->tipo }}</td>   <td>
                                <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-outline-info me-2">Ver</a>
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-outline-warning me-2">Editar</a>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este usuário?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection