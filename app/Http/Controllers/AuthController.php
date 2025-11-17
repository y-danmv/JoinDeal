<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order; // Importado para o Dashboard
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class AuthController extends Controller
{
    /**
     * Mostra a Home (Se deslogado: Landing Page | Se logado: Dashboard)
     */
    public function home()
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Conta quantas contratações eu fiz como cliente
            $totalCompras = Order::where('cliente_id', $user->id)->count();

            // Variáveis para Prestador
            $totalMeusServicos = 0;
            $totalVendas = 0;

            if ($user->tipo == 'Prestador') {
                $totalMeusServicos = $user->services()->count();
                $totalVendas = $user->ordersAsProvider()->count();
            }

            return view('home', compact('totalCompras', 'totalMeusServicos', 'totalVendas'));
        }

        return view('home'); // Visitante
    }

    /**
     * Mostra o formulário de login
     */
    public function login()
    {
        return view('auth.login');
    }

    /**
     * Mostra o formulário de registro
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
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:users',
            'cpf' => 'required|string|max:14|unique:users',
            'cidade' => 'required|string|max:100',
            'tipo' => ['required', Rule::in(['Cliente', 'Prestador'])],
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $cpfLimpo = preg_replace('/\D/', '', $request->cpf);

        $user = User::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'cpf' => $cpfLimpo,
            'cidade' => $request->cidade,
            'tipo' => $request->tipo,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('home')->with('success', 'Cadastro realizado com sucesso!');
    }


    /**
     * Processa o formulário de Login
     */
    public function loginSubmit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $user->last_login = Carbon::now();
            $user->save();
            
            $request->session()->regenerate();

            // <-- CORREÇÃO AQUI
            // Mudei 'home' (que é o caminho URL) para '/' (o caminho raiz do site)
            return redirect()->intended('/')->with('success', 'Login efetuado com sucesso!');
        }

        return back()->withErrors([
            'email' => 'As credenciais fornecidas não correspondem.',
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