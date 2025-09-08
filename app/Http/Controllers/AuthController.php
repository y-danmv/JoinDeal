<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class AuthController extends Controller
{
    public function login(){
        return view('login');
    }

    public function loginSubmit(Request $request){
        // Obtendo dados do request
        // dd($request);

        $request->validate([
            'text_username' => 'required|email',
            'text_password' => 'required|min:6|max:12',
        ],
        [
            //Mensagem para text_username
            'text_username.required' => 'O campo de e-mail é obrigatório',
            'text_username.email' => 'O campo de e-mail deve conter um endereço válido',

            //Mensagem para text_password
            'text_password.required' => 'A senha é obrigatória',
            'text_password.min' => 'A senha deve ter pelo menos :min caracteres',
            'text_password.max' => 'A senha deve ter no máximo :max caracteres',

        ]
    );

        $username = $request->input('text_username');
        $password = $request->input('text_password');
        // return "OK";
        // echo "Usuário: " . $username . "<BR>";
        // echo "Password: " . $password;

        // try{
        //     DB::connection()->getPdo();
        //     echo "Conexão com o banco de dados feita com sucesso!";
        // } catch(\PDOException $e){
        //     echo "A conexão falhou: " . $e->getMessage();
        // }

        // $usuarios = User::all()->toArray();
        // echo '<pre>';
        // print_r($usuarios);
        // echo '</pre>';

        //Selecionando apenas 1 usuario
        $user = User::where('username', $username)
                      ->whereNull('deleted_at')
                      ->first();
        echo '<pre>';
        print_r($user);
        echo '</pre>';

    }



    public function logout(){
        echo 'Desconectado';
    }


}
