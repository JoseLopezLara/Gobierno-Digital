<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// RUTAS QUE PASAN POR EL MIDDLEWARE DE API DE JWT PERO QUE ADEMAS ESTÁN PROTEGIDAS
Route::group([

    'middleware' => ['api', 'auth:api'],
    'prefix' => 'auth'

], function ($router) {

    //  Rutas focalizadas al sistema de autenticación JWT
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);

    //Rutas focalizadas a las operaciones crud que puede hacer un usario
    Route::get('/users', action: [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::post('/users', [UserController::class, 'store']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::patch('/users/{id}', [UserController::class, 'updatePartial']);
    Route::delete('/users/{id}', [UserController::class, 'delete']);
});

// RUTAS QUE PASAN POR EL MIDDLEWARE DE API PERO NO REQUIEREN EL TOKEN DE AUTENTICACIÓN
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
});
