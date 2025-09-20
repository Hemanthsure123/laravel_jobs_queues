<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QueueController;

Route::get('/queue-form', [QueueController::class, 'showForm']);
Route::post('/process-queue', [QueueController::class, 'processForm']);

Route::get('/', function () {
    return view('welcome');
})->name('home');