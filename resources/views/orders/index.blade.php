@extends('layouts.main_layout')

@section('content')
<div class="container mt-4">
    <h1 class="fw-bold text-white mb-4">Minhas Contratações</h1>

    <div class="card p-4 shadow-lg border-0 mb-4">
        <h5 class="fw-bold text-info mb-3">Serviços que Contratei (Minhas Compras)</h5>
        <div class="table-responsive">
            <table class="table table-dark table-hover">
                <thead>
                    <tr>
                        <th scope="col">Serviço</th>
                        <th scope="col">Prestador</th>
                        <th scope="col">Data</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($compras as $order)
                        <tr>
                            <td>{{ $order->service->titulo }}</td>
                            <td>{{ $order->service->prestador->nome }}</td>
                            <td>{{ \Carbon\Carbon::parse($order->data_contratacao)->format('d/m/Y') }}</td>
                            <td>
                                @php
                                    $statusClass = 'text-warning'; // pendente
                                    if ($order->status == 'em andamento') $statusClass = 'text-info';
                                    if ($order->status == 'concluido') $statusClass = 'text-success';
                                @endphp
                                <span class="fw-bold {{ $statusClass }}">{{ ucfirst($order->status) }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-white-50">Você ainda não contratou nenhum serviço.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if (Auth::user()->tipo == 'Prestador')
    <div class="card p-4 shadow-lg border-0">
        <h5 class="fw-bold text-info mb-3">Serviços Solicitados (Minhas Vendas)</h5>
         <div class="table-responsive">
            <table class="table table-dark table-hover">
                <thead>
                    <tr>
                        <th scope="col">Serviço</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Data</th>
                        <th scope="col">Status Atual</th>
                        <th scope="col">Mudar Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($vendas as $order)
                        <tr>
                            <td>{{ $order->service->titulo }}</td>
                            <td>{{ $order->cliente->nome }}</td>
                            <td>{{ \Carbon\Carbon::parse($order->data_contratacao)->format('d/m/Y') }}</td>
                            <td>
                                @php
                                    $statusClass = 'text-warning'; // pendente
                                    if ($order->status == 'em andamento') $statusClass = 'text-info';
                                    if ($order->status == 'concluido') $statusClass = 'text-success';
                                @endphp
                                <span class="fw-bold {{ $statusClass }}">{{ ucfirst($order->status) }}</span>
                            </td>
                            <td>
                                <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="form-select form-select-sm bg-dark text-white" onchange="this.form.submit()">
                                        <option value="pendente" {{ $order->status == 'pendente' ? 'selected' : '' }}>Pendente</option>
                                        <option value="em andamento" {{ $order->status == 'em andamento' ? 'selected' : '' }}>Em Andamento</option>
                                        <option value="concluido" {{ $order->status == 'concluido' ? 'selected' : '' }}>Concluído</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    @empty
                         <tr>
                            <td colspan="5" class="text-center text-white-50">Nenhum cliente solicitou seus serviços ainda.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif

</div>
@endsection