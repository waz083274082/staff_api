<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaffController;

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


// Note: No authentication required for this take home test.

// Get all staff records
Route::get('/staff', [StaffController::class, 'index']);

// Get a single staff record by ID
Route::get('/staff/{id}', [StaffController::class, 'show']);

// Create a new staff record
Route::post('/staff', [StaffController::class, 'store']);

// Update an existing staff record by ID
Route::put('/staff/{id}', [StaffController::class, 'update']);


// Delete a staff record by ID
Route::delete('/staff/{id}', [StaffController::class, 'destroy']);
