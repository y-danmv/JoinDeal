<?php

namespace App\Http\Controllers;

// <-- CORREÇÃO: Linhas adicionadas
use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // Para lidar com datas

class OrderController extends Controller
{
    /**
     * Lista as contratações do usuário (como cliente e como prestador)
     */
    public function index()
    {
        $user = Auth::user();

        // Pedidos que o usuário FEZ (Cliente)
        $compras = Order::with('service.prestador')
                        ->where('cliente_id', $user->id)
                        ->latest()
                        ->get();

        // Pedidos que o usuário RECEBEU (Prestador)
        $vendas = $user->ordersAsProvider()
                       ->with('cliente', 'service') 
                       ->latest()
                       ->get();


        return view('orders.index', compact('compras', 'vendas'));
    }


    /**
     * Cria uma nova contratação (quando o cliente clica em "Contratar")
     */
    public function store(Request $request, Service $service)
    {
        $user = Auth::user();

        // 1. Prestador não pode contratar o próprio serviço
        if ($service->usuario_id == $user->id) {
            return redirect()->back()->with('error', 'Você não pode contratar seu próprio serviço.');
        }

        // 2. Cliente não pode contratar o mesmo serviço duas vezes
        $existingOrder = Order::where('cliente_id', $user->id)
                              ->where('servico_id', $service->id)
                              ->whereIn('status', ['pendente', 'em andamento']) 
                              ->exists();

        if ($existingOrder) {
             return redirect()->back()->with('error', 'Você já possui uma contratação ativa para este serviço.');
        }
        
        // Cria a contratação
        Order::create([
            'cliente_id' => $user->id,
            'servico_id' => $service->id,
            'data_contratacao' => Carbon::now(),
            'status' => 'pendente', 
        ]);

        return redirect()->route('orders.index')->with('success', 'Serviço contratado com sucesso! Acompanhe em "Minhas Contratações".');
    }


    /**
     * Atualiza o status de uma contratação (ex: 'concluido')
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|in:pendente,em andamento,concluido']);

        // Verifica se o usuário logado é o PRESTADOR deste pedido
        if (Auth::id() !== $order->service->usuario_id) {
            return redirect()->back()->with('error', 'Ação não permitida.');
        }

        $order->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status do pedido atualizado!');
    }
}