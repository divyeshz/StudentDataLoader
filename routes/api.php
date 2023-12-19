<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController, StudentController, ScheduleController};

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Authentication Routes Group
Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login')->name('login');
});

// Auth Middleware Routes Group
Route::group(['middleware' => ['auth:sanctum']], function () {

    // Authentication Routes Group
    Route::controller(AuthController::class)->group(function () {
        Route::post('logout', 'logout')->name('logout');
    });

    // Student Routes Group
    Route::controller(StudentController::class)->prefix('student')->group(function () {
        Route::post('import', 'import')->name('student.import');
        Route::post('export', 'export')->name('student.export');
    });

    // Schedule Routes Group
    Route::controller(ScheduleController::class)->prefix('schedule')->group(function () {
        Route::post('import', 'import')->name('schedule.import');
    });
});
