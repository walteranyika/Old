<?php

use App\Http\Controllers\MainAppController;
use Illuminate\Support\Facades\Route;

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

Route::post('/4dbbcf85b5bd89d2b4e783f1c6bc17d3', [MainAppController::class, 'ussdRequestHandler']);
