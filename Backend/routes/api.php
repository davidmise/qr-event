<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthRegisteredUserController;
use App\Http\Controllers\QrCodeController;

Route::post('/generate-qrcode', [QrCodeController::class, 'generateQrCode']);



// register routes for user authentication
Route::post('/register',[AuthRegisteredUserController::class, "create"]);
Route::post('/login',[AuthRegisteredUserController::class, "login"]);

Route::get('/users',[AuthRegisteredUserController::class, "index"]);
Route::get('/user{id}',[AuthRegisteredUserController::class, "show"]);

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
