<?php

use App\Http\Controllers\api\SerieController;
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
