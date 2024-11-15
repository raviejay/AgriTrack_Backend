<?php

use App\Http\Controllers\AnimalController;
use App\Http\Controllers\DataEntryController;
use App\Http\Controllers\KindOfAnimalController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GetYearlyDataController;
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

// Public routes (no authentication needed)
Route::post('/register', [UserController::class, 'store']);
Route::post('/login', [UserAuthController::class, 'login']);

Route::post('/dataEntry', [DataEntryController::class, 'store']);

// Protected routes (authentication required)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/animal', [AnimalController::class, 'store']);
    Route::get('/animal/count', [AnimalController::class, 'getAnimalCount']);
    Route::get('/getanimal', [AnimalController::class, 'index']);
    
    Route::post('/kfanimal', [KindOfAnimalController::class, 'store']);
    Route::get('/getkfanimal', [KindOfAnimalController::class, 'index']);
    Route::get('/profile', [UserAuthController::class, 'getUserInfo']);
    
    Route::get('/livestock/total', [GetYearlyDataController::class, 'getTotalLivestockData']);
    Route::get('/livestock/currentyeartotal', [GetYearlyDataController::class, 'getTotalLivestockDataForCurrentYear']);
    Route::get('/livestock/YearsData', [GetYearlyDataController::class, 'getTotalLivestockDataByYear']);
    
    // Add more protected routes here if needed
});
Route::middleware('auth:sanctum')->get('/user', [UserAuthController::class, 'getUserInfo']);

Route::middleware('auth:sanctum')->post('/logout', [UserAuthController::class, 'logout']);
