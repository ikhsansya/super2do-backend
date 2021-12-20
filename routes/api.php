<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
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

/**Route for Task API */
Route::group(['prefix' => 'v1'], function () {
    Route::get('task', [TaskController::class, 'index']);
    // Route::get('task/{id}', [TaskController::class, 'show']);
    Route::post('task', [TaskController::class, 'store']);
    Route::put('task/{id}', [TaskController::class, 'update']);
    Route::delete('task/{id}', [TaskController::class, 'destroy']);

    // Set status task
    Route::post('task/set-status/{id}', [TaskController::class, 'setStatus']);
    // Set all task to completed
    Route::post('task/set-complete-all', [TaskController::class, 'setCompleteAll']);
    // Delete all completed task
    Route::post('task/delete-all-complete', [TaskController::class, 'destroyAllComplete']);
    // Get Total
    Route::get('task/total', [TaskController::class, 'getTotal']);

});
