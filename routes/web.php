<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\LocationInstallationController;
use App\Http\Controllers\Admin\PompaController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\PriorityController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TaskCategoryController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\TaskScheduleController;
use App\Http\Controllers\Admin\WorkOrderController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/' , function() {
    return redirect()->route('login');
});


Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    //users
    Route::resource('users', UserController::class);
    Route::get('/users/{user}/profile', [UserController::class, 'profile'])->name('users.profile');
    
    Route::resource('roles', RoleController::class);

    Route::get('/tasks' , [TaskController::class, 'index'])->name('tasks.list');
    Route::get('/task-categories' , [TaskCategoryController::class, 'index'])->name('task-categories.list');
    Route::get('/locations' , [LocationController::class, 'index'])->name('locations.list');
    Route::get('/task-schedules' , [TaskScheduleController::class, 'index'])->name('task-schedules.list');
    Route::get('/priorities' , [PriorityController::class, 'index'])->name('priorities.list');
    Route::get('/pompas' , [PompaController::class, 'index'])->name('pompas.list');
    Route::get('/location-installations' , [LocationInstallationController::class, 'index'])->name('location-installations.list');

    Route::get('/work-order' , [WorkOrderController::class, 'index'])->name('work-order.list');
    Route::get('/work-order/scan', [WorkOrderController::class, 'scan'])->name('work-order.scan');

    Route::get('/report/daily', [ReportController::class, 'daily'])->name('report.daily');
    Route::get('export/report/daily', [ReportController::class, 'reportDailyPdf'])->name('report.daily');
    
    Route::get('/report/monthly', [ReportController::class, 'monthly'])->name('report.monthly');

});

Auth::routes();
