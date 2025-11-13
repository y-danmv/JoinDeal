@extends('layouts.main_layout')

@section('content')
<div class="container mt-4">
    <h2 class="fw-bold text-white mb-4">Gerenciar Usuários</h2>

    <div class="card p-4 shadow-lg border-0">
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Tipo</th>
                        <th>Cidade</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->nome }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge {{ $user->tipo == 'Prestador' ? 'bg-info text-dark' : 'bg-secondary' }}">
                                {{ $user->tipo }}
                            </span>
                        </td>
                        <td>{{ $user->cidade }}</td>
                        <td>
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-outline-warning me-1">Editar</a>
                            
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Tem certeza?')">Excluir</button>
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