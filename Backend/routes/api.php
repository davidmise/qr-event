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
use App\Http\Controllers\MediaController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\GuestAttendanceController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\ForgotPasswordController;


// Public routes (no authentication required)
Route::post('/register', 'App\Http\Controllers\UserController@create');

// Route::post('/login', [AuthRegisteredUserController::class, "login"])->name('login');
Route::post('/login', [AuthController::class, "login"])->name('login');

Route::post('forgot-password', 'App\Http\Controllers\ForgotPasswordController@sendResetLinkEmail');
Route::post('reset-password', 'App\Http\Controllers\ResetPasswordController@reset');


// Protected routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, "logout"]);

    // all users
    Route::get('/users', 'App\Http\Controllers\UserController@index');
    Route::get('/user{id}', 'App\Http\Controllers\UserController@show');
    Route::put('/update-user{id}', 'App\Http\Controllers\UserController@update');

    // EventInfo
    Route::get('/all-events', [EventInfoController::class, 'index']);
    Route::post('/create-event', [EventInfoController::class, 'store']);
    Route::get('/pull-event-info{id}', [EventInfoController::class,'show']);

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

    // Media
    Route::post('/media', [MediaController::class, 'store']);
    Route::get('/all-media', [MediaController::class, 'index']);

    // Guest
    Route::post('/guest', [GuestController::class, 'store']);
    Route::get('/all-guests', [GuestController::class, 'index']);

    // Guest Attendance
    Route::post('/guest-attendance', [GuestAttendanceController::class, 'store']);
    Route::get('/all-guest-attendances', [GuestAttendanceController::class, 'index']);

    // Qr-code
    Route::post('/generate-qrCode', [QrCodeController::class, 'generateQrCode']);
});
