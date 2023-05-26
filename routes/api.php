<?php

use App\Http\Controllers\api\SerieController;
use App\Http\Controllers\SeriesController;
use App\Models\Epsodio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

//middleware do sanctum ja solicita o token para acessar as urls
//O sanctum ja faz toda a verificação do usuário e seu token para logar
Route::middleware('auth:sanctum')->group(function () {

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
});



Route::post('/login', function (Request $request){
    $credenciais = $request->only(['email', 'password']);
    if(Auth::attempt($credenciais) === false) {
        return response()->json("Não Autorizado", 401);
    }

    $token = $request->user()->createToken('token');

    return response()->json($token->plainTextToken);
});
