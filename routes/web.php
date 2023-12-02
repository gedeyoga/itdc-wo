<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\PriorityController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TaskCategoryController;
use App\Http\Controllers\Admin\TaskController;
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
    Route::get('/priorities' , [PriorityController::class, 'index'])->name('priorities.list');

    Route::get('/work-order' , [WorkOrderController::class, 'index'])->name('work-order.list');
});

Auth::routes();
