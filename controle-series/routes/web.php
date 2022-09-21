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
// Route::resource('/series', SeriesController::class)

//agrupando as rotas por controlador
Route::controller(SeriesController::class)->group(function (){
    Route::get('/series', 'index');
    Route::get('/series/criar', 'create');
    Route::post('/series/salvar', 'store');
});

//array = primeira posição - classe controladora - segunda posição - método que deve ser executado
// Route::get('/series', [SeriesController::class, 'index']);
// Route::get('/series/criar', [SeriesController::class, 'create']);
// Route::post('/series/salvar', [SeriesController::class, 'store']);
