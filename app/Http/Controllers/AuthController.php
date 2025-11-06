<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Importar o Model
use Illuminate\Support\Facades\Auth; // Para autenticação
use Illuminate\Support\Facades\Hash; // Para criptografar senha
use Illuminate\Support\Facades\Validator; // Para validação
use Illuminate\Validation\Rule; // Para regras de validação
use Carbon\Carbon; // Para data/hora

class AuthController extends Controller
{
    /**
     * Mostra a página Home (view 'home')
     */
    public function home()
    {
        return view('home'); // Assumindo que você tem 'home.blade.php'
    }

    /**
     * Mostra o formulário de login (view 'auth.login')
     */
    public function login()
    {
        return view('auth.login');
    }

    /**
     * Mostra o formulário de registro (view 'auth.register')
     */
    public function register()
    {
        return view('auth.register');
    }

    /**
     * Processa o formulário de Registro
     */
    public function registerSubmit(Request $request)
    {
        // Validação dos dados (ajustado para 'nome')
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:100', // Campo 'nome'
            'email' => 'required|string|email|max:100|unique:users',
            'cpf' => 'required|string|max:14|unique:users', // CPF único
            'cidade' => 'required|string|max:100',
            'tipo' => ['required', Rule::in(['Cliente', 'Prestador'])], // 'Prestador'
            'password' => 'required|string|min:8|confirmed', // 'confirmed' verifica 'password_confirmation'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        // Remove a máscara do CPF (XXX.XXX.XXX-XX) antes de salvar
        $cpfLimpo = preg_replace('/\D/', '', $request->cpf);

        // Cria o usuário
        $user = User::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'cpf' => $cpfLimpo, // Salva CPF limpo
            'cidade' => $request->cidade,
            'tipo' => $request->tipo,
            'password' => Hash::make($request->password),
        ]);

        // Loga o usuário automaticamente após o registro
        Auth::login($user);

        return redirect()->route('home')->with('success', 'Cadastro realizado com sucesso!');
    }


    /**
     * Processa o formulário de Login
     */
    public function loginSubmit(Request $request)
    {
        // Validação
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Atualiza o 'last_login'
            $user = Auth::user();
            $user->last_login = Carbon::now();
            $user->save();
            
            // Regenera a sessão
            $request->session()->regenerate();

            return redirect()->intended('home')->with('success', 'Login efetuado com sucesso!');
        }

        // Falha no login
        return back()->withErrors([
            'email' => 'As credenciais fornecidas não correspondem aos nossos registros.',
        ])->withInput($request->only('email'));
    }

    /**
     * Processa o Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Você saiu da sua conta.');
    }
}