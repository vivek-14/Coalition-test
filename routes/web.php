<?php

use App\Http\Controllers\TaskController;
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
Route::get('/', [TaskController::class, 'index']);
Route::patch('/task/priority/update/{id}', [TaskController::class, 'updatePriority'])->name('task.priority.update');
Route::patch('/task/update/{id}', [TaskController::class, 'update']);
Route::post('/task/add', [TaskController::class, 'store']);
Route::delete('/task/delete/{id}', [TaskController::class, 'destroy']);


// i usually use resourece here however somehow my router is not picking up resource actions something with  csrf token i guess.
// Route::resource('/', TaskController::class);
