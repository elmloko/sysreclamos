<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::get('/informations', [ApiController::class, 'informations']);
Route::get('/informationsm', [ApiController::class, 'informationsm']);
Route::get('/informationll', [ApiController::class, 'informationll']);
Route::get('/claims', [ApiController::class, 'claims']);
Route::get('/suggestion', [ApiController::class, 'suggestion']);
Route::get('/complaintsa', [ApiController::class, 'complaintsa']);
Route::get('/complaintso', [ApiController::class, 'complaintso']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => ['auth:api']], function() { 
});