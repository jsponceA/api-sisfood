<?php

use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get("/",fn () => response()->json(["message"=>"PRIVATE SERVICE REST"]));
Route::get("optimize",[\App\Http\Controllers\TestController::class,"optimize"]);
Route::get("optimize-clear",[\App\Http\Controllers\TestController::class,"optimizeClear"]);
Route::get("genera-link-storage",[\App\Http\Controllers\TestController::class,"generaLinkStorage"]);
Route::fallback(fn () => response()->json(["message"=>"RESOURCE NOT FOUND"],Response::HTTP_NOT_FOUND));
