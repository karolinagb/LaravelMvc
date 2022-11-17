<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Autenticador
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        //request = requisição recebida
        //next = o laravel que coordena, o próximo pode ser outro middleware ou a ação do controlador mesmo
        //se eu quiser, posso receber oq vai ser retornado de next e tratar a resposta tb

        if(!Auth::check()){
            // Se for lançada uma exceção de autenticação, o Laravel redireciona pro login
            throw new AuthenticationException();
        }

        return $next($request);
    }
}
