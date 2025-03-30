<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MainController::class, 'startGame'])->name('start');
Route::post('/', [MainController::class, 'prepareGame'])->name('prepare');
