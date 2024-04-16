<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthRegisteredUserController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\EventInfoController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\OrganizerController;

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

    // EventInfo
    Route::get('/all-events', [EventInfoController::class, 'index']);
    Route::post('/create-event', [EventInfoController::class, 'store']);
    // location
    Route::get('/all-locations', [LocationController::class, 'index']);
    Route::post('/create-location', [LocationController::class, 'store']);
    // organizer
    Route::get('/all-organizers', [OrganizerController::class, 'index']);
    Route::post('/create-organizer', [OrganizerController::class, 'store']);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {

    // ... Add routes for other CRUD operations
