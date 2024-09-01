<?php

use App\Http\Controllers\Api\v1\RegisteredUserController;
use App\Http\Controllers\Api\v1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->middleware('cors')->group(function () {
    //условный CRUD пользователя
    Route::post('/register', [RegisteredUserController::class, 'store']);
    Route::get('/user/{id}', [UserController::class, 'show']);
    Route::get('/users/all', [UserController::class, 'index']);
    Route::patch('/user/{id}', [UserController::class, 'update']);

    //Отправка и верификация кода
    Route::post('/user/sendCode', [UserController::class, 'requestConfirmationCode']);
    Route::post('/user/verifyCode', [UserController::class, 'checkConfirmationCode']);
});
