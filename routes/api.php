<?php

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

Route::post("/login", [App\Http\Controllers\Api\Dashboard\LoginController::class, "index"]);
Route::prefix("dashboard")
    ->middleware(["auth:api", "admin"])
    ->group(function () {
        Route::get("/user", [App\Http\Controllers\Api\Dashboard\LoginController::class, "getUser"]);
        Route::get("/refresh", [
            App\Http\Controllers\Api\Dashboard\LoginController::class,
            "refreshToken",
        ]);
        Route::post("/logout", [
            App\Http\Controllers\Api\Dashboard\LoginController::class,
            "logout",
        ]);
        Route::get("/count", [
            App\Http\Controllers\Api\Dashboard\DashboardController::class,
            "index",
        ]);
        Route::get("/post", [
            App\Http\Controllers\Api\Dashboard\DashboardController::class,
            "singlePost",
        ]);
        Route::get("/product", [
            App\Http\Controllers\Api\Dashboard\DashboardController::class,
            "singleProduct",
        ]);
    });

Route::prefix("mobile")
    ->middleware(["auth:api", "user"])
    ->group(function () {});
