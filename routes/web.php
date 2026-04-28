<?php

use App\Events\LoggedEvent;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LDemoController;
use App\Models\LDemo;
Route::get('/', [LDemoController::class, 'index']);

Route::get('/demo1', [LDemoController::class, 'demo1']);

Route::get('/adddata', [LDemoController::class, 'addDataform'])->name('addDataForm');

Route::post('/adddata', [LDemoController::class, 'addData'])->name('addData');