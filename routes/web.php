<?php

use Illuminate\Support\Facades\Route;
use App\Models\Email;

use Illuminate\Support\Facades\Mail;
use App\Mail\EmailNotification;
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
Route::get('/admin/{any}', function () {
    return view('admin');
})->where('any', '.*');


Route::get('/user/{any}', function () {
    return view('user'); 
})->where('any', '.*');
Route::get('/test-mail', function () {
    $email = Email::create([
        'email' => 'duongvuvy141@gmail.com',
        'subject' => 'Test email',
        'body' => 'Nội dung test email',
    ]);

    Mail::to($email->email)->send(new EmailNotification($email));

    return 'Mail sent!';
});