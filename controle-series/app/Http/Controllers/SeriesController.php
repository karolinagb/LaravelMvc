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


        //pegando um item da sessão
        // $mensagemSucesso = $request->session()->get('mensagem.sucesso');
        // posso buscar direto da sessão tb com a função session:
            //tb da para adicioanr algo a sessao com essa função session(['mensagem' => 'Teste'])
        $mensagemSucesso = session('mensagem.sucesso');

        //esquecer a mensagem / apagar
        $request->session()->forget('mensagem.sucesso');



        // return view('listar-series', [
        //     //nome da variavel que será criada na view e conteúdo a ela atribuído
        //     'series' => $series
        // ]);

        //compact pega o argumento que passamos como string e paga a variável do contexto com o mesmo nome
        //e cria um array onde a chave é a string que defini e o valor é a variável do contexto
        // return view('listar-series', compact('series'));

        //series.index = o ponto indica a separação de diretórios
        return view('series.index')->with('series', $series)->with('mensagemSucesso', $mensagemSucesso); //adicionando o dado na view
    }

    public function create()
    {
        return view('series.create');
    }

    public function store(Request $request)
    {
        // Serie::create($request->only(['nome'])); //pega somente o nome especificado
        // Serie::create($request->except(['_token'])); //pega todos os dados da requisição com exceção de algum que eu definir


        //pega todos os dados da requisição = mass assignment/atribuição em massa (passar vários dados de uma vez para o modelo)
        //método create insere no banco de dados todas as colunas que eu especificar
        $serie = Serie::create($request->all());

        //OBS: Sempre que for usar mass assigment tem que informar quais campos podem sera atribuidos dessa forma, isso é para que na insira
        //na model, campos desnecessários

        //input já faz o filter de string onde a gente não pega caracteres especiais e etc
        // $nome = $request->input('nome');
        //da para pegar o nome assim tb, por baixo dos panos é usado os metodos magicos do php
            //Caso nome nao exista no corpo da requisição, o Laravel tenta buscar nos parametros da rota
        // $nome = $request->nome;
        // $serie = new Serie();
        // $serie->nome = $nome;
        // $serie->save();

        session(['mensagem.sucesso' => "Série {$serie->nome} adicionada com sucesso"]);
        // define e ja apaga da sessao
         // $request->session()->flash('mensagem.sucesso', 'Mensagem');

        //posso usar as rotas nomeadas aqui
            //formas
        // return reredirect(route('series.index'));
        // return to_route('series.index');
        return redirect()->route('series.index');
    }

    //da para passar o id diretamente sem acesar o request
    public function destroy(int $id, Request $request)
    {
        //Posso colocar no parametro do metodo direto o objeto Serie $serie e não ter que fazer esse find abaixo

        $serie = Serie::find($id);

        $serie->delete($id);
        //removendo uma série
        // Serie::destroy($request->id);

        //adicionar uma mensagem na sessão
        // $request->session()->put("mensagem.sucesso", "Série removida com sucesso");
        $request->session()->put("mensagem.sucesso", "Série '{$serie->nome}' removida com sucesso");

        return to_route('series.index');
    }
}
