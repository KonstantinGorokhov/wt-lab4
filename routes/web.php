<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PresidentController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Главная
|--------------------------------------------------------------------------
*/
Route::get("/", fn() => redirect()->route("presidents.index"));

/*
|--------------------------------------------------------------------------
| ПУБЛИЧНЫЕ РОУТЫ (гость + авторизованный)
|--------------------------------------------------------------------------
*/
Route::get("/presidents", [PresidentController::class, "index"])->name(
    "presidents.index",
);

Route::get("/presidents/{president}", [PresidentController::class, "show"])
    ->whereNumber("president")
    ->name("presidents.show");

Route::get("/users", [UserController::class, "index"])->name("users.index");

/*
|--------------------------------------------------------------------------
| ТОЛЬКО АВТОРИЗОВАННЫЕ
|--------------------------------------------------------------------------
*/
Route::middleware("auth")->group(function () {
    // создание
    Route::get("/presidents/create", [
        PresidentController::class,
        "create",
    ])->name("presidents.create");

    Route::post("/presidents", [PresidentController::class, "store"])->name(
        "presidents.store",
    );

    // редактирование
    Route::get("/presidents/{president}/edit", [
        PresidentController::class,
        "edit",
    ])->name("presidents.edit");

    Route::put("/presidents/{president}", [
        PresidentController::class,
        "update",
    ])->name("presidents.update");

    // soft delete
    Route::delete("/presidents/{president}", [
        PresidentController::class,
        "destroy",
    ])->name("presidents.destroy");

    // 🔥 ВОССТАНОВЛЕНИЕ (админ ИЛИ владелец)
    Route::patch("/presidents/{id}/restore", [
        PresidentController::class,
        "restore",
    ])->name("presidents.restore");
});

/*
|--------------------------------------------------------------------------
| ТОЛЬКО АДМИН
|--------------------------------------------------------------------------
*/
Route::middleware(["auth", "can:manage-users"])->group(function () {
    // force delete президентов
    Route::delete("/presidents/{id}/force", [
        PresidentController::class,
        "forceDelete",
    ])->name("presidents.forceDelete");

    // пользователи
    Route::delete("/users/{user}", [UserController::class, "destroy"])->name(
        "users.destroy",
    );

    Route::patch("/users/{id}/restore", [
        UserController::class,
        "restore",
    ])->name("users.restore");

    Route::delete("/users/{id}/force", [
        UserController::class,
        "forceDelete",
    ])->name("users.forceDelete");
});

/*
|--------------------------------------------------------------------------
| AUTH (Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__ . "/auth.php";
