<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\EmailController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Auth routes
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);


// Route::middleware('auth:sanctum','access.permission:admin')->group(function () {
//     Route::apiResource('emails', EmailController::class);

//     // custom send
//     Route::post('emails/{email}/send', [EmailController::class, 'sendNow'])->name('emails.send');
// });


// Route::middleware(['auth:sanctum', 'access.permission:admin'])->group(function () {
//     Route::apiResource('emails', EmailController::class);
// });

// Route::middleware(['auth:sanctum','access.permission:user'])->group(function () {
//     Route::apiResource('emails', EmailController::class);
// });

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('emails', EmailController::class);
   Route::post('emails/{email}/retry', [EmailController::class, 'retry']);

});


