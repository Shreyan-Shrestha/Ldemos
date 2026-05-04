<?php

use App\Events\LoggedEvent;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LDemoController;
use App\Models\LDemo;
use App\Http\Controllers\OrderController;
use Spatie\Activitylog\Models\Activity;

Route::resource('orders', OrderController::class);


Route::get('/', [LDemoController::class, 'index'])->name('data.index');
Route::get('/activitylog', function () {
    return Activity::all()->last();
})->name('activitylog');

Route::prefix('data')->name('data.')->group(function (){
    Route::get('/demo1', [LDemoController::class, 'demo1'])->name('demo1');

    Route::get('/adddata', [LDemoController::class, 'addDataform'])->name('addDataForm');

    Route::post('/adddata', [LDemoController::class, 'addData'])->name('addData');

    Route::get('/deletedhistory', [LDemoController::class, 'deletedHistory'])->name('deletedHistory');
});

Route::get('/send-mail', [App\Http\Controllers\EmailController::class, 'sendEmail'])->name('sendMail');

Route::get('/health', fn() => response('OK', 200));