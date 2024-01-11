<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserGroupController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function () {
    Route::post("login", "login");
    Route::post("register", "register");
});
Route::controller(UserController::class)->group(function () {
    Route::get("users", "index");
    Route::post("user", "store");
    Route::get("getUsersWithSpecifiedGroupId/{groupId?}", "getUsersWithSpecifiedGroupId");
    Route::get("user/{id}", "getSingleUser");
    Route::put("user/update/{id}", "update");
    Route::get("user/delete/{id}", "destroy");
});
Route::controller(UserGroupController::class)->group(function () {
    Route::get("usergroups", "index");
    Route::post("usergroup", "store");
    Route::get("getUsergroupsWithSpecifiedId/{id?}", "getUsergroupsWithSpecifiedId");
    Route::get("usergroup/{id}", "getSingleUsergroup");
    Route::put("usergroup/update/{id}", "update");
    Route::get("usergroup/delete/{id}", "destroy");
});
