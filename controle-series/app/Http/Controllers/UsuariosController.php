<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsuariosController
{
    public function create()
    {
        return view('usuarios.create');
    }

    public function store(Request $request)
    {
        $dados = $request->except(['_token']); //retirando o token de csrf que vem do request

        //poderia fazer um hash da senha com a função do php
        // $dados['password'] = password_hash($dados['password'], PASSWORD_DEFAULT);
        //ou posso usar a facade de Hash que já usa as funções do php por trás dos panos
        $dados['password'] = Hash::make($dados['password']);

        $user = User::create($dados);
        // dd($dados['senha']);
        //tornar usuário logado de uma vez
        Auth::login($user);

        return to_route('series.index');
    }
}
