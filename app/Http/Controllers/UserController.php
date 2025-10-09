<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * READ: Exibe uma lista de usuários.
     */
    public function index()
    {
        // Obtém todos os usuários do banco de dados
        $users = User::all(); 
        
        // Retorna a view de listagem, passando os usuários
        return view('users.index', compact('users'));
    }

    
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }
    
    /**
     * UPDATE (Edit): Exibe o formulário para editar um usuário.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * UPDATE (Submit): Atualiza o usuário no banco de dados.
     */
     public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)], 
            'password' => 'nullable|min:6|max:12|confirmed', 
            // NOVAS VALIDAÇÕES
            'cidade' => 'required|string|max:100',
            'cpf' => ['required', 'string', 'max:14', Rule::unique('users')->ignore($user->id)],
            'tipo' => 'required|in:Cliente,Funcionario',
        ], [
            'name.required' => 'O nome é obrigatório',
            'email.required' => 'O e-mail é obrigatório',
            'email.unique' => 'Este e-mail já está cadastrado',
            'password.min' => 'A senha deve ter pelo menos :min caracteres',
            'password.max' => 'A senha deve ter no máximo :max caracteres',
            'password.confirmed' => 'A confirmação de senha não confere',
            // NOVAS MENSAGENS DE ERRO
            'cidade.required' => 'A cidade é obrigatória',
            'cpf.required' => 'O CPF é obrigatório',
            'cpf.unique' => 'Este CPF já está cadastrado',
            'tipo.required' => 'O tipo de usuário é obrigatório',
            'tipo.in' => 'O tipo de usuário selecionado é inválido',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        // NOVOS CAMPOS
        $user->cidade = $request->cidade;
        $user->cpf = $request->cpf;
        $user->tipo = $request->tipo;
        // FIM NOVOS CAMPOS
        
        if ($request->filled('password')) { 
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso!');
    }

    /**
     * DELETE: Remove um usuário do banco de dados.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Usuário excluído com sucesso!');
    }
}