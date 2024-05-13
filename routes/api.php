<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\PompaController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\PriorityController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\TaskCategoryController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\TaskScheduleController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\WorkOrderController;
use App\Models\Pompa;
use Illuminate\Http\Request;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', [LoginController::class, 'login'])->name('api.login');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('api.logout');

    //User
    Route::prefix('users')->apiResource('user', UserController::class, ['as' => 'api']);

    //Role
    Route::prefix('roles')->apiResource('role', RoleController::class, ['as' => 'api']);

    //Permissions
    Route::group(['prefix' => 'roles', 'as' => 'api.role.'], function () {
        Route::post('/permission', [RoleController::class, 'permissionStore'])->name('permission.store');
        Route::get('/permission', [RoleController::class, 'permissionList'])->name('permission.list');
    });

    //Task
    Route::group(['prefix' => 'tasks', 'as' => 'api.task.'], function () {
        Route::get('/', [TaskController::class, 'list'])->name('list');
        Route::post('/', [TaskController::class, 'store'])->name('store');
        Route::put('/{task}', [TaskController::class, 'update'])->name('update');
        Route::get('/{task}', [TaskController::class, 'show'])->name('show');
        Route::delete('/{task}', [TaskController::class, 'destroy'])->name('destroy');
    });

    //Task Categories
    Route::group(['prefix' => 'task-categories', 'as' => 'api.task-categories.'], function () {
        Route::get('/', [TaskCategoryController::class, 'list'])->name('list');
        Route::post('/', [TaskCategoryController::class, 'store'])->name('store');
        Route::put('/{task_category}', [TaskCategoryController::class, 'update'])->name('update');
        Route::get('/{task_category}', [TaskCategoryController::class, 'show'])->name('show');
        Route::delete('/{task_category}', [TaskCategoryController::class, 'store'])->name('destroy');
    });

    //Task Schedule
    Route::group(['prefix' => 'task-schedules', 'as' => 'api.task-schedules.'], function () {
        Route::get('/', [TaskScheduleController::class, 'list'])->name('list');
        Route::post('/', [TaskScheduleController::class, 'store'])->name('store');
        Route::put('/{task_schedule}', [TaskScheduleController::class, 'update'])->name('update');
        Route::get('/{task_schedule}', [TaskScheduleController::class, 'show'])->name('show');
        Route::delete('/{task_schedule}', [TaskScheduleController::class, 'destroy'])->name('destroy');
    });

    //Location
    Route::group(['prefix' => 'locations', 'as' => 'api.locations.'], function () {
        Route::get('/', [LocationController::class, 'list'])->name('list');
        Route::post('/', [LocationController::class, 'store'])->name('store');
        Route::put('/{location}', [LocationController::class, 'update'])->name('update');
        Route::get('/{location}', [LocationController::class, 'show'])->name('show');
        Route::delete('/{location}', [LocationController::class, 'destroy'])->name('destroy');
    });

    //Priorities
    Route::group(['prefix' => 'priorities', 'as' => 'api.priorities.'], function () {
        Route::get('/', [PriorityController::class, 'list'])->name('list');
        Route::post('/', [PriorityController::class, 'store'])->name('store');
        Route::put('/{priority}', [PriorityController::class, 'update'])->name('update');
        Route::get('/{priority}', [PriorityController::class, 'show'])->name('show');
        Route::delete('/{priority}', [PriorityController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'work-order', 'as' => 'api.work-order.'], function () {
        Route::get('/', [WorkOrderController::class, 'list'])->name('list');
        Route::get('/overview', [WorkOrderController::class, 'overview'])->name('overview');
        Route::post('/progress-task', [WorkOrderController::class, 'progressTask'])->name('progress-task');
        Route::post('/', [WorkOrderController::class, 'store'])->name('store');
        Route::put('/{work_order}', [WorkOrderController::class, 'update'])->name('update');
        Route::get('/{work_order}', [WorkOrderController::class, 'show'])->name('show');
        Route::delete('/{work_order}', [WorkOrderController::class, 'destroy'])->name('destroy');

        Route::post('/{work_order}/status', [WorkOrderController::class, 'updateStatus'])->name('update-status');
        Route::post('/{work_order}/task', [WorkOrderController::class, 'updateItem'])->name('update-item');

        Route::get('/report/daily' , [ReportController::class , 'reportSummaryDaily'])->name('report.daily');
        Route::get('/report/monthly' , [ReportController::class , 'reportWorkorderMontly'])->name('report.monthly');
    });

    //Pompa
    Route::group(['prefix' => 'pompas', 'as' => 'api.pompas.'], function () {
        Route::get('/', [PompaController::class, 'list'])->name('list');
        Route::post('/', [PompaController::class, 'store'])->name('store');
        Route::put('/{pompa}', [PompaController::class, 'update'])->name('update');
        Route::get('/{pompa}', [PompaController::class, 'show'])->name('show');
        Route::delete('/{pompa}', [PompaController::class, 'destroy'])->name('destroy');
    });


});