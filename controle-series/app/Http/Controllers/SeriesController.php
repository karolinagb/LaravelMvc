<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use App\Models\Temporada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\SerieFormRequest;
use App\Models\Epsodio;

class SeriesController extends Controller
{
    public function index(Request $request)
    {
        //transforma em json caso eu coloque o return
        //o laravel pega o retorno e analisa a melhor forma de transformar em uma resposta
            // {{-- o laravel traz um objeto de series e n um array --}}

        $series = Serie::all(); //agora estamos usando o eloquent que retorna uma collection

        //Laravel faz laze loading, nao carrega de uma vez as temporadas da serie, busca conforme eu precise
        //posso mudar isso com o with e definir que quero trazer o relacionamentos de temporadas que definimos tb
        // $series = Serie::with(['temporadas'])->get();
        // Se isso acima for um padrão e todo lugar que eu buscar as Series eu precise das temporadas, posso definir isso na model com o
            //parametro with

        // $series = Serie::all()->sortBy('nome'); //Eu estou criando um query builder, eu estou criando um criador de queries, e aqui
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

    public function store(SerieFormRequest $request)
    {
        //esse método espera algumas regras, se essas não forem satisfeitas o laravel redireciona o usuário de volta para ultima url
            //e adiciona todas as informações do request que não foi válido em uma flash message
        // $request->validate([
        //     'nome' => ['required', 'min:3']
        // ]);
        //Já temos a validação embutida quando passamos como parâmetro o nosso Request customizado ao invés do padrão

        // Serie::create($request->only(['nome'])); //pega somente o nome especificado
        // Serie::create($request->except(['_token'])); //pega todos os dados da requisição com exceção de algum que eu definir


        //pega todos os dados da requisição = mass assignment/atribuição em massa (passar vários dados de uma vez para o modelo)
        //método create insere no banco de dados todas as colunas que eu especificar
        $serie = Serie::create($request->all());

        $temporadas = [];
        for($i = 1; $i <= $request->quantTemporadas; $i++){
            //usando o relacionamento para criar temporadas
                //poderia fazer temporada::create, mas ia ter que ficar informando a chave estrangeira do relacionamento
                //temporadas() pega o relacionamento, propriedade temporadas pega a coleção de temporadas

            //Esse codigo gera uma query para cada inserção
                //Vamos criar um array primeiro e adicionar as temporadas nele
            //     $temporada = $serie->temporadas()->create([
            //     'numero' => $i
            // ]);
            $temporadas[] = [
                //nesse caso não dá para usar o relacionamento para não ter que colocar chave estrangeira
                'serie_id' => $serie->id,
                'numero' => $i
            ];
        }

        Temporada::insert($temporadas); //posso passar um array para o insert ao invés do sql

        $epsodios = [];
        foreach ($serie->temporadas as $temporada) {
            for($j = 1; $j <= $request->epsodios; $j++){
                $epsodios[] = [
                    'temporada_id' => $temporada->id,
                    'numero' => $j
                ];
            }
        }

        Epsodio::insert($epsodios);

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

        // session(['mensagem.sucesso' => "Série {$serie->nome} adicionada com sucesso"]);
        // define e ja apaga da sessao
         // $request->session()->flash('mensagem.sucesso', 'Mensagem');

        //posso usar as rotas nomeadas aqui
            //formas
        // return reredirect(route('series.index'));
        // return to_route('series.index');
        return redirect()->route('series.index')->with('mensagem.sucesso',"Série {$serie->nome} adicionada com sucesso");
    }

    //da para passar o id diretamente sem acesar o request
    public function destroy(int $id, Request $request)
    {
        //Posso colocar no parametro do metodo direto o objeto Serie $serie e não ter que fazer esse find abaixo
        //O Laravel já encontra essa model no banco pra gente

        $serie = Serie::find($id);

        $serie->delete($id);
        //removendo uma série
        // Serie::destroy($request->id);

        //adicionar uma mensagem na sessão
        // $request->session()->put("mensagem.sucesso", "Série removida com sucesso");
        // $request->session()->put("mensagem.sucesso", "Série '{$serie->nome}' removida com sucesso");

        //with permite retornar com um dado na flash session
        //assim posso passar minha flash message diretamente aqui
        return to_route('series.index')
        ->with("mensagem.sucesso", "Série '{$serie->nome}' removida com sucesso");
    }

    public function edit(int $id)
    {
        $serie = Serie::find($id);

        //se eu acessar metodo temporadas(), ao invés de propriedade temporadas, tenho acesso ao relacionamento
            //se eu tenho acesso ao relacionamento eu consigo modificar a query por exemplo, teria um query builder p/
                //filtrar e depois pegar a coleção (exemplo: temporadas()->with)
            //se eu acessar através da propriedade, eu já pego a coleção de temporadas
        // dd($serie->temporadas());

        return view('series.edit')->with('serie', $serie);
    }

    public function update(Serie $serie, SerieFormRequest $request)
    {
        //Poderiamos fazer como abaixo mas quando passamos o id na rota e no parametro do controller passamos
            //o tipo do modelo, o Laravel já busca no banco pra gente
        //$serie = Serie::find($id);

        // $serie->nome = $request->nome;
        //Se fosse muitos parâmetros podemos usar o fill, pois definimos na model quais campos podem ser atribuidos
            //o fill vai fazer a atribuição em massa de td q vier do request mas definido na model
        $serie->fill($request->all());
        $serie->save();

        return redirect()->route('series.index')->with("mensagem.sucesso", "Série '{$serie->nome}' atualizada com sucesso");;
    }
}
