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
        Route::get("transactions/{id}/status/{status}", [
            App\Http\Controllers\Api\Dashboard\TransactionController::class,
            "changeStatus",
        ]);
        Route::apiResource(
            "/categories",
            App\Http\Controllers\Api\Dashboard\CategoryController::class,
        );
        Route::apiResource("/posts", App\Http\Controllers\Api\Dashboard\PostController::class);
        Route::apiResource(
            "/products",
            App\Http\Controllers\Api\Dashboard\ProductController::class,
        );
        Route::apiResource(
            "/transactions",
            App\Http\Controllers\Api\Dashboard\TransactionController::class,
        );
        Route::apiResource("/users", App\Http\Controllers\Api\Dashboard\UserController::class);
        Route::apiResource(
            "/comments",
            App\Http\Controllers\Api\Dashboard\CommentController::class,
        );
    });

Route::post("/login", [App\Http\Controllers\Api\Dashboard\LoginController::class, "index"]);
Route::post("/register", [App\Http\Controllers\Api\Mobile\UserController::class, "store"]);
Route::post("/payment-notif", [
    App\Http\Controllers\Api\Dashboard\MidtransController::class,
    "callback",
]);

Route::prefix("mobile")
    ->middleware(["auth:api", "user"])
    ->group(function () {
        Route::get("/user", [App\Http\Controllers\Api\Mobile\UserController::class, "getUser"]);
        Route::get("/user/{id}", [App\Http\Controllers\Api\Mobile\UserController::class, "show"]);
        Route::post("/checkout", [
            App\Http\Controllers\Api\Mobile\UserController::class,
            "checkout",
        ]);
        Route::get("/categories", [
            App\Http\Controllers\Api\Mobile\CategoryController::class,
            "index",
        ]);
        Route::get("/allcategories", [
            App\Http\Controllers\Api\Mobile\CategoryController::class,
            "all",
        ]);
        Route::get("/categoriessecond", [
            App\Http\Controllers\Api\Mobile\CategoryController::class,
            "indexSecond",
        ]);
        Route::get("/category/{slug}", [
            App\Http\Controllers\Api\Mobile\CategoryController::class,
            "show",
        ]);
        Route::get("/categoryproduct/{slug}", [
            App\Http\Controllers\Api\Mobile\CategoryController::class,
            "showProduct",
        ]);
        Route::get("/post", [App\Http\Controllers\Api\Mobile\PostController::class, "index"]);
        Route::get("/singlepost", [
            App\Http\Controllers\Api\Mobile\PostController::class,
            "singlePost",
        ]);
        Route::get("/post/{slug}", [App\Http\Controllers\Api\Mobile\PostController::class, "show"]);
        Route::post("/comment", [
            App\Http\Controllers\Api\Mobile\PostController::class,
            "storeComment",
        ]);
        Route::get("/product", [App\Http\Controllers\Api\Mobile\ProductController::class, "all"]);
        Route::get("/product/{id}", [
            App\Http\Controllers\Api\Mobile\ProductController::class,
            "show",
        ]);
        Route::get("/comments", [
            App\Http\Controllers\Api\Mobile\CommentController::class,
            "index",
        ]);
    });
