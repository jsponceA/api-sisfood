<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConsumptionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkerController;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

/*
|--------------------------------------------------------------------------
| API Routes VERSION 1
|--------------------------------------------------------------------------
*/

Route::get("/",fn () => response()->json(["message"=>"PRIVATE SERVICE REST"]));

/* START AUTH ROUTES */
Route::post("login",[AuthController::class,"login"]);
Route::post("logout",[AuthController::class,"logout"])->middleware(['auth:sanctum']);
/* END AUTH ROUTES */

/* START PROTECTED ROUTES */
Route::middleware("auth:sanctum")->group(function (){

    /* start routes profile*/
    Route::apiResource("profile",ProfileController::class)->only(["show","update"]);
    /* end routes profile*/

    /* start routes users*/
    Route::get("users/getAllResources",[UserController::class,"getAllResources"]);
    Route::apiResource("users",UserController::class);
    /* end routes users*/

    /* start routes workers*/
    Route::post("workers/generateExcel",[WorkerController::class,"generateExcel"]);
    Route::post("workers/generatePdf",[WorkerController::class,"generatePdf"]);
    Route::get("workers/searchSensitive",[WorkerController::class,"searchSensitive"]);
    Route::get("workers/getAllResources",[WorkerController::class,"getAllResources"]);
    Route::apiResource("workers",WorkerController::class);
    /* end routes workers*/

    /* start routes products*/
    Route::get("products/searchSensitive",[ProductController::class,"searchSensitive"]);
    Route::get("products/getAllResources",[ProductController::class,"getAllResources"]);
    Route::apiResource("products",ProductController::class);
    /* end routes products*/

    /* start routes sales*/
    Route::post("sales/generateTicket",[SaleController::class,"generateTicket"]);
    Route::post("sales/subVencionStore",[SaleController::class,"subVencionStore"]);
    Route::get("sales/getAllResources",[SaleController::class,"getAllResources"]);
    Route::apiResource("sales",SaleController::class);
    /* end routes sales*/

    /* start routes consumption*/
    Route::post("consumptions/generateExcelConsumption",[ConsumptionController::class,"generateExcelConsumption"]);
    Route::post("consumptions/generateExcelSubvencion",[ConsumptionController::class,"generateExcelSubvencion"]);
    Route::get("consumptions/getAllResources",[ConsumptionController::class,"getAllResources"]);
    Route::apiResource("consumptions",ConsumptionController::class);
    /* end routes consumption*/

});
/* END PROTECTED ROUTES */


Route::fallback(fn () => response()->json(["message"=>"RESOURCE NOT FOUND"],Response::HTTP_NOT_FOUND));
