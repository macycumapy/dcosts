<?php

declare(strict_types=1);

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CashFlowController;
use App\Http\Controllers\CashInflowController;
use App\Http\Controllers\CashOutflowController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\NomenclatureController;
use App\Http\Controllers\NomenclatureTypeController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\ReportController;
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
    Route::group(['prefix' => '/categories'], function () {
        Route::get('/', [CategoryController::class, 'index']);
        Route::post('/', [CategoryController::class, 'store']);
        Route::get('/{category}', [CategoryController::class, 'show']);
        Route::put('/{category}', [CategoryController::class, 'update']);
        Route::delete('/{category}', [CategoryController::class, 'destroy']);
    });

    /** Расход денежных средств */
    Route::group(['prefix' => '/cash-outflow'], function () {
        Route::get('/', [CashOutflowController::class, 'index']);
        Route::post('/', [CashOutflowController::class, 'store']);
        Route::get('/{id}', [CashOutflowController::class, 'show']);
        Route::put('/{id}', [CashOutflowController::class, 'update']);
        Route::delete('/{id}', [CashOutflowController::class, 'destroy']);
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
        Route::get('/{id}', [CashInflowController::class, 'show']);
        Route::put('/{id}', [CashInflowController::class, 'update']);
        Route::delete('/{id}', [CashInflowController::class, 'destroy']);
    });

    Route::get('/cash-flow', [CashFlowController::class, 'index']);

    /** Отчеты */
    Route::group(['prefix' => '/report'], function () {
        Route::post('/outflows', [ReportController::class, 'getOutflows']);
    });
});
