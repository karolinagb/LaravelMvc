<?php


use App\Http\Middleware\Autenticador;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\EpsodiosController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\TemporadasController;
use App\Mail\SeriesCreated;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('autenticador')->group(function ()
{
    Route::get('/', function () {
        return redirect('/series');
    })->middleware(Autenticador::class);

    Route::get('/series/{id}/temporadas', [TemporadasController::class, 'index'])
    ->name('temporadas.index');

    Route::get('/temporadas/{id}/epsodios', [EpsodiosController::class, 'index'])->name('epsodios.index');
    Route::post('/temporadas/{temporada}/epsodios/update', [EpsodiosController::class, 'update'])->name('epsodios.update');

    //Quando temos uma classe de email, o Laravel já sabe que tem que retornar o html dela
    Route::get('/email', function (){
        return new SeriesCreated('Teste', 2, 3, 1);
    });
});




Route::get('/series/edit/{id}', [SeriesController::class, 'edit'])->name('series.edit')->whereNumber('id');

// como temos agora uma rota chamada delete utilizando o padrão de resource controller, posso agrupar no resource acima
Route::delete('/series/destroy/{id}', [SeriesController::class, 'destroy'])->name('series.destroy')->whereNumber('id'); //restrições p/ verificar se e numero

//Porém se seguirmos o padrão de nomenclatura do Laravel, pode simplificar mais
//parametros = como o grupo de rotas inicia e o nome do controlador
//Dessa forma ele sabe que se for o metodo create, por exemplo, deve acessar series/create
//Para isso teriamos que alterar nossas rotas de portugues para ingles
//se deixar assim ele cria rotas que não estou utilizando, então com o only especificamos qual queremos
Route::resource('/series', SeriesController::class)
->only(['index', 'create',  'store', 'update']);



//agrupando as rotas por controlador
// Route::controller(SeriesController::class)->group(function (){
//     //name = informa o nome da rota, posso passar isso para a view a fim de nao ter que ficar trocando la
//         //quando eu alterar a rota
//         //rota nomeada é como um apelido para a rota, mas a rota continua sendo a mesma
//     Route::get('/series', 'index')->name('series.index');
//     Route::get('/series/create', 'create')->name('series.create');
//     Route::post('/series/salvar', 'store')->name('series.store');
// });

//array = primeira posição - classe controladora - segunda posição - método que deve ser executado
// Route::get('/series', [SeriesController::class, 'index']);
// Route::get('/series/criar', [SeriesController::class, 'create']);
// Route::post('/series/salvar', [SeriesController::class, 'store']);

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('entrar');

Route::get('/registrar', [UsuariosController::class, 'create'])->name('usuarios.create');
Route::post('/registrar', [UsuariosController::class, 'store'])->name('usuarios.store');

Route::get('/logout', [LoginController::class, 'destroy'])->name('usuarios.logout');
