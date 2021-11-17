<?php

use App\Http\Controllers\APIController;
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


// Listado de api
Route::get('/establecimiento/{establecimiento}', [APIController::class, 'show'])->name('api.establecimiento');
Route::get('/establecimientos', [APIController::class, 'index'])->name('api.establecimientos');

Route::get('/categorias', [APIController::class, 'categorias'])->name('api.categorias');
Route::get('/categorias/{categoria}', [APIController::class, 'categoria'])->name('api.categoria');
Route::get('/categoria/{categoria}', [APIController::class, 'categoriaTodos'])->name('api.categoriaTodos');

