<?php

use App\Http\Controllers\SeriesController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect('/series');
});

//Porém se seguirmos o padrão de nomenclatura do Laravel, pode simplificar mais
    //parametros = como o grupo de rotas inicia e o nome do controlador
    //Dessa forma ele sabe que se for o metodo create, por exemplo, deve acessar series/create
    //Para isso teriamos que alterar nossas rotas de portugues para ingles
    //se deixar assim ele cria rotas que não estou utilizando, então com o only especificamos qual queremos
Route::resource('/series', SeriesController::class)
    ->only(['index', 'create',  'store']);

// como temos agora uma rota chamada delete utilizando o padrão de resource controller, posso agrupar no resource acima
Route::delete('/series/destroy/{id}', [SeriesController::class, 'destroy'])->name('series.destroy')->whereNumber('id'); //restrições p/ verificar se e numero

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
