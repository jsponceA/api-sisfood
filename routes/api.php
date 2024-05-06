<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConsumptionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PastSaleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\TestController;
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

Route::get("setearTodosDesayunos",[TestController::class,"setearTodosDesayunos"]);
//Route::post("test/importarExcelTrabajador",[TestController::class,"importarExcelTrabajador"]);

//Route::get("products/updateBarCodes",[ProductController::class,"updateBarCodes"]);

/* START AUTH ROUTES */
Route::post("login",[AuthController::class,"login"]);
Route::post("logout",[AuthController::class,"logout"])->middleware(['auth:sanctum']);
/* END AUTH ROUTES */

/* START PROTECTED ROUTES */
Route::middleware(["auth:sanctum"])->group(function (){

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
    Route::get("products/searchOneProduct",[ProductController::class,"searchOneProduct"]);
    Route::get("products/searchSensitive",[ProductController::class,"searchSensitive"]);
    Route::get("products/getAllResources",[ProductController::class,"getAllResources"]);
    Route::apiResource("products",ProductController::class);
    /* end routes products*/

    /* start routes sales*/
    Route::post("sales/totalsSaleProductsByCategory",[SaleController::class,"totalsSaleProductsByCategory"]);
    Route::post("sales/generateTicket",[SaleController::class,"generateTicket"]);
    Route::post("sales/subVencionStore",[SaleController::class,"subVencionStore"]);
    Route::get("sales/getAllResources",[SaleController::class,"getAllResources"]);
    Route::apiResource("sales",SaleController::class);
    /* end routes sales*/

    /* start routes past sales*/
    Route::post("pastSales/generateTicket",[PastSaleController::class,"generateTicket"]);
    Route::post("pastSales/subVencionStore",[PastSaleController::class,"subVencionStore"]);
    Route::get("pastSales/getAllResources",[PastSaleController::class,"getAllResources"]);
    Route::apiResource("pastSales",PastSaleController::class);
    /* end routes past sales*/

    /* start routes consumption*/
    Route::post("consumptions/generateExcelWorkerSummary",[ConsumptionController::class,"generateExcelWorkerSummary"]);
    Route::post("consumptions/generateExcelConsumption",[ConsumptionController::class,"generateExcelConsumption"]);
    Route::post("consumptions/generateExcelSubvencion",[ConsumptionController::class,"generateExcelSubvencion"]);
    Route::get("consumptions/getAllResources",[ConsumptionController::class,"getAllResources"]);
    Route::apiResource("consumptions",ConsumptionController::class);
    /* end routes consumption*/

    /* start routes home dashboard */
    Route::get("home/getSalesProductCount",[HomeController::class,"getSalesProductCount"]);
    Route::get("home/getAllResources",[HomeController::class,"getAllResources"]);


    /* end routes home dashboard */

});
/* END PROTECTED ROUTES */


Route::fallback(fn () => response()->json(["message"=>"RESOURCE NOT FOUND"],Response::HTTP_NOT_FOUND));
