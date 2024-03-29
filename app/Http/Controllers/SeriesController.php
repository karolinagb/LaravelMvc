<?php

namespace App\Http\Controllers;

use App\Events\SerieApagada;
use App\Events\SerieCriada;
use App\Models\Serie;
use App\Repositories;
use App\Models\Epsodio;
use App\Models\Temporada;
use App\Mail\SeriesCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Middleware\Autenticador;
use App\Repositories\SerieRepository;
use App\Repositories\ISerieRepository;
use App\Http\Requests\SerieFormRequest;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;

class SeriesController extends Controller
{

    //inversão de dependência = ao invés de depende de algo concreto, dependemos de uma abstração
    public function __construct(private ISerieRepository $serieRepository)
    {

        // Para aplicar um middleware a todos os métodos do controller, posso usar o método middleware
            //except - o middleware não será aplicado para o método index
        $this->middleware(Autenticador::class)->except('index');
    }

    //outra sintaxe do controlador:
    // public function __construct(private readonly SerieRepository $serieRepository)
    // {
    // }


    public function index(Request $request)
    {
        //Verifica se o usuário está logado (retorna verdadeiro ou falso)
        //Auth::check();

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
        //store = salva o arquivo no nome de pasta especificado e retorna o caminho q salvou
        //O caminho que ele salva é o padrão q esta defini em config/filesystems.php
        //2 parâmetro public = nome do disco que será utilizado, nesse caso estou informando q ele pode
        //ser salvo em storage/app/public que é uma pasta onde os arquivos ficam acessíveis, se eu quisesse
        //salvar um relatório q vou manipular e n pode ser acessível, por exemplo, salvo só em app e no caso
        //ao invés de public seria local, porém o local já está definido como padrão no env
        //Só que ele não está acessível de fato, se eu acessar no navegador, não consigo abrir a img
        //porém ele salva nessa pasta pra dizer que os arquivos que estão nela podem ser acessíveis
        $caminhoCapa = $request->hasFile('cover')
            ? $request->file("capa")->store('capa_serie', 'public')
            : null;
        //storeAs = salva o arquivo na pasta específica e posso passar o nome que quero dar ao arquivo
        //Se eu não passar o nome, o Laravel cria o nome do arquivo
        //$request->file("capa")->storeAs('capa_serie', 'nome-capa');

        //adicionando o caminhoCapa no request para salvar no banco
        $request->caminhoCapa = $caminhoCapa;

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

        $serie = $this->serieRepository->add($request);

        //dispatch = envia o evento | recebe por parametro tudo que o evento SerieCriada receberia
            // ele pega os parametros e passa pra classe de evento
        SerieCriada::dispatch($serie->nome, $serie->id, $request->quantTemporadas, $request->epsodios);

        //sintaxe alternativa para gerar o evento:
        // $serieCriadaEvento = new SerieCriada($serie->nome, $serie->id, $request->quantTemporadas, $request->epsodios);
        //Como o dispatch é um método estático, eu não poderia chamar ele a partir de uma instância, então posso chamar
        // uma funação auxiliar do laravel que é a event() | isso seria a mesma coisa que chamar o dispatch
        // event($serieCriadaEvento);

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

        if($serie->caminho_capa != null ){
            SerieApagada::dispatch($serie->caminho_capa);
        }

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

    public function update(Serie $series, SerieFormRequest $request)
    {
        //Poderiamos fazer como abaixo mas quando passamos o id na rota e no parametro do controller passamos
            //o tipo do modelo, o Laravel já busca no banco pra gente
        //$serie = Serie::find($id);

        // $serie->nome = $request->nome;
        //Se fosse muitos parâmetros podemos usar o fill, pois definimos na model quais campos podem ser atribuidos
            //o fill vai fazer a atribuição em massa de td q vier do request mas definido na model
        $series->fill($request->all());
        $series->save();

        return redirect()->route('series.index')->with("mensagem.sucesso", "Série '{$series->nome}' atualizada com sucesso");;
    }
}
