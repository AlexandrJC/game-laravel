<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', [GameController::class, 'index'])->name('index');
Route::post('start', [GameController::class, 'start'])->name('startgame');
Route::post('bet', [GameController::class, 'bet'])->name('makebet');
Route::get('newgame', [GameController::class, 'newgame'])->name('newgame');

