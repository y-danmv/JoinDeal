<?php

namespace App\Http\Controllers;

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
                            ->latest('data_agendamento') 
                            ->get();

        // Pedidos que o usuário RECEBEU (Prestador)
        $vendas = $user->ordersAsProvider()
                            ->with('cliente', 'service') 
                            ->latest('data_agendamento') 
                            ->get();


        return view('orders.index', compact('compras', 'vendas'));
    }


    /**
     * Cria uma nova contratação (quando o cliente clica em "Contratar")
     */
    public function store(Request $request, Service $service)
    {
        $user = Auth::user(); // Este é o CLIENTE

        // 1. Validação (Data/Hora comercial)
        $request->validate([
            'data_agendamento' => [
                'required',
                'date',
                'after:now',
                function ($attribute, $value, $fail) {
                    $horarioSolicitado = Carbon::parse($value);
                    $time = $horarioSolicitado->format('H:i');
                    $inicioComercial = '07:30';
                    $fimComercial = '17:30'; 
                    if ($time < $inicioComercial || $time > $fimComercial) {
                        $fail("O horário do agendamento deve ser entre 07:30 e 17:30.");
                    }
                },
            ],
        ], [
            'data_agendamento.required' => 'Você precisa escolher uma data e hora.',
            'data_agendamento.after' => 'A data do agendamento não pode ser no passado.',
        ]);

        // 2. Prestador não pode contratar o próprio serviço
        if ($service->usuario_id == $user->id) {
            return redirect()->back()->with('error', 'Você não pode contratar seu próprio serviço.');
        }

        // Pega o horário solicitado e calcula a janela de 1h
        $horarioSolicitado = Carbon::parse($request->data_agendamento);
        $inicioSolicitado = $horarioSolicitado;
        $fimSolicitado = $horarioSolicitado->copy()->addHour(); 

        // 
        // =============================================
        // <-- INÍCIO DA ALTERAÇÃO (LÓGICA DO CLIENTE) -->
        // =============================================
        //
        
        // 3. VERIFICAÇÃO DE CONFLITO DE HORÁRIO DO CLIENTE
        // Verifica se o CLIENTE (usuário logado) já tem um agendamento nesse horário
        $conflitoCliente = Order::where('cliente_id', $user->id)
                            ->where('status', '!=', 'concluido') // Ignora serviços já concluídos
                            ->where('data_agendamento', '<', $fimSolicitado) // Começa antes do fim do novo agendamento
                            ->whereRaw('DATE_ADD(data_agendamento, INTERVAL 1 HOUR) > ?', [$inicioSolicitado]) // Termina depois do início do novo
                            ->exists();
        
        if ($conflitoCliente) {
            return redirect()->back()->withInput()->with('error', 'Você já possui outro agendamento neste mesmo horário. Por favor, escolha outra data ou hora.');
        }
        $prestador = $service->prestador; 
        
        $conflitoPrestador = Order::whereHas('service', function ($query) use ($prestador) {
                                $query->where('usuario_id', $prestador->id);
                            })
                            ->where('status', '!=', 'concluido') 
                            ->where('data_agendamento', '<', $fimSolicitado) 
                            ->whereRaw('DATE_ADD(data_agendamento, INTERVAL 1 HOUR) > ?', [$inicioSolicitado]) 
                            ->exists();

        if ($conflitoPrestador) {
            return redirect()->back()->withInput()->with('error', 'O prestador já está ocupado neste horário. Por favor, escolha outra data ou hora.');
        }

        // 5. Cria a contratação (Se tudo estiver OK)
        Order::create([
            'cliente_id' => $user->id,
            'servico_id' => $service->id,
            'data_contratacao' => Carbon::now(), 
            'data_agendamento' => $horarioSolicitado, 
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

        if (Auth::id() !== $order->service->usuario_id) {
            return redirect()->back()->with('error', 'Ação não permitida.');
        }

        $order->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status do pedido atualizado!');
    }
}