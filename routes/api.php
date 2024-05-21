<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('auth:sanctum')->post('/save_number', [HomeController::class, 'storePhoneNumber']);
Route::middleware('auth:sanctum')->get('/list_numbers', [HomeController::class, 'show']);
Route::middleware('auth:sanctum')->get('/sent_messages', [HomeController::class, 'showMessages']);
Route::middleware('auth:sanctum')->get('/recieved_messages', [HomeController::class, 'showInboxMessages']);
Route::middleware('auth:sanctum')->post('/custom_message', [HomeController::class, 'sendCustomMessage']);
Route::middleware('auth:sanctum')->post('/custom_mail', [HomeController::class, 'sendEmail']);
Route::post('/auth/register', [UserController::class, 'createUser']);
Route::get('/list_system_users', [UserController::class, 'show']);

Route::post('/auth/login', [UserController::class, 'loginUser']);
Route::middleware('auth:sanctum')->put('/user/{id}/update', [UserController::class, 'update']);

