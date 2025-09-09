<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    // Página inicial
    public function home()
    {
        return view('home');
    }

    // Exibe formulário de login
    public function login()
    {
        return view('login');
    }

    // Processa login
    public function loginSubmit(Request $request)
    {
        $request->validate([
            'text_username' => 'required|email',
            'text_password' => 'required|min:6|max:12',
        ], [
            'text_username.required' => 'O campo de e-mail é obrigatório',
            'text_username.email' => 'Digite um e-mail válido',
            'text_password.required' => 'A senha é obrigatória',
            'text_password.min' => 'A senha deve ter pelo menos :min caracteres',
            'text_password.max' => 'A senha deve ter no máximo :max caracteres',
        ]);

        $credentials = [
            'email' => $request->input('text_username'),
            'password' => $request->input('text_password'),
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Atualiza last_login
            $user = Auth::user();
            $user->last_login = now();
            $user->save();

            return redirect()->route('home')->with('success', 'Login realizado com sucesso!');
        }

        return back()->withErrors([
            'text_username' => 'E-mail ou senha inválidos.',
        ])->onlyInput('text_username');
    }

    // Exibe formulário de registro
    public function register()
    {
        return view('register');
    }

    // Processa registro
    public function registerSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|max:12|confirmed',
        ], [
            'name.required' => 'O nome é obrigatório',
            'email.required' => 'O e-mail é obrigatório',
            'email.unique' => 'Este e-mail já está cadastrado',
            'password.required' => 'A senha é obrigatória',
            'password.min' => 'A senha deve ter pelo menos :min caracteres',
            'password.max' => 'A senha deve ter no máximo :max caracteres',
            'password.confirmed' => 'A confirmação de senha não confere',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Faz login automático após cadastro
        Auth::login($user);

        return redirect()->route('home')->with('success', 'Cadastro realizado com sucesso! Bem-vindo ao JoinDeal!');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Você saiu da sua conta.');
    }
}
