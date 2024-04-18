<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthRegisteredUserController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\EventInfoController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\GuestAttendanceController;


Route::post('/generate-qrcode', [QrCodeController::class, 'generateQrCode']);



// register routes for user authentication
Route::post('/register', [AuthRegisteredUserController::class, "create"]);
Route::post('/login', [AuthRegisteredUserController::class, "login"]);

Route::get('/users', [AuthRegisteredUserController::class, "index"]);
Route::get('/user{id}', [AuthRegisteredUserController::class, "show"]);

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
Route::get('/pull-event-info{id}', [EventInfoController::class,'show']);
// location
Route::get('/all-locations', [LocationController::class, 'index']);
Route::post('/create-location', [LocationController::class, 'store']);
// organizer
Route::get('/all-organizers', [OrganizerController::class, 'index']);
Route::post('/create-organizer', [OrganizerController::class, 'store']);
// ticket
Route::get('/all-tickets', [TicketController::class, 'index']);
Route::post('/create-ticket', [TicketController::class, 'store']);
Route::put('/update-ticket/{id}', [TicketController::class, 'update']);
// social link
Route::post('/social-links', 'App\Http\Controllers\SocialLinkController@storeOrUpdate'); // Assuming namespace is App\Http\Controllers
Route::get('/all-social-links', 'App\Http\Controllers\SocialLinkController@index'); // Assuming namespace is App\Http\Controllers
// media
Route::post('/media', [MediaController::class, 'store']);
Route::get('/all-media', [MediaController::class, 'index']);
// guest
Route::post('/guest', [GuestController::class, 'store']);
Route::get('/all-guests', [GuestController::class, 'index']);
// Route::get('/guest{id}', [GuestController::class,'show']);
// Route::put('/guest{id}', [GuestController::class, 'update']);
// Route::delete('/guest{id}', [GuestController::class, 'destroy']);

// guest attendance
Route::post('/guest-attendance', [GuestAttendanceController::class, 'store']);
Route::get('/all-guest-attendances', [GuestAttendanceController::class, 'index']);
// Route::get('/guest-attendance{id}', [GuestAttendanceController::class,'show']);
