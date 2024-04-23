<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\TrainingReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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
Route::group(['prefix' => 'auth'], function () {
    // Auth
    Route::post('login', [AuthController::class, 'login']);

    Route::group(['middleware' => 'auth:api'], function () {
        // User
        Route::get('user', [UserController::class, 'getUser']);
        Route::get('runners', [UserController::class, 'getRunners']);
        Route::post('addUser', [UserController::class, 'addUser']);
        Route::put('updateUser/{id}', [UserController::class, 'updateUser']);
        Route::delete('deleteUser/{id}', [UserController::class, 'deleteUser']);

        // Training
        Route::get('trainings', [TrainingController::class, 'getTrainings']);
        Route::post('addTraining', [TrainingController::class, 'addTraining']);
        Route::put('updateTraining/{id}', [TrainingController::class, 'updateTraining']);
        Route::delete('deleteTraining/{id}', [TrainingController::class, 'deleteTraining']);

        // TrainingReport
        Route::get('userTrainingReports', [TrainingReportController::class, 'getUserTrainingReports']);
        Route::post('addUserReport', [TrainingReportController::class, 'addUserReport']);
    });
});
