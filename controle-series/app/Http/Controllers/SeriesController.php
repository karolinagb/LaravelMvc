<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeriesController extends Controller
{
    public function index(Request $request)
    {
        //transforma em json caso eu coloque o return
        //o laravel pega o retorno e analisa a melhor forma de transformar em uma resposta
            // {{-- o laravel traz um objeto de series e n um array --}}

        // $series = Serie::all(); //agora estamos usando o eloquent que retorna uma collection

        $series = Serie::all()->sortBy('nome'); //Eu estou criando um query builder, eu estou criando um criador de queries, e aqui
        //nessa query eu posso fazer várias coisas
        //o get serve para executar a query e buscar os resultados dela

        // return view('listar-series', [
        //     //nome da variavel que será criada na view e conteúdo a ela atribuído
        //     'series' => $series
        // ]);

        //compact pega o argumento que passamos como string e paga a variável do contexto com o mesmo nome
        //e cria um array onde a chave é a string que defini e o valor é a variável do contexto
        // return view('listar-series', compact('series'));

        //series.index = o ponto indica a separação de diretórios
        return view('series.index')->with('series', $series);
    }

    public function create()
    {
        return view('series.create');
    }

    public function store(Request $request)
    {
        //input já faz o filter de string onde a gente não pega caracteres especiais e etc
        $nome = $request->input('nome');

        $serie = new Serie();
        $serie->nome = $nome;
        $serie->save();

        return redirect('/series');
    }
}
