<?php

use App\Http\Controllers\api\SerieController;
use App\Http\Controllers\SeriesController;
use App\Models\Epsodio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::apiResource('/series', SeriesController::class);
Route::get('/series', [SerieController::class, 'getSeries']);
Route::post('/series', [SerieController::class, 'store']);
Route::get('/series/{id}', [SerieController::class, 'show']);
Route::put('/series/{id}', [SerieController::class, 'update']);
Route::delete('/series/{id}', [SerieController::class, 'destroy']);
Route::get('/series/{id}/temporadas', [SerieController::class, 'getTemporadas']);
Route::get('/series/{id}/epsodios', [SerieController::class, 'getEpsodios']);
Route::patch('/epsodios/{id}', function(int $id, Request $request) {
    $epsodio = Epsodio::find($id);
    $epsodio->assistido = $request->assistido;
    $epsodio->save();
    
    return $epsodio;
});
