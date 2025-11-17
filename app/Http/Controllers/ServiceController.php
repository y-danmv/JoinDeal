<?php

namespace App\Http\Controllers;

use App\Models\Service; // <-- CORREÇÃO: Esta linha foi adicionada
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Lista todos os serviços, do mais novo para o mais antigo
        $services = Service::with('prestador')->latest()->paginate(10);
        return view('services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Apenas Prestadores podem criar serviços
        if (Auth::user()->tipo !== 'Prestador') {
            return redirect()->route('services.index')->with('error', 'Apenas prestadores podem anunciar serviços.');
        }

        return view('services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Apenas Prestadores podem criar serviços
        if (Auth::user()->tipo !== 'Prestador') {
            return redirect()->route('services.index')->with('error', 'Ação não permitida.');
        }

        $request->validate([
            'titulo' => 'required|string|max:100',
            'descricao' => 'required|string|max:255',
            'valor' => 'required|numeric|min:0',
            'categoria' => 'required|string|max:100',
        ]);

        // Cria o serviço associado ao usuário logado (Prestador)
        Auth::user()->services()->create([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'valor' => $request->valor,
            'categoria' => $request->categoria,
        ]);

        return redirect()->route('services.index')->with('success', 'Serviço cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
         return view('services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        // Verifica se o usuário logado é o dono do serviço
        if (Auth::id() !== $service->usuario_id) {
            return redirect()->route('services.index')->with('error', 'Você não tem permissão para editar este serviço.');
        }

        return view('services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        // Verifica se o usuário logado é o dono do serviço
        if (Auth::id() !== $service->usuario_id) {
            return redirect()->route('services.index')->with('error', 'Você não tem permissão para editar este serviço.');
        }

        $request->validate([
            'titulo' => 'required|string|max:100',
            'descricao' => 'required|string|max:255',
            'valor' => 'required|numeric|min:0',
            'categoria' => 'required|string|max:100',
        ]);

        $service->update($request->all());

        return redirect()->route('services.index')->with('success', 'Serviço atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        // Verifica se o usuário logado é o dono do serviço
        if (Auth::id() !== $service->usuario_id) {
            return redirect()->route('services.index')->with('error', 'Você não tem permissão para excluir este serviço.');
        }

        $service->delete();
        return redirect()->route('services.index')->with('success', 'Serviço excluído com sucesso.');
    }
}