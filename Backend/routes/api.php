<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\EventInfoController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\TicketController;
// use App\Http\Controllers\MediaController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\GuestAttendanceController;
use App\Http\Controllers\GoogleSheetsController;
use App\Http\Controllers\GuestListController;

use App\Http\Controllers\SMSController;

Route::post('/send-sms', [SMSController::class, 'sendBulkSMS']);

// Public routes (no authentication required)
Route::post('/register', 'App\Http\Controllers\UserController@create');

// Route::post('/login', [AuthRegisteredUserController::class, "login"])->name('login');
Route::post('/login', [AuthController::class, "login"])->name('login');
Route::post('/forgot', [AuthController::class, "forgot"]);
Route::post('/reset', [AuthController::class, "reset"]);
 // Qr-code
 Route::post('/generate-qrCode', [QrCodeController::class, 'generateQrCode']);
 // show single event
 Route::get('/pull-event-info{id}', [EventInfoController::class,'show']);


// Protected routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
// logout
    Route::post('/logout', [AuthController::class, "logout"]);
// google-sheets
    Route::get('/google-sheets', [GoogleSheetsController::class, 'index']);

   // User routes accessible only by admin
   Route::middleware('auth.admin')->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    // Route::get('/user{id}', [UserController::class, 'show']);
    Route::put('/update-user{id}', [UserController::class, 'update']);
    Route::delete('/delete-user{id}', [UserController::class, 'destroy']);
    Route::get('/search-user', [UserController::class, 'search']);

});
// doorman
Route::get('/user{id}', [UserController::class, 'show']);
Route::post('/mark-attendance', [GuestController::class, 'markAttendance']);
Route::get('/events/{eventId}/guests', [EventInfoController::class, 'guests']);

    // EventInfo
    Route::get('/all-events', [EventInfoController::class, 'index']);
    Route::post('/create-event', [EventInfoController::class, 'store']);

    Route::get('/search-event', [EventInfoController::class, 'search']);

    // Location
    Route::get('/all-locations', [LocationController::class, 'index']);
    Route::post('/create-location', [LocationController::class, 'store']);

    // Organizer
    Route::get('/all-organizers', [OrganizerController::class, 'index']);
    Route::post('/create-organizer', [OrganizerController::class, 'store']);

    // Ticket
    Route::get('/all-tickets', [TicketController::class, 'index']);
    Route::post('/create-ticket', [TicketController::class, 'store']);
    Route::put('/update-ticket/{id}', [TicketController::class, 'update']);

    // Social Link
    Route::post('/social-links', 'App\Http\Controllers\SocialLinkController@storeOrUpdate');
    Route::get('/all-social-links', 'App\Http\Controllers\SocialLinkController@index');

    // Guest
    Route::post('/guest', [GuestController::class, 'store']);
    Route::get('/all-guests', [GuestController::class, 'index']);
    Route::get('/search-guest', [GuestController::class, 'search']);

    // Guest Attendance
    Route::post('/guest-attendance', [GuestAttendanceController::class, 'store']);
    Route::get('/all-guest-attendances', [GuestAttendanceController::class, 'index']);
    // Route::get('/search', [UserController::class, 'search']);

    // client   registration
    Route::post('/client', 'App\Http\Controllers\ClientsController@store');
    Route::get('/all-clients', 'App\Http\Controllers\ClientsController@index');
    Route::get('/search-client', 'App\Http\Controllers\ClientsController@search');

    // Guest List
    Route::get('/guest-list',[GuestListController::class,'index']);
    Route::get('/search-guest',[GuestListController::class,'search']);


});
