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
        return redirect()->route('home')->with('success', 'Login!');
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
        ], [
            'name.required' => 'O nome é obrigatório',
            'email.required' => 'O e-mail é obrigatório',
            'email.unique' => 'Este e-mail já está cadastrado',
            'password.required' => 'A senha é obrigatória',
            'password.min' => 'A senha deve ter pelo menos :min caracteres',
            'password.max' => 'A senha deve ter no máximo :max caracteres',
            'password.confirmed' => 'A confirmação de senha não confere',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->route('home')->with('success', 'Cadastro efetuado com sucesso!');


    }

    public function logout(Request $request)
    {
        return redirect()->route('login')->with('success', 'Você saiu da sua conta.');
    }
}
