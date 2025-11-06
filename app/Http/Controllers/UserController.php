<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Protege o controller (opcional, mas recomendado)
     * Assumindo que apenas usuários logados podem gerenciar outros.
     */
    public function __construct()
    {
        // $this->middleware('auth');
        // Você pode adicionar middlewares de admin aqui se desejar
    }

    /**
     * Mostra a lista de usuários.
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Mostra os detalhes de um usuário.
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Mostra o formulário de edição de um usuário.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Atualiza um usuário no banco de dados.
     */
    public function update(Request $request, User $user)
    {
        // Validação (ajustado para 'nome')
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:100', // Campo 'nome'
            'email' => [
                'required',
                'string',
                'email',
                'max:100',
                Rule::unique('users')->ignore($user->id), // Ignora o email do próprio usuário
            ],
            'cpf' => [
                'required',
                'string',
                'max:14',
                Rule::unique('users')->ignore($user->id), // Ignora o CPF do próprio usuário
            ],
            'cidade' => 'required|string|max:100',
            'tipo' => ['required', Rule::in(['Cliente', 'Prestador'])], // 'Prestador'
            
            // Validação de senha (somente se o campo 'password' for preenchido)
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        // Pega os dados validados
        $data = $validator->validated();
        
        // Remove a máscara do CPF (XXX.XXX.XXX-XX) antes de salvar
        $data['cpf'] = preg_replace('/\D/', '', $data['cpf']);

        // Verifica se a senha foi alterada
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            // Se a senha veio vazia, remove ela do array $data
            // para não sobrescrever a senha atual no banco com 'null'
            unset($data['password']);
        }
        
        // Atualiza o usuário
        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso!');
    }

    /**
     * Remove (Soft Delete) um usuário.
     */
    public function destroy(User $user)
    {
        // Opcional: não permitir que o usuário se auto-delete
        // if ($user->id === Auth::id()) {
        //     return redirect()->route('users.index')->with('error', 'Você não pode excluir seu próprio usuário.');
        // }

        $user->delete(); // Soft delete
        return redirect()->route('users.index')->with('success', 'Usuário excluído com sucesso.');
    }
}