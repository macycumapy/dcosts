<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CashInflowController;
use App\Http\Controllers\CashOutflowController;
use App\Http\Controllers\CostItemController;
use App\Http\Controllers\NomenclatureController;
use App\Http\Controllers\NomenclatureTypeController;
use App\Http\Controllers\PartnerController;
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

    /** Статьи затрат */
    Route::group(['prefix' => '/cost-items'], function () {
        Route::get('/', [CostItemController::class, 'index']);
        Route::post('/', [CostItemController::class, 'store']);
        Route::get('/{costItem}', [CostItemController::class, 'show']);
        Route::put('/{costItem}', [CostItemController::class, 'update']);
        Route::delete('/{costItem}', [CostItemController::class, 'destroy']);
    });

    /** Расход денежных средств */
    Route::group(['prefix' => '/cash-outflow'], function () {
        Route::get('/', [CashOutflowController::class, 'index']);
        Route::post('/', [CashOutflowController::class, 'store']);
        Route::get('/{cashOutflow}', [CashOutflowController::class, 'show']);
        Route::put('/{cashOutflow}', [CashOutflowController::class, 'update']);
        Route::delete('/{cashOutflow}', [CashOutflowController::class, 'destroy']);
    });

    /** Контрагенты */
    Route::group(['prefix' => '/partners'], function () {
        Route::get('/', [PartnerController::class, 'index']);
        Route::post('/', [PartnerController::class, 'store']);
        Route::get('/{partner}', [PartnerController::class, 'show']);
        Route::put('/{partner}', [PartnerController::class, 'update']);
        Route::delete('/{partner}', [PartnerController::class, 'destroy']);
    });

    /** Расход денежных средств */
    Route::group(['prefix' => '/cash-inflow'], function () {
        Route::get('/', [CashInflowController::class, 'index']);
        Route::post('/', [CashInflowController::class, 'store']);
        Route::get('/{cashInflow}', [CashInflowController::class, 'show']);
        Route::put('/{cashInflow}', [CashInflowController::class, 'update']);
        Route::delete('/{cashInflow}', [CashInflowController::class, 'destroy']);
    });
});
