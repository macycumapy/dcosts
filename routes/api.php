<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\NomenclatureController;
use App\Http\Controllers\NomenclatureTypeController;
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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'signin']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'signout']);

    /** Типы номенклатуры */
    Route::group(['prefix' => '/nomenclature-types'], function () {
        Route::get('/', [NomenclatureTypeController::class, 'index']);
        Route::post('/', [NomenclatureTypeController::class, 'store']);
        Route::get('/{nomenclatureType}', [NomenclatureTypeController::class, 'show']);
        Route::put('/{nomenclatureType}', [NomenclatureTypeController::class, 'update']);
        Route::delete('/{nomenclatureType}', [NomenclatureTypeController::class, 'destroy']);
    });

    /** Номенклатура */
    Route::group(['prefix' => '/nomenclatures'], function () {
        Route::get('/', [NomenclatureController::class, 'index']);
        Route::post('/', [NomenclatureController::class, 'store']);
        Route::get('/{nomenclature}', [NomenclatureController::class, 'show']);
        Route::put('/{nomenclature}', [NomenclatureController::class, 'update']);
        Route::delete('/{nomenclature}', [NomenclatureController::class, 'destroy']);
    });
});
