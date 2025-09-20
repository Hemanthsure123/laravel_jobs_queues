<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QueueController;

Route::get('/queue-form', [QueueController::class, 'showForm']);
Route::post('/process-queue', [QueueController::class, 'processForm']);

use App\Http\Controllers\Auth\RegisterController;

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/', function () {
    return view('welcome');
})->name('home');