<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NoteController;

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

Route::post('/auth/checkusername', [AuthController::class, 'checkUsername']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/logout', [AuthController::class, 'logout']);
Route::post('/auth/register', [AuthController::class, 'register']);

Route::get('/notes', [NoteController::class, 'index']);
Route::post('/notes/createorupdate', [NoteController::class, 'createorupdate']);
Route::post('/notes/updateBookmated', [NoteController::class, 'updateBookmated']);

Route::get('{any?}', function () {
    return view('app');
})->where('any', '.*');