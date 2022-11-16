<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController
{
    public function index()
    {
        return view('login.index');
    }

    public function store(Request $request)
    {
        //Facade = é uma fachada para um sistema mais complexo
            //oferece um subsistema pra gente de autenticação nesse caso
        //attempt = tenta buscar o usuário, se esse usuário for encontrado, tenta realizar o login dele
            //verificando se a senha em hash está correta. Se tudo estiver correto ele já armazena o usuário em sessão.
        if(!Auth::attempt($request->all()))
        {
            //back = redireciona de volta para a ultima rota
            return redirect()->back()->withErrors(['Usuário com e-mail ou senha inválidos']);
            // return redirect('entrar');
        }
    }
}
