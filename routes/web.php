<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PastaController;
use App\Http\Controllers\MinumanController;
use App\Http\Controllers\AllMenuController;
use App\Http\Controllers\PizzaController;

Route::get('/', [AllMenuController::class, 'index']);
Route::get('/pasta', [PastaController::class, 'index']);
Route::get('/minuman', [MinumanController::class, 'index']);
Route::get('/pizza', [PizzaController::class, 'index']);
