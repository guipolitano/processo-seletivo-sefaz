<?php

use Illuminate\Http\Request;

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

Route::prefix('v1')->group(function () {
    Route::get('importar/{nomeArquivo}', 'ImportarController@index');
    Route::get('produtos/{gtin?}/{latitude?},{longitude?}', 'ProdutosController@listarProdutos')->middleware('logRequests');
    Route::get('produto/{id?}/{latitude?},{longitude?}', 'ProdutosController@mostrarProduto')->middleware('logRequests');
});
