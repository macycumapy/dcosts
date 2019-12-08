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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group( function () {
    Route::resource('nomenclature_types', 'Api\NomenclatureTypeController')
        ->only(['index', 'store', 'show', 'update', 'destroy']);

    Route::resource('nomenclature', 'Api\NomenclatureController')
        ->only(['index', 'store', 'show', 'update', 'destroy']);

    Route::resource('cash_flow', 'Api\CashFlowController')
        ->only(['index', 'store', 'show', 'update', 'destroy']);

    Route::resource('cost_item', 'Api\CostItemController')
        ->only(['index', 'store', 'show', 'update', 'destroy']);
});
