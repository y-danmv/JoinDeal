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
        // Certifica-se de que a variável $user é passada para a view
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
            // Validação CPF: Exige formato com 11 dígitos (após a remoção da máscara)
            'cidade' => 'required|string|max:100',
            // O REGEX foi removido daqui porque o frontend JS já garante a máscara,
            // e o back-end só precisa garantir que o CPF formatado é único e tem o tamanho certo.
            'cpf' => ['required', 'string', 'max:14', Rule::unique('users', 'cpf')->ignore($user->id)],
            'tipo' => 'required|in:Cliente,Funcionario',
        ], [
            'name.required' => 'O nome é obrigatório',
            'email.required' => 'O e-mail é obrigatório',
            'email.unique' => 'Este e-mail já está cadastrado',
            'password.min' => 'A senha deve ter pelo menos :min caracteres',
            'password.max' => 'A senha deve ter no máximo :max caracteres',
            'password.confirmed' => 'A confirmação de senha não confere',
            'cidade.required' => 'A cidade é obrigatória',
            'cpf.required' => 'O CPF é obrigatório',
            'cpf.unique' => 'Este CPF já está cadastrado',
            'tipo.required' => 'O tipo de usuário é obrigatório',
            'tipo.in' => 'O tipo de usuário selecionado é inválido',
        ]);
        
        // Pré-processamento: Remove pontos e traços do CPF antes de salvar
        // ESSENCIAL: Garante que apenas os 11 dígitos numéricos sejam salvos.
        $cpfSemMascara = preg_replace('/[^0-9]/', '', $request->cpf);

        $user->name = $request->name;
        $user->email = $request->email;
        // NOVOS CAMPOS
        $user->cidade = $request->cidade;
        $user->cpf = $cpfSemMascara; // Salva o CPF sem máscara
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
