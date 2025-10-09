<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{

    public function home()
    {
        return view('home');
    }

    public function login()
    {
        return view('login');
    }
    
    public function loginSubmit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|max:12',
        ], [
            'email.required' => 'O e-mail é obrigatório',
            'email.email' => 'Insira um e-mail válido',
            'password.required' => 'A senha é obrigatória',
            'password.min' => 'A senha deve ter pelo menos :min caracteres',
            'password.max' => 'A senha deve ter no máximo :max caracteres',
        ]);

        
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Usuário não encontrado.'])->withInput();
        }

        // Verifica a senha usando password_verify, conforme o padrão bcrypt/hash do Laravel.
        if (!password_verify($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Senha incorreta.'])->withInput();
        }

        return redirect()->route('home')->with('success', 'Login efetuado com sucesso!');
    }

    public function register()
    {
        return view('register');
    }
    
    
    public function registerSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|max:12|confirmed',
            'cidade' => 'required|string|max:100',
            // Validação CPF: Garante o formato 000.000.000-00 e verifica a unicidade.
            'cpf' => 'required|string|max:14|regex:/^\d{3}\.\d{3}\.\d{3}\-\d{2}$/|unique:users,cpf', 
            'tipo' => 'required|in:Cliente,Funcionario', 
        ], [
            'name.required' => 'O nome é obrigatório',
            'email.required' => 'O e-mail é obrigatório',
            'email.unique' => 'Este e-mail já está cadastrado',
            'password.required' => 'A senha é obrigatória',
            'password.min' => 'A senha deve ter pelo menos :min caracteres',
            'password.max' => 'A senha deve ter no máximo :max caracteres',
            'password.confirmed' => 'A confirmação de senha não confere',
            'cidade.required' => 'A cidade é obrigatória',
            'cpf.required' => 'O CPF é obrigatório',
            // MENSAGEM DE ERRO ESPECÍFICA PARA O FORMATO INVÁLIDO
            'cpf.regex' => 'O CPF deve estar no formato 000.000.000-00.', 
            'cpf.unique' => 'Este CPF já está cadastrado',
            'tipo.required' => 'O tipo de usuário é obrigatório',
            'tipo.in' => 'O tipo de usuário selecionado é inválido',
        ]);

        // Pré-processamento: Remove pontos e traços do CPF para salvar apenas os 11 dígitos numéricos
        $cpfSemMascara = preg_replace('/[^0-9]/', '', $request->cpf);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->cidade = $request->cidade;
        $user->tipo = $request->tipo;
        
        // SALVANDO APENAS NÚMEROS LIMPOS
        $user->cpf = $cpfSemMascara; 
        
        $user->password = bcrypt($request->password); 
        $user->save();

        return redirect()->route('home')->with('success', 'Cadastro efetuado com sucesso!');
    }

    public function logout(Request $request)
    {
        return redirect()->route('login')->with('success', 'Você saiu da sua conta.');
    }
}