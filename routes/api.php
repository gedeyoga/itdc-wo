<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
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
});