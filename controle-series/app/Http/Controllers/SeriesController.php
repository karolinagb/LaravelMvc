<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SeriesController extends Controller
{
    public function index(Request $request)
    {
        //transforma em json caso eu coloque o return
        //o laravel pega o retorno e analisa a melhor forma de transformar em uma resposta
        $series = [
            'A',
            'B',
            'C'
        ];

        // return view('listar-series', [
        //     //nome da variavel que será criada na view e conteúdo a ela atribuído
        //     'series' => $series
        // ]);

        //compact pega o argumento que passamos como string e paga a variável do contexto com o mesmo nome
        //e cria um array onde a chave é a string que defini e o valor é a variável do contexto
        return view('listar-series', compact('series'));
    }
}
